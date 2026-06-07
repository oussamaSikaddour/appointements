<?php

namespace App\Livewire\Default;

use App\Livewire\Forms\User\AddForm;
use App\Livewire\Forms\User\UpdateForm;
use App\Models\Image;
use App\Models\Service;
use App\Models\User;
use App\Traits\Common\GeneralTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UserModal extends Component
{
    use WithFileUploads, GeneralTrait;

    /* -------------------- Forms -------------------- */
    public AddForm $addForm;
    public UpdateForm $updateForm;

    /* -------------------- Models & State -------------------- */
    public User $user;
    public $id;
    public $form = "addForm";
    public $local = 'fr';

    public $temporaryImageUrl;
    public $isPaidCheckBoxValue;
    public $isActiveCheckBoxValue;
    public $establishmentId;
    public $serviceId;

    public $servicesOptions = [];

    /* -------------------- Computed -------------------- */

    #[Computed()]
    public function services()
    {
        return Service::query()
            ->whereHas('establishment', fn ($q) => $q->where('establishment_id', $this->establishmentId))
            ->get(['id', 'name_' . $this->local]);
    }

    #[Computed()]
    public function formEntity()
    {
        return $this->id ? $this->updateForm : $this->addForm;
    }

    /* -------------------- Lifecycle -------------------- */

    public function mount(): void
    {

        $this->local = app()->getLocale();
        $this->temporaryImageUrl = asset('img/default.png');

        if ($this->id) {
            $this->form = "updateForm";
            $this->loadUserDataSafe();
        } else {
            $this->addForm->fill([
                'default.establishment_id' => $this->establishmentId,
                'default.service_id' => $this->serviceId,
            ]);
        }

        $this->servicesOptions = $this->populateSelectorOption(
            $this->services(),
            'id',
            'name_' . $this->local,
            __('selectors.default.services')
        );
    }

    /* -------------------- Data Loading -------------------- */

    protected function loadUserDataSafe(): void
    {
        try {
            $this->loadUserData();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $this->logModelError($e);
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    protected function loadUserData(): void
    {
        $this->user = User::with('personnelInfo')->findOrFail($this->id);
        $profilePic = Image::where('imageable_id', $this->user->id)
            ->where('imageable_type', User::class)
            ->where('use_case', 'profile_pic')
            ->first();

        $this->temporaryImageUrl = $profilePic?->url ?? $this->temporaryImageUrl;

        $this->isPaidCheckBoxValue = $this->user->personnelInfo?->is_paid === 1;
        $this->isActiveCheckBoxValue = $this->user->is_active === 1;

        $this->fillUpdateForm();
    }

    protected function fillUpdateForm(): void
    {
        $this->updateForm->fill([
            'default.establishment_id' => $this->user->establishment_id,
            'default.service_id' => $this->user->service_id,
            'default.id' => $this->id,
            'default.email' => $this->user->email,
            'default.is_active' => $this->isActiveCheckBoxValue,
            'personnelInfo.employee_number' => $this->user->personnelInfo?->employee_number,
            'personnelInfo.social_number' => $this->user->personnelInfo?->social_number,
            'personnelInfo.is_paid' => $this->isPaidCheckBoxValue,
            'personnelInfo.user_id' => $this->user->id,
            'personnelInfo.last_name_fr' => $this->user->personnelInfo?->last_name_fr,
            'personnelInfo.first_name_fr' => $this->user->personnelInfo?->first_name_fr,
            'personnelInfo.last_name_ar' => $this->user->personnelInfo?->last_name_ar,
            'personnelInfo.first_name_ar' => $this->user->personnelInfo?->first_name_ar,
            'personnelInfo.birth_date' => $this->user->personnelInfo?->birth_date,
            'personnelInfo.birth_place_fr' => $this->user->personnelInfo?->birth_place_fr,
            'personnelInfo.birth_place_ar' => $this->user->personnelInfo?->birth_place_ar,
            'personnelInfo.birth_place_en' => $this->user->personnelInfo?->birth_place_en,
            'personnelInfo.address_fr' => $this->user->personnelInfo?->address_fr,
            'personnelInfo.address_en' => $this->user->personnelInfo?->address_en,
            'personnelInfo.address_ar' => $this->user->personnelInfo?->address_ar,
            'personnelInfo.tel' => $this->user->personnelInfo?->tel,
        ]);
    }

    /* -------------------- Form Handling -------------------- */

    public function handleSubmit(): void
    {
        $this->dispatch('form-submitted');

        if (auth()->id() === $this->id) {
            $this->dispatch('update-nav-user-btn');
        }

        $response = $this->id
            ? $this->updateForm->save($this->user)
            : $this->addForm->save();

        if (!$this->id) {
            $this->addForm->reset();
            $this->addForm->fill([
                'default.establishment_id' => $this->establishmentId,
                'default.service_id' => $this->serviceId,
            ]);
        }

        if ($response['status']) {
            $this->dispatch('update-users-table');
            $this->dispatch('open-toast', $response['message']);
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }

    /* -------------------- Property Updates -------------------- */

    public function updated($property): void
    {
        try {
            if (in_array($property, ['addForm.image', 'updateForm.image'])) {
                $this->temporaryImageUrl = $this->{$this->form}->image?->temporaryUrl();
            }

            if ($property === 'isPaidCheckBoxValue') {
                $this->updateForm->fill(['personnelInfo.is_paid' => $this->isPaidCheckBoxValue]);
            }

            if ($property === 'isActiveCheckBoxValue') {
                $this->updateForm->fill(['default.is_active' => $this->isActiveCheckBoxValue]);
            }
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [__('modals.common.img-type-err')]);
        }
    }

    /* -------------------- Helpers -------------------- */

    protected function logModelError(\Throwable $exception): void
    {
        Log::error("UserModal: User not found.", [
            'message' => $exception->getMessage(),
            'user_id' => $this->id,
        ]);
    }

    /* -------------------- Render -------------------- */

    public function render()
    {
        return view('livewire.default.user-modal');
    }
}
