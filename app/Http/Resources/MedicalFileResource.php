<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fullName' => $this->localizedFullName,  // localized full name
            'firstName' => $this->localizedFirstName,
            'lastName' => $this->localizedLastName,
            'gender' => $this->gender,
            'birthDate' => optional($this->birth_date)?->toDateString(),
            'birthPlace' => match (app()->getLocale()) {
                'ar' => $this->birth_place_ar,
                'en' => $this->birth_place_en,
                default => $this->birth_place_fr,
            },
            'address' => match (app()->getLocale()) {
                'ar' => $this->address_ar,
                'en' => $this->address_en,
                default => $this->address_fr,
            },
            'tel' => $this->tel,
            'code' => $this->code,
            'insuranceNumber' => $this->insurance_number,
            'openedBy' => $this->whenLoaded('openedBy', fn() => new UserResource($this->openedBy)),

            'appointmentsCount' => $this->appointments_count, // eager loaded count
            'appointments' => AppointmentResource::collection($this->whenLoaded('appointments')),
            'files' => FileResource::collection($this->whenLoaded('files')),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'createdAt' => $this->created_at?->toISOString(),
            'updatedAt' => $this->updated_at?->toISOString(),
        ];
    }
}
