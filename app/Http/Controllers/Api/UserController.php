<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BulkInsertRequest;
use App\Http\Requests\User\PatchRequest;
use App\Http\Resources\UserResource;
use App\Models\File;
use App\Models\Image;
use App\Models\User;
use App\Traits\Api\ImportTrait;
use App\Traits\Api\ResponseTrait;
use App\Traits\Common\ModelFileTrait;
use App\Traits\Common\ModelImageTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    use ResponseTrait, ModelImageTrait, ModelFileTrait, ImportTrait;

    private string $locale;
    private string $localeArAndFrOnly;

    public function __construct()
    {
        $this->localeArAndFrOnly = in_array(app()->getLocale(), ['fr', 'ar']) ? app()->getLocale() : 'fr';
        $this->locale =  app()->getLocale();
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = (int) $request->input('perPage', 15);

            $query = User::with(['personnelInfo', 'service', 'establishment', 'occupations.specialty', 'occupations.grade'])
                ->when($request->filled('fullName'), function ($q) use ($request) {
                    $containsArabic = preg_match('/\p{Arabic}/u', $request->fullName);
                    $column = $containsArabic ? 'name_ar' : "name_{$this->localeArAndFrOnly}";
                    $q->where($column, 'like', "%{$request->fullName}%");
                })
                ->when($request->filled('establishmentId'), fn($q) => $q->where('establishment_id', $request->establishmentId))
                ->when($request->filled('serviceId'), fn($q) => $q->where('service_id', $request->serviceId))
                ->when($request->filled('email'), fn($q) => $q->where('email', 'like', "%{$request->email}%"))
                ->when($request->filled('employeeNumber'), fn($q) =>
                    $q->whereHas('personnelInfo', fn($q) =>
                        $q->where('employee_number', 'like', "%{$request->employeeNumber}%")
                    )
                )
                ->orderBy($request->input('sortBy', 'id'), $request->input('sortDirection', 'asc'))
                ->paginate($perPage)
                ->appends($request->only(['perPage', 'sortBy', 'sortDirection', 'with', 'fullName', 'establishmentId', 'serviceId', 'email', 'employeeNumber']));

            $data = $query->getCollection()->map(fn($user) => [
                'id' => $user->id,
                'name_fr' => $user->name_fr,
                'name_ar' => $user->name_ar,
                'email' => $user->email,
                'is_active' => $user->is_active,
                'employee_number' => $user->personnelInfo?->employee_number,
                'social_number' => $user->personnelInfo?->social_number,
                'card_number' => $user->personnelInfo?->card_number,
                'birth_date' => $user->personnelInfo?->birth_date,
                'birth_place_fr' => $user->personnelInfo?->birth_place_fr,
                'birth_place_ar' => $user->personnelInfo?->birth_place_ar,
                'birth_place_en' => $user->personnelInfo?->birth_place_en,
                'phone' => $user->personnelInfo?->phone,
                'service_name' => $user->service?->{"name_{$this->locale}"},
                'establishment_name' => $user->establishment?->acronym,
                'specialty' => $user->occupations->firstWhere('is_active', true)?->specialty?->getLocalizedDesignationAttribute(),
                'grade' => $user->occupations->firstWhere('is_active', true)?->grade?->getLocalizedDesignationAttribute(),
            ]);

            $query->setCollection($data);

            return $this->responseCollection('user', $query);

        } catch (\Throwable $e) {
            Log::error('UserController@index error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return $this->responseError(__('forms.common.errors.default'), 500);
        }
    }

    public function show(string $lang, User $user): JsonResponse
    {
        try {
            $user->loadMissing(['personnelInfo', 'occupations', 'bankingInformation', 'images', 'files', 'medicalFiles']);
            return $this->responseSuccess('users', $user->id, ['user' => new UserResource($user)]);
        } catch (\Throwable $e) {
            Log::error('UserController@show error', ['user_id' => $user->id ?? null, 'error' => $e->getMessage()]);
            return $this->responseError('users', __('forms.common.errors.default'), 'show_failed', 500);
        }
    }

    public function update(string $lang, PatchRequest $request, User $user): JsonResponse
    {
        try {
            $data = $request->validated();
            return DB::transaction(function () use ($data, $user, $request) {
                $user->personnelInfo?->update($data['personnelInfo']);

                if ($request->hasFile('image')) {
                    $this->uploadAndUpdateImage($request->file('image'), $user->id, User::class, 'profile_pic');
                }

                $user->update(array_merge($data['default'], [
                    'name_fr' => "{$data['personnelInfo']['last_name_fr']} {$data['personnelInfo']['first_name_fr']}",
                    'name_ar' => "{$data['personnelInfo']['last_name_ar']} {$data['personnelInfo']['first_name_ar']}",
                ]));

                return $this->responseSuccess('users', $user->id, ['user' => new UserResource($user)]);
            });
        } catch (\Throwable $e) {
            Log::error('UserController@update error', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            return $this->responseError(__('forms.common.errors.default'), 500);
        }
    }

    public function destroy(string $lang, User $user): JsonResponse
    {
        try {
            $currentUser = Auth::user();
            if ($user->id !== $currentUser->id) {
                return $this->responseError('users', __('api.users.destroy.no-access'), 'no_access', 429);
            }

            $this->deleteImages(Image::where('imageable_id', $user->id)->where('imageable_type', User::class)->get());
            $this->deleteFiles(File::where('fileable_id', $user->id)->where('fileable_type', User::class)->get());

            $user->delete();

            return $this->responseSuccess('users', null, ['message' => __('api.users.responses.destroy')]);
        } catch (\Throwable $e) {
            Log::error('UserController@destroy error', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            return $this->responseError('users', __('forms.common.errors.default'), 'destroy_failed', 500);
        }
    }

    public function bulkAddUsers(BulkInsertRequest $request): JsonResponse
    {
        try {
            $this->handleExcelImport($request->file('file'), 'StaffImport');
            return $this->responseSuccess('users', null, ['message' => __('api.users.responses.bulk_insert_success')]);
        } catch (\Throwable $e) {
            return $this->responseError('users', $e->getMessage(), 'bulk_insert_validation', 422, true);
        }
    }
}
