<div class="modal__body">
<div
class="form__container"
>
    <form
    class="form"
    wire:submit="handleSubmit" >

        <div class="row">
            <x-default.form.input
            model="{{$form}}.last_name_fr"
            :label="__('forms.medical_file.last_name_fr')"
             type="text"
            html_id="MFM-LNfr"  />
            <x-default.form.input
            model="{{$form}}.first_name_fr"
             :label="__('forms.medical_file.first_name_fr')"
              type="text"
              html_id="MFM-FNfr"  />
        </div>
        <div class="row">
            <x-default.form.input
            model="{{$form}}.last_name_ar"
            :label="__('forms.medical_file.last_name_ar')"
             type="text"
            html_id="MFM-LNar"  />
            <x-default.form.input
            model="{{$form}}.first_name_ar"
             :label="__('forms.medical_file.first_name_ar')"
              type="text"
              html_id="MFM-FNar"  />
        </div>
        <div class="row">
            <x-default.form.selector
               htmlId="MFM-Gender"
               model="{{$form}}.gender"
               :label="__('forms.medical_file.gender')"
               :data="$genderOptions"
                :showError="true"/>
            <x-default.form.input
            model="{{$form}}.insurance_number"
           :label="__('forms.medical_file.insurance_number')"
            type="text"
            html_id="MFM-SOCnUM"  />
        </div>




<div class="row ">
    <x-default.form.input
    model="{{$form}}.tel"
     :label="__('forms.medical_file.tel')"
      type="text"
      html_id="MFM-T"  />

    <x-default.form.input
    model="{{$form}}.birth_date"
     :label="__('forms.medical_file.birth_date')"
      type="date"
      html_id="MFM-BD"  />
</div>
<div class="row">
    <x-default.form.input
    model="{{$form}}.birth_place_fr"
    :label="__('forms.medical_file.birth_place_fr')"
     type="text"
    html_id="MFM-BP-fr"  />
    <x-default.form.input
    model="{{$form}}.birth_place_ar"
    :label="__('forms.medical_file.birth_place_ar')"
     type="text"
    html_id="MFM-BP-ar"  />
    <x-default.form.input
    model="{{$form}}.birth_place_en"
    :label="__('forms.medical_file.birth_place_en')"
     type="text"
    html_id="MFM-BP-en"  />

</div>
<div class="row">
    <x-default.form.input
    model="{{$form}}.address_fr"
    :label="__('forms.medical_file.address_fr')"
     type="text"
    html_id="MFM-AD-fr"  />
    <x-default.form.input
    model="{{$form}}.address_ar"
    :label="__('forms.medical_file.address_ar')"
     type="text"
    html_id="MFM-AD-ar"  />
    <x-default.form.input
    model="{{$form}}.address_en"
    :label="__('forms.medical_file.address_en')"
     type="text"
    html_id="MFM-AD-en"  />
</div>

        <div class="form__actions">
            <div wire:loading wire:target="handleSubmit">
                <x-default.loading  />
           </div>
            <button type="submit" class="button button--primary">@lang('forms.common.actions.submit')</button>
        </div>
    </form>

</div>
</div>
