<form class="form form-fp-l" wire:submit.prevent="handleSubmit" >
    <h3>      @lang("forms.forgot_password.instructions.code")</h3>

    <div class="column">
        <x-default.form.input
       model="form.email"
        :label="__('forms.forgot_password.email')"
        type="email"
        html_id="FPEmail" />
        <x-default.form.input
       model="form.code"
       :label="__('forms.forgot_password.steps.last.code')"
          type="text"
          html_id="FPPassword" />
    </div>
    <div class="column">
        <x-default.form.password-input
        :label="__('forms.forgot_password.steps.last.password')"
         model="form.password"
          html_id="FPNPassword"/>
    </div>
        <div class="form__actions">
            <div wire:loading>
                <x-default.loading />
            </div>
            <button
              type="submit" class="button button--primary">
                @lang("forms.common.actions.submit")
            </button>
        </div>
</form>


@script
<script>

 document.addEventListener('email-forgot-password-is-set', function(event) {
    @this.setEmail(event.detail.data.email);
 });

</script>
@endscript
