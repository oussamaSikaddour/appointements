<form class="form" wire:submit="handelSubmit">
    <div class="column">
        <x-default.form.input
            model="form.email"
            :label="__('forms.login.email')"
            type="email"
            html_id="loginEmail"
        />
        <x-default.form.password-input
            model="form.password"
            :label="__('forms.login.password')"
            html_id="loginPassword"
        />
    </div>

    <div class="center">
        <!-- Use the computed property here -->
        <a href="{{ route($this->forgetPasswordRoute) }}">
            <p>@lang("pages.login.links.forgot_password")</p>
        </a>
    </div>

    <div class="form__actions">
<div class="column">
        <div class="row">
            <a class="button" href="{{ route($this->registerPageRoute) }}">
                @lang("pages.login.links.register")
            </a>
        </div>
        <div class="row">
        <div wire:loading>
            <x-default.loading />
        </div>


        <button type="submit" class="button button--primary">
            @lang("forms.login.actions.submit")
        </button>
           </div>
        </div>
    </div>
</form>
