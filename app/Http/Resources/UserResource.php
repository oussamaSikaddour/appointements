<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        // Helper to select localized fields dynamically
        $name = $locale === 'ar' ? $this->name_ar : $this->name_fr;

        return [
            'id' => $this->id,
            'name' => $name,
            'email' => $this->email,
            'isActive' => (bool) $this->is_active,
            'isPaid' => (bool) $this->is_paid,
            'employeeNumber' => $this->employee_number,
            'createdAt' => $this->created_at?->toISOString(),
            'updatedAt' => $this->updated_at?->toISOString(),

            // Related resources
            'personnelInfo' => new PersonnelInfoResource($this->whenLoaded('personnelInfo')),
            'occupations' => OccupationResource::collection($this->whenLoaded('occupations')),
            'bankingInformation' => BankingInformationResource::collection($this->whenLoaded('bankingInformation')),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'medicalFiles' => MedicalFileResource::collection($this->whenLoaded('medicalFiles')),
        ];
    }
}
