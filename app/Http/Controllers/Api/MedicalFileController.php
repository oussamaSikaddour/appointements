<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalFile\CreateRequest;
use App\Http\Requests\MedicalFile\UpdateRequest;
use App\Http\Resources\MedicalFileResource;
use App\Models\MedicalFile;
use App\Traits\Api\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MedicalFileController extends Controller
{
    use ResponseTrait;

    /**
     * Display a paginated list of medical files with optional filtering.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $locale =in_array(app()->getLocale(), ['fr', 'ar']) ? app()->getLocale() : 'fr';
            $perPage = (int) $request->input('perPage', 15);
            $sortBy = $request->input('sortBy', 'created_at');
            $sortDirection = $request->input('sortDirection', 'desc');
            $name = $request->input('name');

            $columns = preg_match('/\p{Arabic}/u', $name ?? '')
                ? ['last_name_ar', 'first_name_ar']
                : ["last_name_{$locale}", "first_name_{$locale}"];

            $query = MedicalFile::query()
                ->when($request->filled('doctorId'), function ($q) use ($request) {
                    $q->whereExists(function ($sub) use ($request) {
                        $sub->select(DB::raw(1))
                            ->from('appointments')
                            ->whereColumn('appointments.patient_id', 'medical_files.id')
                            ->where('appointments.doctor_id', $request->doctorId);
                    });
                })
                ->when(!$request->filled('doctorId') && $request->filled('openedById'), fn($q) =>
                    $q->where('opened_by', $request->openedById)
                )
                ->when($request->filled('name'), function ($q) use ($columns, $name) {
                    $q->where(function ($query) use ($columns, $name) {
                        foreach ($columns as $column) {
                            $query->orWhere($column, 'like', "%{$name}%");
                        }
                    });
                })
                ->when($request->filled('year'), fn($q) =>
                    $q->whereYear('created_at', $request->year)
                )
                ->orderBy($sortBy, $sortDirection)
                ->paginate($perPage)
                ->appends($request->only(['perPage', 'openedById', 'name', 'year', 'sortBy', 'sortDirection']));

            return $this->responseCollection(
                'medical_file',
                MedicalFileResource::collection($query),
                [
                    'current_page' => $query->currentPage(),
                    'from' => $query->firstItem(),
                    'last_page' => $query->lastPage(),
                    'per_page' => $query->perPage(),
                    'to' => $query->lastItem(),
                    'total' => $query->total(),
                ],
                [
                    'first' => $query->url(1),
                    'last' => $query->url($query->lastPage()),
                    'prev' => $query->previousPageUrl(),
                    'next' => $query->nextPageUrl(),
                ]
            );

        } catch (\Throwable $e) {
            Log::error('MedicalFileController@index error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->responseError('medical_file', __('forms.common.errors.default'), 'index_failed', 500);
        }
    }

    /**
     * Store a newly created medical file.
     */
    public function store(string $lang, CreateRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['code'] = $this->generateCode($data['gender']);
            $medicalFile = MedicalFile::create($data);

            return $this->responseSuccess(
                'medical_file',
                $medicalFile->id,
                [
                    'message' => __('forms.medical_file.responses.add_success'),
                    'data'    => new MedicalFileResource($medicalFile),
                ]
            );

        } catch (\Throwable $e) {
            Log::error('MedicalFileController@store error', [
                'request_data' => $request->all(),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->responseError('medical_file', __('forms.common.errors.default'), 'store_failed', 500);
        }
    }

    /**
     * Display a specific medical file.
     */
    public function show(string $lang, MedicalFile $medicalFile): JsonResponse
    {
        try {
            return $this->responseSuccess(
                'medical_file',
                $medicalFile->id,
                ['data' => new MedicalFileResource($medicalFile)]
            );

        } catch (\Throwable $e) {
            Log::error('MedicalFileController@show error', [
                'id' => $medicalFile->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->responseError('medical_file', __('forms.common.errors.default'), 'show_failed', 500);
        }
    }

    /**
     * Update a medical file.
     */
    public function update(string $lang, UpdateRequest $request, MedicalFile $medicalFile): JsonResponse
    {
        try {
            $medicalFile->update($request->validated());

            return $this->responseSuccess(
                'medical_file',
                $medicalFile->id,
                [
                    'message' => __('forms.medical_file.responses.update_success'),
                    'data'    => new MedicalFileResource($medicalFile),
                ]
            );

        } catch (\Throwable $e) {
            Log::error('MedicalFileController@update error', [
                'id' => $medicalFile->id,
                'request_data' => $request->all(),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->responseError('medical_file', __('forms.common.errors.default'), 'update_failed', 500);
        }
    }

    /**
     * Remove a medical file (soft delete).
     */
    public function destroy(string $lang, MedicalFile $medicalFile): JsonResponse
    {
        try {
            if ($medicalFile->opened_by !== auth()->id()) {
                return $this->responseError(
                    'medical_file',
                    __('api.medical_file.responses.unauthorized_delete'),
                    'unauthorized',
                    403
                );
            }

            $medicalFile->delete();

            return $this->responseSuccess(
                'medical_file',
                $medicalFile->id,
                ['message' => __('api.medical_file.responses.destroy')]
            );

        } catch (\Throwable $e) {
            Log::error('MedicalFileController@destroy error', [
                'id' => $medicalFile->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->responseError('medical_file', __('forms.common.errors.default'), 'destroy_failed', 500);
        }
    }

    /**
     * Generate a unique medical file code based on gender, year, and month.
     */
    private function generateCode(string $gender): string
    {
        $genderCode = ['male' => 'M', 'female' => 'F', 'other' => 'O'][$gender] ?? 'O';
        $year = now()->format('y');
        $month = now()->format('m');

        $lastFile = MedicalFile::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->orderByDesc('id')
            ->first();

        $nextNumber = $lastFile && $lastFile->code
            ? ((int) substr($lastFile->code, -6)) + 1
            : 1;

        return $genderCode . $year . $month . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }
}
