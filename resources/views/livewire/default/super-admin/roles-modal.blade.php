<div class="modal__body">
<div class="form__container">
    <form class="form"
    wire:submit.prevent="handleSubmit"
    x-on:logout.window="setTimeout(() => { $wire.logout() ; }, 5000)">
        <div>
            @if(isset($this->existingRoles) && $this->existingRoles->isNotEmpty())
            <div class="checkbox__group" >
            <h2 id="checkbox-choices" class="sr-only">
                    list Des Choix
            </h2>
            <div class="choices" role="groupe"  aria-labelledby="checkbox-choices">
            @foreach ( $this->existingRoles as $ER)
            <x-default.form.check-box
            model="form.roles"
            value="{{ $ER->id }}"
            label="{{config('constants')['ROLES'][app()->getLocale()][$ER->slug]}}"
            htmlId="role-m-${{ $ER->id }}"/>
            @endforeach
            @error("form.roles")
            <div class="input__error">
                {{ $message }}
            </div>
            @enderror
            </div>
            </div>
            @endif
        </div>

        <div class="form__actions">
            <div wire:loading>
                <x-default.loading />
            </div>
            <button type="submit" class="button button--primary">@lang('forms.common.actions.submit')</button>
        </div>
    </form>

</div>
</div>


@script

<script>

const roleChoices = document.querySelector(".checkbox__group > .choices");
const roleChoicesLabels= roleChoices.querySelectorAll("label")
const roleChoicesInputs= roleChoices.querySelectorAll("input[type='checkbox']")
roleChoicesLabels.forEach((label, index) => {
label.addEventListener('keydown', (e) => {
      if (e.key === ' ') {
        const checkBoxCheckedEvent = new CustomEvent('checkbox-checked-event' ,{
                   detail: {
                      checkBox:roleChoicesInputs[index]
                          }
                        });
        document.dispatchEvent(checkBoxCheckedEvent);
        @this.updateRolesOnKeydownEvent(roleChoicesInputs[index].value)
      }
    })
});

</script>


@endscript
