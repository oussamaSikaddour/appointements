<div class="table__container"
x-on:update-our-qualities-table.window="$wire.$refresh()"
>
<div class="table__header">
    <h3>@lang('tables.our_qualities.info')</h3>
   <div class="table__actions">
       <button class="button rounded table__filters__btn hasTooltip"
       id="filter" >
        <span
        id="TT-Mf"
        class="toolTip"
        role="tooltip"
        aria-label="manage Filters"
        aria-haspopup="true"
         aria-expanded="false"
         aria-controls="tableFilters"

         >
         @lang("toolTips.common.filters")
      </span>
      <i class="fa-solid fa-filter" ></i>
       </button>
       <x-default.form.selector
       htmlId="TU-upp"
       model="perPage"
       :label="__('tables.common.perPage')"
       :data="$perPageOptions"
       type="filter"
       />
   </div>
</div>
    <div class="table__filters" wire:ignore>

            <x-default.form.input
            model="name"
            :label="__('tables.our_qualities.name')"
            type="text"
            html_id="tName"
            role="filter"/>

            <button
            class="button button--primary rounded table__filters__btn--reset hasTooltip"
             wire:click="resetFilters">

             <span
             id="trashToolTip3"
             class="toolTip"
             role="tooltip"
             aria-label="resest Filters"
           >
           @lang("toolTips.common.resetFilters")
           </span>
                <i class="fa-solid fa-arrows-rotate"></i>
            </button>

    </div>

    @if(isset($this->ourQualities) && $this->ourQualities->isNotEmpty())


    <div class="table__body">
    <table>
        <thead>
            <tr>


        <x-default.table.sortable-th
        wire:key="oqT-TH-2"
        model="name_fr"
        :label="__('tables.our_qualities.name')"
        :$sortDirection :$sortBy/>



           <x-default.table.sortable-th wire:key="crt-TH-5"
           model="is_active"
           :label="__('tables.our_qualities.status')"
            :$sortDirection
            :$sortBy/>

           <x-default.table.sortable-th wire:key="crt-TH-6"
           model="created_at"
           :label="__('tables.our_qualities.created_at')"
            :$sortDirection
            :$sortBy/>

             <th scope="column"><div>@lang('tables.common.actions')</div></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($this->ourQualities as $oQ)


                <tr wire:key="{{ $oQ->id }}-pr">
                    <td scope="row">{{ $oQ->localized_name }}</td>

                    <td>
                        <livewire:default.table-selector
                        wire:key="st-P-{{ $oQ->id }}"
                        :data="$statusOptions"
                        :selectedValue="$oQ->is_active"
                        :entity="$oQ"
                      lazy
                      />
                    </td>

                    <td >{{ $oQ->created_at->format('Y-m-d')}}</td>
                    <td>


                        <x-default.action-btn
                        :tooltip="__('toolTips.our_quality.delete')"
                        icon="trash"
                        function="openDeleteDialog"
                        :parameters="[$oQ]" />
                        <livewire:default.open-modal-button
                        wire:key="pr-m-{{ $oQ->id }}"
                        classes="rounded"
                        content="<i class='fa-solid fa-pen-to-square'></i>"
                        :toolTipMessage="__('toolTips.our_quality.update')"
                        modalTitle="modals.our_quality.actions.update"
                        :modalContent="[
                            'name' => 'default.super-admin.our-quality-modal',
                            'parameters' => ['id' => $oQ->id]
                        ]"
                    />

                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    </div>
    {{ $this->ourQualities->links('components.default.pagination') }}
    @else
    <div class="table__footer">
    <h2>
        @lang('tables.our_qualities.not_found')
    </h2>
    </div>
   @endif

</div>
