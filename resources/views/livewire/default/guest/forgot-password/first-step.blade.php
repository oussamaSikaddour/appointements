<form class="form form-fp-1" wire:submit.prevent="handleSubmit" >
    <h3>
        @lang("forms.forgot_password.instructions.email")
    </h3>
    <div class="column">
        <x-default.form.input
       model="form.email"
        :label="__('forms.forgot_password.email')"
          type="email"
           html_id="FFPEmail" />
    </div>
    <div class="form__actions">
        <div wire:loading>
            <x-default.loading />
        </div>
        <button type="submit" class="button button--primary">@lang("forms.forgot_password.actions.get_code")</button>
    </div>
</form>
