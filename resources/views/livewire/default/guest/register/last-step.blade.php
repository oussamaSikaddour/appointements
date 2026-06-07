<form class="form form--2" id="myForm"
>
    <h3>@lang("forms.register.instructions.code")</h3>
    <div class="column">
        <x-default.form.input model="form.email"
        :label="__('forms.register.email')"
        type="email"
        html_id="registerSFEmail" />
        <x-default.form.input
        model="form.code"
       :label="__('forms.register.steps.last.code')"
        type="text"
        html_id="registerVerificationCode" />
    </div>
    <div class="center">
        <button class="button" wire:click.prevent='setNewValidationCode'>
            @lang("forms.register.actions.get_new_code")
        </button>
    </div>
    <div class="form__actions">
        <div wire:loading>
            <x-default.loading  />
       </div>
        <button class="button button--primary" type='submit' wire:click.prevent="handleSubmit" id="validerButton">
            @lang("forms.register.actions.submit")
        </button>
    </div>
</form>

@script
<script>
 const form = document.getElementById('myForm');
 const validerButton = document.getElementById('validerButton');
 form.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            // Prevent the default form submission
            event.preventDefault();
            // Trigger a click event on the "Valider" button
            validerButton.click();
        }
});
 document.addEventListener('email-registration-is-set', function(event) {
    @this.setEmail(event.detail.data.email);
 });

</script>
@endscript
