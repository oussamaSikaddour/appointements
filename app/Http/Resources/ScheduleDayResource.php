<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleDayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'dayAt' => $this->day_at?->toDateString(),
            'availableNumber' => $this->available_number,
            'confirmedNumber' => $this->confirmed_number,
            'cancelledNumber' => $this->cancelled_number ?? 0,
            'state' => $this->state,

            // Minimal appointment location info if loaded
            'appointmentLocation' => $this->whenLoaded('appointmentsLocation', function () {
                return [
                    'id' => $this->appointmentsLocation->id,
                    'name' => $this->appointmentsLocation->localizedName,
                ];
            }),

            // Doctor info
            'doctor' => new UserResource($this->whenLoaded('doctor')),

            // Specialty info
            'specialty' => $this->whenLoaded('specialty', function () {
                return [
                    'id' => $this->specialty->id,
                    'name' => $this->specialty->{"name_" . app()->getLocale()} ?? $this->specialty->name_fr,
                ];
            }),

            // Appointments for this schedule day
            'appointments' => AppointmentResource::collection($this->whenLoaded('appointments')),

            'createdAt' => $this->created_at?->toISOString(),
            'updatedAt' => $this->updated_at?->toISOString(),
        ];
    }
}
