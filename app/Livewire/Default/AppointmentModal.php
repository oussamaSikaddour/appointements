<?php

namespace App\Livewire\Default;

use App\Livewire\Forms\Appointment\AddForm;

use App\Models\{Appointment, Daira, Establishment, FieldSpecialty, Image, MedicalFile, Role, ScheduleDay, User};
use App\Traits\Common\DateAndTimeTrait;
use App\Traits\Common\GeneralTrait;
use App\Traits\Common\TableTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AppointmentModal extends Component
{
    use WithFileUploads, GeneralTrait, TableTrait, DateAndTimeTrait;

    public AddForm $addForm;
    public ?MedicalFile $medicalFile = null;

    public ?int $patientId = null;
    public ?int $dairaId = null;
    public ?int $specialtyId = null;
    public string $form = 'addForm';
    public string $locale = 'fr';
    public string  $initiator = 'patient';
    public array $dairatesOptions = [];
    public array $doctorsOptions = [];
    public array $specialtiesOptions = [];
    public array $appointmentsLocationsOptions = [];
    public bool $isAFollowUp=false;
    public string $temporaryImageUrl = "";


    /**
     * Helper: return a valid locale (default fr).
     */
    protected function localFrAndArOnly(): string
    {
        return in_array($this->locale, ['fr', 'ar']) ? $this->locale : 'fr';
    }

    /**
     * Computed: Dairates list.
     */
    #[Computed]
    public function dairates()
    {
        return Daira::query()
            ->whereHas('wilaya', fn($q) => $q->where('code', '13'))
            ->get(['id', 'designation_' . $this->locale]);
    }

    /**
     * Computed: Appointment locations.
     */
    #[Computed]
    public function appointmentsLocations()
    {
        return Establishment::query()
            ->whereJsonContains('types', 'appointment_locations')
            ->when($this->dairaId, fn($q, $dairaId) => $q->where('daira_id', $dairaId))
            ->get(['id', 'name_' . $this->locale]);
    }

    /**
     * Computed: Specialties.
     */
    #[Computed]
    public function specialties()
    {
        return FieldSpecialty::query()
            ->whereHas('field', fn($q) => $q->where('acronym', 'F_MED'))
            ->get(['id', 'designation_' . $this->locale]);
    }

    /**
     * Computed: Doctors list.
     */
    #[Computed]
    public function doctors()
    {
        return User::query()
            ->whereHas('roles', fn($q) => $q->where('slug', 'doctor'))
            ->whereHas('occupations', fn($q) => $q
                ->where('is_active', true)
                ->when($this->specialtyId, fn($q, $specialtyId) => $q->where('field_specialty_id', $specialtyId))
            )
            ->get(['id', 'name_' . $this->localFrAndArOnly()]);
    }

    /**
     * Lifecycle: Mount.
     */
    public function mount(): void
    {
        $this->locale = app()->getLocale();


        $this->dairatesOptions = $this->selectorOptions($this->dairates(), 'id', 'designation_' . $this->locale, __('selectors.default.dairates'));
        $this->appointmentsLocationsOptions = $this->selectorOptions($this->appointmentsLocations(), 'id', 'name_' . $this->locale, __('selectors.default.appointments_locations'));
        $this->specialtiesOptions = $this->selectorOptions($this->specialties(), 'id', 'designation_' . $this->locale, __('selectors.default.field_specialties'));
        $this->doctorsOptions = $this->selectorOptions($this->doctors(), 'id', 'name_' . $this->localFrAndArOnly(), __('selectors.default.doctors'));

      $this->initializeAddForm();
    }

    /**
     * Shortcut for populateSelectorOption
     */
    protected function selectorOptions($items, $valueKey, $labelKey, $placeholder): array
    {
        return $this->populateSelectorOption($items, $valueKey, $labelKey, $placeholder);
    }

    /**
     * Update temporary image URL (for referral letter).
     */
    private function updateTemporaryImageUrl(): void
    {
        $this->temporaryImageUrl = $this->addForm->referral_letter?->temporaryUrl() ?? "";
    }

    /**
     * Handle property updates dynamically.
     */
    public function updated($property): void
    {

        if (str_contains($property, 'referral_letter')) {
            try {
                $this->updateTemporaryImageUrl();
            } catch (\Exception $e) {
                $this->dispatch('open-errors', __('forms.common.errors.img.not_img'));
            }
        }

        if ($property === 'specialtyId') {
            $this->doctorsOptions = $this->selectorOptions($this->doctors(), 'id', 'name_' . $this->localFrAndArOnly(), __('selectors.default.doctors'));
          if(count($this->doctorsOptions)==1){
                $this->addForm->doctor_id=null;
                $this->isAFollowUp =false;
                $this->addForm->type="initial";
            }

        }
        if ($property === 'dairaId') {
                 $this->addForm->appointments_location_id=null;
            $this->appointmentsLocationsOptions = $this->selectorOptions($this->appointmentsLocations(), 'id', 'name_' . $this->locale, __('selectors.default.appointments_locations'));

        }
        if($property ="addForm.doctor_id"){
             $this->isAFollowUp =$this->addForm->doctor_id === auth()->id();
             $this->addForm->type= $this->isAFollowUp?'follow-up':'initial';
        }
    }

    /**
     * Initialize AddForm with defaults.
     */
    protected function initializeAddForm(): void
    {
        $user = auth()->user();
        static $doctorRoleId;
        $doctorRoleId ??= Role::where('slug', 'doctor')->value('id');
        if ($doctorRoleId && $user->roles->contains($doctorRoleId) && $this->medicalFile?->opened_by !== $user->id) {
            $this->initiator = 'doctor';
        }
        $this->addForm->fill([
            'patient_id' => $this->patientId,
            'initiator'  => $this->initiator,
        ]);
    }



#[Computed]
public function schedulesDays()
{
    return ScheduleDay::query()
        ->leftJoin('users', 'users.id', '=', 'schedule_days.doctor_id')
        ->leftJoin('establishments', 'establishments.id', '=', 'schedule_days.appointments_location_id')
        ->leftJoin('dairates', 'dairates.id', '=', 'establishments.daira_id')
        ->join('schedules', 'schedules.id', '=', 'schedule_days.schedule_id') // 👈 join schedules
        ->where('schedule_days.specialty_id', $this->specialtyId)
        ->where('schedules.state', 'published') // 👈 only published schedules
        ->when($this->initiator === 'patient', fn($q) =>
            $q->whereColumn('schedule_days.available_number', '>', 'schedule_days.confirmed_number')
        )
        ->when(filled($this->formValue('doctor_id')), fn($q) =>
            $q->where('schedule_days.doctor_id', $this->formValue('doctor_id'))
        )
        ->when(filled($this->dairaId), fn($q) =>
            $q->where('establishments.daira_id', $this->dairaId)
        )
        ->when(filled($this->formValue('appointments_location_id')), fn($q) =>
            $q->where('schedule_days.appointments_location_id', $this->formValue('appointments_location_id'))
        )
        ->select([
            'schedule_days.id',
            'schedule_days.day_at',
            'schedule_days.specialty_id',
            'schedule_days.created_at',
            'users.id as doctor_id',
            "users.name_{$this->localFrAndArOnly()} as doctor",
            'establishments.id as establishment_id',
            "establishments.name_{$this->locale} as appointments_location",
            'dairates.id as daira',
        ])
        ->orderBy($this->sortBy, $this->sortDirection)
        ->get();
}





    /**
     * Get value from the active form (addForm or updateForm).
     */
    protected function formValue(string $key, $default = null)
    { return  $this->addForm->{$key} ?? $default;
    }

    /**
     * Handle form submission.
     */

    public function render()
    {
        return view('livewire.default.appointment-modal');
    }


        public function openConfirmAppointmentDialog(array $scheduleDay): void
    {
      $date =$this->parseDate($scheduleDay['day_at']);
        $this->dispatch('open-dialog', [
            'question'    => 'dialogs.title.confirm-appointment',
            'details'     => ['confirm-appointment', $date ?? ''],
            'actionEvent' => ['event' => 'confirm-appointment', 'parameters' => $scheduleDay],
        ]);
    }

    /**
     * Delete schedule day.
     */
    #[On('confirm-appointment')]
    public function confirmAppointment(ScheduleDay $scheduleDay): void
    {
        try {

        $this->addForm->schedule_day_id =  $scheduleDay['id'];

         $this->dispatch('form-submitted');

        $response =$this->addForm->save();

        if ($response['status']) {
            $this->dispatch('update-available-appointments-table');
            $this->dispatch('update-confirmed-appointments-table');
            $this->dispatch('open-toast', $response['message']);
                $this->addForm->reset();
                $this->initializeAddForm();
                $this->temporaryImageUrl ="";

        } else {
            $this->dispatch('open-errors', $response['errors']);
        }

        } catch (\Throwable $e) {
            $this->handleException('deleteScheduleDay', $e);
        }
    }
}
