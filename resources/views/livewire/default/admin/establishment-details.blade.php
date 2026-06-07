
<div class="form__container">
    <form class="form"
    wire:submit.prevent="handleSubmit">
        <div>
           @if(isset($this->existingTypes) && !empty($this->existingTypes))
            <div class="checkbox__group" >
            <h2 id="checkbox-choices" class="sr-only">
                    list Des Choix
            </h2>
            <div class="choices" role="groupe"  aria-labelledby="checkbox-choices">
            @foreach ( $this->existingTypes as $key=>$value)

            <x-default.form.check-box
            model="form.types"
            value="{{ $key }}"
            label="{{config('constants.ESTABLISHMENT_TYPES')[app()->getLocale()][$key]}}"
            htmlId="role-m-${{ $key }}"/>
            @endforeach
            @error("form.types")
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
        @this.updatetypesOnKeydownEvent(roleChoicesInputs[index].value)
      }
    })
});

</script>


@endscript
