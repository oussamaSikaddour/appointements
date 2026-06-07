<!-- resources/views/livewire/registration-form.blade.php -->

<form class="form form--1" wire:submit.prevent="handleSubmit" >
    <h3>@lang("forms.register.instructions.email")</h3>

    <div class="column">
        <x-default.form.input
        model="form.email"
       :label="__('forms.register.email')"
        type="email"
        html_id="registEmail" />
         <x-default.form.password-input
         model="form.password"
         :label="__('forms.register.steps.first.password')"
          html_id="registPassword"/>
    </div>
    <div class="row">

    </div>
    <div class="form__actions">

        <div wire:loading>
             <x-default.loading  />
        </div>
        <a class="button"    href="{{ route($this->loginRoute) }}" >@lang("pages.register.links.login")</a>
         <button type="submit" class="button button--primary">@lang("forms.register.actions.get_code")</button>
    </div>
</form>


