<?php

namespace App\Livewire\Default\EstablishmentAdmin;

use App\Livewire\Forms\Coordinator\ManageForm;
use App\Models\Role;
use App\Models\User;
use App\Traits\Common\GeneralTrait;
use App\Traits\Common\TableTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class CoordinatorsModal extends Component
{

        use TableTrait, GeneralTrait;

    public ManageForm $manageForm;
    public $establishmentId;
    public $serviceId;

    public $personalOptions = [];
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




    public function mount(){

  $this->local = app()->getLocale();
  $this->personalOptions = $this->populateSelectorOption($this->personal(),  'id','name_'.$this->local, __('selectors.default.employees'));
     $this->manageForm->fill(['service_id'=>$this->serviceId]);
    }






#[Computed]
public function coordinators()
{
    return User::query()
        ->with(['personnelInfo'])
        ->leftJoin('personnel_infos', 'users.id', '=', 'personnel_infos.user_id')
        ->whereHas('roles', fn($q) =>
            $q->where('slug', 'service_admin')
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
            $this->dispatch('update-coordinators-table');

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
    public function openManageCoordDialog($coord)
    {

        $data = [
            "question" => "dialogs.title.remove-coordinator",
            "details" => ["remove-coordinator", $coord['name']],
            "actionEvent" => [
                "event" => "remove-coordinator",
                "parameters" => $coord
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
#[On("remove-coordinator")]
public function removeCoordFunction(User $coord)
{
    try {
        // Get the coordinator role (cached)
        $coordinatorRole = Role::coordinator();

        if ($coordinatorRole) {
            $coord->roles()->detach($coordinatorRole->id);
        }

    } catch (\Exception $e) {
        Log::error('Error in ManageForm@removeCoordFunction: ' . $e->getMessage());
        $this->dispatch('open-errors', __('forms.common.errors.default'));
    }
}



    public function render()
    {
                $this->dispatch("init-tooltips");
        return view('livewire.default.establishment-admin.coordinators-modal');
    }
}
