<?php

namespace App\Livewire\Forms\AppointmentsLocationAdmin;

use App\Models\Role;
use App\Models\User;
use App\Traits\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ManageForm extends Form
{
    use ResponseTrait;
public $appointments_location_id=null;
public $user_id=null;

    public function rules()
    {
        return [
            'appointments_location_id'   =>[ 'required','exists:establishments,id'],
            'user_id' => [ 'required','exists:users,id'],
        ];
    }



public function save()
{
    try {
        $data = $this->validate();

        // Find the user by user_id
        $user = User::findOrFail($data['user_id']);

        // Attach the coordinator role (if not already attached)
        $coordinatorRole = Role::appointmentsLocationAdmin();
            if ($coordinatorRole) {
                $user->roles()->syncWithoutDetaching([$coordinatorRole->id]);
            }


        $user->appointments_location_id = $data['appointments_location_id'];
        $user->save();

        return $this->response(
            true,
            message: __('forms.appointments-location-admin.responses.add_success')
        );
    } catch (\Illuminate\Validation\ValidationException $e) {
        return $this->response(false, errors: $e->validator->errors()->all());
    } catch (\Exception $e) {
        Log::error('Error in ManageForm@save: ' . $e->getMessage());
        return $this->response(false, errors: __('forms.common.errors.default'));
    }
}

}
