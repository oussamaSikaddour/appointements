<form class="form" wire:submit="handelSubmit" x-data="{ redirecting: false }" x-on:redirect-page.window="redirecting = true; setTimeout(() => { window.location.href = '{{ $this->logoutRoute() }}' }, 4500)">
    <h3>@lang("forms.change_mail.infos.redirect")</h3>
    <div class="column">
        <x-default.form.input
        model="form.oldEmail"
        :label="__('forms.change_mail.mail')"
          type="email"
           html_id="FCPEmail" />
        <x-default.form.password-input
        :label="__('forms.change_mail.pwd')"
        model="form.password"
         html_id="CEPassword" />
    </div>
    <div class="column">
        <x-default.form.input
        model="form.newEmail"
        :label="__('forms.change_mail.new_mail')"
          type="email"
           html_id="FCPNewEmail" />
    </div>
    <div class="form__actions">
        <div wire:loading>
            <x-default.loading />
        </div>
        <button type="submit" class="button button--primary" x-bind:disabled="redirecting">
            @lang("forms.common.actions.submit")
        </button>
    </div>
</form>
