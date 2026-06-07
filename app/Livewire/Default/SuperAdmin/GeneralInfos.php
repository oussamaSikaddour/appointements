<?php

namespace App\Livewire\Default\SuperAdmin;

use App\Livewire\Forms\GeneralInfos\ManageForm;
use App\Models\GeneralSetting;
use App\Models\Image;
use App\Traits\Common\GeneralTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class GeneralInfos extends Component
{
    use WithFileUploads, GeneralTrait;

    public ManageForm $form;
    public GeneralSetting $gSetting;
    public string $temporaryImageUrl = "";
    public bool $isSubmitting = false;

    public function updated($property): void
    {
        if ($property === "form.logo") {
            try {
                $this->temporaryImageUrl = $this->form->logo?->temporaryUrl() ?? "";
            } catch (\Exception $e) {
                $this->dispatch('open-errors', __('forms.common.errors.img.not_img'));
            }
        }
    }

    public function mount(): void
    {
        try {
            $this->gSetting = GeneralSetting::first();
            $logo = Image::where('imageable_id', $this->gSetting->id)
                ->where('imageable_type', 'App\Models\GeneralSetting')
                ->where('use_case', 'logo')->first();
            $this->temporaryImageUrl = $logo?->url ?? "";

            $this->form->fill([
                'id' => $this->gSetting->id,
                'landline' => $this->gSetting->landline,
                'email' => $this->gSetting->email,
                'phone' => $this->gSetting->phone,
                'fax' => $this->gSetting->fax,
                'map' => $this->gSetting->map,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $this->dispatch('open-errors', __('modals.common.not-found'));
        } catch (\Exception $e) {
            Log::error('Error in GeneralInfos mount method: ' . $e->getMessage());
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    public function handleSubmit(): void
    {
        $this->isSubmitting = true;
        $this->dispatch('form-submitted');

        $response = $this->form->save($this->gSetting);

        if ($response['status']) {
            $this->dispatch('logo-updated');
            $this->dispatch('open-toast', $response['message']);
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }

        $this->isSubmitting = false;
    }

    public function render()
    {
        return view('livewire.default.super-admin.general-infos');
    }
}
