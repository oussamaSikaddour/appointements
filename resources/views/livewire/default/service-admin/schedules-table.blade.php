<div class="table__container"
     x-on:update-schedules-table.window="$wire.$refresh()">

    <div class="table__header">
        <h3>@lang('tables.schedules.info')</h3>
        <div class="table__actions">
            <button class="button rounded table__filters__btn hasTooltip" id="filter">
                <span id="TT-Mf"
                      class="toolTip"
                      role="tooltip"
                      aria-label="manage Filters"
                      aria-haspopup="true"
                      aria-expanded="false"
                      aria-controls="tableFilters">
                    @lang("toolTips.common.filters")
                </span>
                <i class="fa-solid fa-filter"></i>
            </button>

            <x-default.form.selector
                htmlId="TU-upp"
                model="perPage"
                :label="__('tables.common.perPage')"
                :data="$perPageOptions"
                type="filter" />
        </div>
    </div>

    <div class="table__filters" wire:ignore>
        <x-default.form.input
            model="name"
            :label="__('tables.schedules.name')"
            type="text"
            html_id="tSchedule-tit"
            role="filter" />
        <x-default.form.selector
            htmlId="tSchedule-year"
            model="year"
            :label="__('tables.schedules.year')"
            :data="$yearsOptions"
            type="filter" />
        <x-default.form.selector
            htmlId="tSchedule-month"
            model="month"
            :label="__('tables.schedules.month')"
            :data="$monthsOptions"
            type="filter" />
        <x-default.form.selector
            htmlId="tschedule-state"
            model="state"
            :label="__('tables.schedules.state')"
            :data="$statesOptions"
            type="filter" />

        <button class="button button--primary rounded table__filters__btn--reset hasTooltip"
                wire:click="resetFilters">
            <span id="trashToolTip3" class="toolTip" role="tooltip" aria-label="resest Filters">
                @lang("toolTips.common.resetFilters")
            </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    @if(isset($this->schedules) && $this->schedules->isNotEmpty())
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                        <th scope="column">
                            <div>@lang('tables.common.actions')</div>
                        </th>
                        <x-default.table.sortable-th
                            wire:key="scheduleT-TH-1"
                            model="name_fr"
                            :label="__('tables.schedules.name_fr')"
                            :$sortDirection
                            :$sortBy
                             />
                        <x-default.table.sortable-th
                            wire:key="scheduleT-TH-2"
                            model="name_en"
                            :label="__('tables.schedules.name_en')"
                            :$sortDirection
                            :$sortBy
                             />
                        <x-default.table.sortable-th
                            wire:key="scheduleT-TH-3"
                            model="name_ar"
                            :label="__('tables.schedules.name_ar')"
                            :$sortDirection
                            :$sortBy
                             />
                        <x-default.table.sortable-th
                            wire:key="scheduleT-TH-4"
                            model="year"
                            :label="__('tables.schedules.year')"
                            :$sortDirection
                            :$sortBy
                             />
                        <x-default.table.sortable-th
                            wire:key="scheduleT-TH-5"
                            model="month"
                            :label="__('tables.schedules.month')"
                            :$sortDirection
                            :$sortBy
                             />

                        <x-default.table.sortable-th
                            wire:key="scheduleT-TH-"
                            model="state"
                            :label="__('tables.schedules.state')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="gtT-TH-4"
                            model="created_at"
                            :label="__('tables.schedules.created_at')"
                            :$sortDirection
                            :$sortBy />


                    </tr>
                </thead>

                <tbody>
                    @foreach ($this->schedules as $schedule)

                          @php
                                  $name = $schedule->{'name_'.$locale};
                           @endphp

                        <tr wire:key="{{ $schedule->id }}-gt">
                            <td>
                                @if($schedule->state =="not_published")
                                <x-default.action-btn
                                    :tooltip="__('toolTips.schedule.delete')"
                                    icon="trash"
                                    function="openDeleteDialog"
                                    :parameters="[$schedule]" />
                                <x-default.action-btn
                                    :tooltip="__('toolTips.schedule.publish')"
                                    icon="publish"
                                    function="openPublishDialog"
                                    :parameters="[$schedule]" />

                                <livewire:default.open-modal-button
                                    wire:key="schedule-m-{{ $schedule->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.schedule.update')"
                                    modalTitle="modals.schedule.actions.update"
                                    :modalContent="[
                                        'name' => 'default.service-admin.schedule-modal',
                                        'parameters' => ['scheduleId' => $schedule->id]
                                    ]" />

                                    @endif
                                <livewire:default.open-modal-button
                                        wire:key="schedule-msd-{{ $schedule->id }}"
                                        classes="rounded"
                                        content="<i class='fa-solid fa-calendar-days'></i>"
                                        :toolTipMessage="__('toolTips.schedule.manage.view')"
                                        modalTitle="modals.schedule.actions.manage"
                                        :modalTitleOptions="['name'=>$name]"
                                        :modalContent="['name' => 'default.service-admin.schedule-days-modal', 'parameters' => ['schedule' => $schedule]]"
                                    />
                            </td>
                            <td scope="row">{{ $schedule->name_fr }}</td>
                            <td scope="row">{{ $schedule->name_en }}</td>
                            <td scope="row">{{ $schedule->name_ar }}</td>
                            <td>{{ $yearsOptions[$schedule->year] }}</td>
                            <td>{{ $monthsOptions[$schedule->month] }}</td>
                            <td>{{ $statesOptions[$schedule->state] }}</td>
                            <td>{{ $schedule->created_at->format('Y-m-d') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $this->schedules->links('components.default.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.schedules.not_found')</h2>
        </div>
    @endif
</div>
