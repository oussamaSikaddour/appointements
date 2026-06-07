<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Occupation\CreateRequest;
use App\Http\Requests\Occupation\UpdateRequest;
use App\Http\Resources\OccupationResource;
use App\Models\Occupation;
use App\Models\User;
use App\Traits\Api\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class OccupationController extends Controller
{
    use ResponseTrait;

    /**
     * List all occupations for the specified user.
     */
    public function index(string $lang, User $user): JsonResponse
    {
        try {
            $occupations = $user->occupations()->latest()->get();

            return $this->responseCollection(
                'occupation',
                OccupationResource::collection($occupations),
                ['message' => __('forms.occupation.responses.index_success', ['user' => $user->name])]
            );

        } catch (\Throwable $e) {
            Log::error("OccupationController@index error: {$e->getMessage()}", [
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->responseError('occupation', __('forms.common.errors.default'), 'server_error', 500);
        }
    }

    /**
     * Create a new occupation for a user.
     */
    public function store(string $lang, CreateRequest $request, User $user): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['user_id'] = $user->id;

            $occupation = $user->occupations()->create($data);

            return $this->responseSuccess('occupation', $occupation->id, [
                'message' => __('forms.occupation.responses.add_success', ['user' => $user->name]),
                'occupation' => $occupation,
            ]);

        } catch (\Throwable $e) {
            Log::error("OccupationController@store error: {$e->getMessage()}", [
                'target_user_id' => $user->id,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->responseError('occupation', __('forms.common.errors.default'), 'server_error', 500);
        }
    }

    /**
     * Show a specific occupation for a user.
     */
    public function show(string $lang, User $user, Occupation $occupation): JsonResponse
    {
        try {
            return $this->responseSuccess('occupation', $occupation->id, [
                'occupation' => new OccupationResource($occupation),
            ]);

        } catch (\Throwable $e) {
            Log::error("OccupationController@show error: {$e->getMessage()}", [
                'target_user_id' => $user->id,
                'occupation_id' => $occupation->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->responseError('occupation', __('forms.common.errors.default'), 'server_error', 500);
        }
    }

    /**
     * Update a specific occupation for a user.
     */
    public function update(string $lang, UpdateRequest $request, User $user, Occupation $occupation): JsonResponse
    {
        try {
            $validated = $request->validated();
            $occupation->update($validated);

            return $this->responseSuccess('occupation', $occupation->id, [
                'message' => __('forms.occupation.responses.update_success'),
                'occupation' => $occupation,
            ]);

        } catch (\Throwable $e) {
            Log::error("OccupationController@update error: {$e->getMessage()}", [
                'target_user_id' => $user->id,
                'occupation_id' => $occupation->id,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->responseError('occupation', __('forms.common.errors.default'), 'server_error', 500);
        }
    }

    /**
     * Delete the specified occupation.
     */
    public function destroy(string $lang, Occupation $occupation): JsonResponse
    {
        try {
            $occupation->delete();

            return $this->responseSuccess('occupation', $occupation->id, [
                'message' => __('forms.occupation.responses.delete_success'),
            ]);

        } catch (\Throwable $e) {
            Log::error("OccupationController@destroy error: {$e->getMessage()}", [
                'occupation_id' => $occupation->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->responseError('occupation', __('forms.common.errors.default'), 'server_error', 500);
        }
    }
}
