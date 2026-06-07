<div class="table__container" x-on:update-messages-table.window="$wire.$refresh()">
    <div class="table__header">
        <h3>@lang('tables.messages.info')</h3>
        <div class="table__actions">
            <button class="button rounded table__filters__btn hasToolTip" id="filter">
                <span
                    id="TT-Mf"
                    class="toolTip"
                    role="tooltip"
                    aria-label="@lang('toolTips.common.filters')"
                    aria-haspopup="true"
                    aria-expanded="false"
                    aria-controls="tableFilters"
                >
                    @lang('toolTips.common.filters')
                </span>
                <i class="fa-solid fa-filter"></i>
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
            :label="__('tables.messages.name')"
            type="text"
            html_id="tM-n"
            role="filter"
        />
        <x-default.form.input
            model="email"
            :label="__('tables.messages.email')"
            type="email"
            html_id="tM-email"
            role="filter"
        />

        <button
            class="button button--primary rounded table__filters__btn--reset hasToolTip"
            wire:click="resetFilters"
        >
            <span
                id="trashToolTip3"
                class="toolTip"
                role="tooltip"
                aria-label="@lang('toolTips.common.resetFilters')"
            >
                @lang('toolTips.common.resetFilters')
            </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    @if(isset($this->messages) && $this->messages->isNotEmpty())
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                         <th scope="column">
                            <div>@lang('tables.common.actions')</div>
                        </th>
                        <x-default.table.sortable-th
                            wire:key="tm-TH-1"
                            model="name"
                            :label="__('tables.messages.name')"
                            :$sortDirection :$sortBy
                        />
                        <x-default.table.sortable-th
                            wire:key="tm-TH-2"
                            model="email"
                            :label="__('tables.messages.email')"
                            :$sortDirection :$sortBy
                        />
                        <x-default.table.sortable-th
                            wire:key="tm-TH-3"
                            model="created_at"
                            :label="__('tables.messages.created_at')"
                            :$sortDirection :$sortBy
                        />

                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->messages as $m)
                        <tr wire:key="m-t-{{ $m->id }}" scope="row">
                            <td>
                                <x-default.action-btn
                                    :tooltip="__('toolTips.message.delete')"
                                    icon="trash"
                                    function="openDeleteMessageDialog"
                                    :parameters="[$m]"
                                />

                                <livewire:default.open-modal-button
                                    wire:key="mv-m-{{ $m->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-reply'></i>"
                                    :toolTipMessage="__('toolTips.message.reply')"
                                    modalTitle="modals.message.actions.reply"
                                    :modalContent="[
                                        'name' => 'default.super-admin.reply-modal',
                                        'parameters' => ['message' => $m],
                                    ]"
                                    containsTinyMce=true
                                />
                            </td>
                            <td>{{ $m->name }}</td>
                            <td>{{ $m->email }}</td>
                            <td>{{ $m->created_at->format('Y-m-d') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $this->messages->links('components.default.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.messages.not_found')</h2>
        </div>
    @endif
</div>
