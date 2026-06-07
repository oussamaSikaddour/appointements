<div class="modal__body">
<div
class="form__container"
>
    <form
    class="form"
    wire:submit="handleSubmit" >
<div class="row">
    <div class="column">
        <div class="row">
            <x-default.form.input
            model="{{$form}}.personnelInfo.last_name_fr"
            :label="__('forms.user.last_name_fr')"
             type="text"
            html_id="UM-LNfr"  />
            <x-default.form.input
            model="{{$form}}.personnelInfo.first_name_fr"
             :label="__('forms.user.first_name_fr')"
              type="text"
              html_id="UM-FNfr"  />
        </div>
        <div class="row">
            <x-default.form.input
            model="{{$form}}.personnelInfo.last_name_ar"
            :label="__('forms.user.last_name_ar')"
             type="text"
            html_id="UM-LNar"  />
            <x-default.form.input
            model="{{$form}}.personnelInfo.first_name_ar"
             :label="__('forms.user.first_name_ar')"
              type="text"
              html_id="UM-FNar"  />
        </div>
        <div class="row">
            <x-default.form.input
            model="{{$form}}.personnelInfo.employee_number"
           :label="__('forms.user.employee_number')"
            type="text"
            html_id="UM-EmN"  />
                <x-default.form.input
            model="{{$form}}.personnelInfo.social_number"
           :label="__('forms.user.social_number')"
            type="text"
            html_id="UM-SOCnUM"  />

        </div>
        <div class="row">


              <x-default.form.input
                model="{{$form}}.default.email"
               :label="__('forms.user.email')"
                type="email"
                html_id="UM-E"  />


        </div>
    </div>


    <x-default.form.upload-profile-input
     model="{{$form}}.image"
     :src="$temporaryImageUrl"
    :label="__('forms.user.profile_img')" />
</div>

<div class="row ">
    <x-default.form.input
    model="{{$form}}.personnelInfo.tel"
     :label="__('forms.user.tel')"
      type="text"
      html_id="UM-T"  />
    <x-default.form.input
    model="{{$form}}.personnelInfo.card_number"
    :label="__('forms.user.card_number')"
     type="text"
    html_id="UM-CN"  />
    <x-default.form.input
    model="{{$form}}.personnelInfo.birth_date"
     :label="__('forms.user.birth_date')"
      type="date"
      html_id="UM-BD"  />
</div>
<div class="row">
    <x-default.form.input
    model="{{$form}}.personnelInfo.birth_place_fr"
    :label="__('forms.user.birth_place_fr')"
     type="text"
    html_id="UM-BP-fr"  />
    <x-default.form.input
    model="{{$form}}.personnelInfo.birth_place_ar"
    :label="__('forms.user.birth_place_ar')"
     type="text"
    html_id="UM-BP-ar"  />
    <x-default.form.input
    model="{{$form}}.personnelInfo.birth_place_en"
    :label="__('forms.user.birth_place_en')"
     type="text"
    html_id="UM-BP-en"  />

</div>
<div class="row">
    <x-default.form.input
    model="{{$form}}.personnelInfo.address_fr"
    :label="__('forms.user.address_fr')"
     type="text"
    html_id="UM-AD-fr"  />
    <x-default.form.input
    model="{{$form}}.personnelInfo.address_ar"
    :label="__('forms.user.address_ar')"
     type="text"
    html_id="UM-AD-ar"  />
    <x-default.form.input
    model="{{$form}}.personnelInfo.address_en"
    :label="__('forms.user.address_en')"
     type="text"
    html_id="UM-AD-en"  />
</div>
<div class="row center">

    @can('establishment-admin-access')
        <x-default.form.selector
                        htmlId="userService"
                        model="{{$form}}.default.service_id"
                       :label="__('forms.user.service_id')"
                        :data="$servicesOptions"
                        :showError="true"/>
    @endcan

    @if($form =="updateForm")
    <div class="checkbox__group" >

        <div class="choices" role="groupe"  aria-labelledby="checkbox-choices">

        <x-default.form.check-box
        model="isPaidCheckBoxValue"
        value="{{!$isPaidCheckBoxValue }}"
        :label="__('forms.user.is_paid')"
        htmlId="UM-iSEM"
       :live=true
        />

        </div>
        </div>
        @can('super-admin-access')
         <div class="checkbox__group" >
        <div class="choices" role="groupe"  aria-labelledby="checkbox-choices">
        <x-default.form.check-box
        model="isActiveCheckBoxValue"
        value="{{!$isActiveCheckBoxValue }}"
        :label="__('forms.user.is_active')"
        htmlId="UM-isActive"
       :live=true
        />
        </div>
        </div>
        @endcan

  @endif
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
