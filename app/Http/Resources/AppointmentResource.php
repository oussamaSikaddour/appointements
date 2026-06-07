<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'initiator' => $this->initiator,

            // Date fields (Carbon instances if casted in model)
            'dayAt' => $this->day_at,
            'createdAt' => $this->created_at?->toISOString(),
            'updatedAt' => $this->updated_at?->toISOString(),

            // Relations
            'patient' => $this->whenLoaded('patient', new MedicalFileResource($this->patient)),
            'doctor' => $this->whenLoaded('doctor', new UserResource($this->doctor)),

            'specialty' => $this->whenLoaded('specialty', function () {
                return [
                    'id' => $this->specialty->id,
                    'name' => $this->specialty->localized_designation
                        ?? $this->specialty->localized_fr,
                ];
            }),

            'scheduleDay' => $this->whenLoaded('scheduleDay', new ScheduleDayResource($this->scheduleDay)),

            'appointmentsLocation' => $this->whenLoaded('appointmentsLocation', function () {
                return [
                    'id' => $this->appointmentsLocation->id,
                    'name' => $this->appointmentsLocation->getLocalizedNameAttribute(),
                ];
            }),

            'referralLetter' => $this->whenLoaded('referralLetter', new ImageResource($this->referralLetter)),
        ];
    }
}
