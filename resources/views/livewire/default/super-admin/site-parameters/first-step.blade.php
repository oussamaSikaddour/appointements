<form class="form form-sp-1" wire:submit="handleSubmit">

    <div class="column">
        <x-default.form.input
        model="form.email"
         :label="__('forms.site_parameters.steps.first.email')"
          type="email"
          html_id="spEmail" />
        <x-default.form.password-input
        model="form.password"
       :label="__('forms.site_parameters.steps.first.password')"
        html_id="spPassword"/>
   </div>

   <div class="form__actions">

       <div wire:loading>
            <x-default.loading  />
       </div>
       <button type="submit" class="button button--primary">@lang("forms.common.actions.submit")</button>

   </div>
  </form>


