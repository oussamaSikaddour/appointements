
<div class="form__container small">
    <form class="form" wire:submit="handleSubmit">


        <div class="column ">
            <x-default.form.input model="form.youtube" :label="__('forms.socials.youtube')" type="text" html_id="FS-Y" />
            <x-default.form.input model="form.facebook" :label="__('forms.socials.facebook')" type="text" html_id="FS-f" />
            <x-default.form.input model="form.instagram" :label="__('forms.socials.instagram')" type="text" html_id="FS-i" />
            <x-default.form.input model="form.linkedin" :label="__('forms.socials.linkedin')" type="text" html_id="FS-l" />
            <x-default.form.input model="form.github" :label="__('forms.socials.github')" type="text" html_id="FS-g" />
            <x-default.form.input model="form.tiktok" :label="__('forms.socials.tiktok')" type="text" html_id="FS-t" />

        </div>
        <div class="form__actions">
            <div wire:loading wire:target="handleSubmit">
                <x-default.loading />
            </div>
            <button type="submit" class="button button--primary">@lang('forms.common.actions.submit')</button>
        </div>
    </form>
</div>
