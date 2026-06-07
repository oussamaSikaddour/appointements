<div class="table__container"
     x-on:update-articles-table.window="$wire.$refresh()">

    <div class="table__header">
        <h3>@lang('tables.articles.info')</h3>
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

    <div class="table__filters" wire:ignore.self>
        <x-default.form.input
            model="author"
            :label="__('tables.articles.author')"
            type="text"
            html_id="TAr-author"
            role="filter" />

        <x-default.form.input
            model="title"
            :label="__('tables.articles.title')"
            type="text"
            html_id="TAr-title"
            role="filter" />

        <x-default.form.selector
            htmlId="tmt-type"
            model="articleableType"
            :label="__('tables.articles.articleable_type')"
            :data="$articleTypesOptions"
            type="filter" />

        <x-default.form.selector
            htmlId="tmt-id"
            model="articleableId"
            :label="__('tables.articles.articleable_id')"
            :data="$articleableIdsOptions"
            type="filter" />

        <button class="button button--primary rounded table__filters__btn--reset hasTooltip"
                wire:click="resetFilters">
            <span id="trashToolTip3" class="toolTip" role="tooltip" aria-label="resest Filters">
                @lang("toolTips.common.resetFilters")
            </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    @if(isset($this->articles) && count($this->articles))
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                        <th scope="column">
                            <div>@lang('tables.common.actions')</div>
                        </th>
                        <x-default.table.sortable-th
                            wire:key="art-TH-1"
                            model="title"
                            :label="__('tables.articles.title')"
                            :$sortDirection
                            :$sortBy
                            :appLocal=true />

                        <x-default.table.sortable-th
                            wire:key="Art-TH-2"
                            model="author"
                            :label="__('tables.articles.author')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="art-TH-3"
                            model="location"
                            :label="__('tables.articles.location')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="art-TH-4"
                            model="state"
                            :label="__('tables.articles.state')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="arT-TH-5"
                            model="created_at"
                            :label="__('tables.articles.created_at')"
                            :$sortDirection
                            :$sortBy />


                    </tr>
                </thead>

                <tbody>
                    @foreach ($this->articles as $article)
                        <tr wire:key="{{ $article->id }}-gt">
                             <td>
                                <x-default.action-btn
                                    :tooltip="__('toolTips.article.delete')"
                                    icon="trash"
                                    function="openDeleteDialog"
                                    :parameters="[$article]" />

                                <livewire:default.open-modal-button
                                    wire:key="article-m-{{ $article->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.article.update')"
                                    modalTitle="modals.article.actions.update"
                                    :modalContent="[
                                        'name' => 'default.author.article-modal',
                                        'parameters' => ['id' => $article->id]
                                    ]"
                                    :containsTinyMce=true />
                            </td>
                            <td scope="row">{{ $article->localized_title }}</td>
                            <td>{{ $article->author }}</td>
                            <td>{{ $article->location }}</td>
                            <td>
                                <livewire:default.table-selector
                                    wire:key="art-P-{{ $article->id }}"
                                    :data="$stateOptions"
                                    :selectedValue="$article->state"
                                    :entity="$article"
                                    lazy />
                            </td>
                            <td>{{ $article->created_at->format('Y-m-d') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $this->articles->links('components.default.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.articles.not_found')</h2>
        </div>
    @endif
</div>
