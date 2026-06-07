<?php

namespace App\Livewire\Default\ServiceAdmin;

use App\Livewire\Forms\AppointmentsLocationAdmin\ManageForm;
use App\Models\Establishment;
use App\Models\Role;
use App\Models\User;
use App\Traits\Common\GeneralTrait;
use App\Traits\Common\TableTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class AppointmentsLocationAdmins extends Component
{

  use TableTrait, GeneralTrait;

    public ManageForm $manageForm;
    public $establishmentId;

    public $personalOptions = [];
    public $appointmentsLocationsOptions = [];
    public $local = "fr";

    /**
     * Fetch all banks for the dropdown.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    #[Computed()]
    public function personal()
    {
        return User::where('establishment_id',$this->establishmentId)->get(['id', 'name_'.$this->local]);
    }
    #[Computed]
    public function appointmentsLocations()
    {
        return Establishment::query()
            ->whereJsonContains('types', 'appointment_locations')
            ->get();
    }




    public function mount(){

  $this->local = app()->getLocale();
  $this->personalOptions = $this->populateSelectorOption($this->personal(),  'id','name_'.$this->local, __('selectors.default.employees'));
  $this->appointmentsLocationsOptions = $this->populateSelectorOption($this->appointmentsLocations(),  'id','name_'.$this->local, __('selectors.default.appointments_locations'));

    }






#[Computed]
public function appointmentsLocationAdmins()
{
    return User::query()
        ->with(['personnelInfo'])
        ->leftJoin('personnel_infos', 'users.id', '=', 'personnel_infos.user_id')
        ->whereHas('roles', fn($q) =>
            $q->where('slug', 'appointments_location_admin')
        )
        ->when(!empty($this->establishmentId), fn($query) =>
            $query->where('users.establishment_id', $this->establishmentId)
        )
        ->select([
            'users.id',
            'users.email',
             'users.name_'.$this->local .' as name',
             'users.created_at',
            'personnel_infos.employee_number',
            'personnel_infos.social_number',
            'personnel_infos.card_number',
            'personnel_infos.birth_date',
            'personnel_infos.phone',
        ])
        ->orderBy($this->sortBy, $this->sortDirection)
        ->get();
}







    /**
     * Handle form submission.
     */
    public function handleSubmit()
    {
        $this->dispatch('form-submitted');

        $response = $this->manageForm->save();

        if ($response['status']) {
            $this->dispatch('update-appointments-location-admins');

            $this->dispatch('open-toast', $response['message']);
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }



    /**
     * Open the delete banking information dialog.
     *
     * @param array $bankingInformation
     */
    public function openManageAppointmentsLocationAdminDialog($ALAdmin)
    {

        $data = [
            "question" => "dialogs.title.remove-appointments-location-admin",
            "details" => ["remove-appointments-location-admin", $ALAdmin['name']],
            "actionEvent" => [
                "event" => "remove-appointments-location-admin",
                "parameters" => $ALAdmin
            ],
        ];

        $this->dispatch("open-dialog", $data);
    }

    /**
     * Delete the banking information.
     *
     * @param BankingInformation $bankingInformation
     */
/**
 * Remove coordinator role from a given user.
 */
#[On("remove-appointments-location-admin")]
public function removeAppointmentsLocationAdminFunction(User $APLadmin)
{
    try {
        // Get the coordinator role (cached)
        $appointmentsLocationAdminRole = Role::appointmentsLocationAdmin();


        if ($appointmentsLocationAdminRole) {
            $APLadmin->roles()->detach($appointmentsLocationAdminRole->id);
            $APLadmin->update([
    'appointments_location_id' => null,
]);

        }

    } catch (\Exception $e) {
        Log::error('Error in removeAppointmentsLocationAdminFunction: ' . $e->getMessage());
        $this->dispatch('open-errors', __('forms.common.errors.default'));
    }
}

    public function render()
    {
        return view('livewire.default.service-admin.appointments-location-admins');
    }
}
