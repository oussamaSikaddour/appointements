<?php

namespace App\Livewire\Default\Author;

use App\Models\Article;
use App\Models\Image;
use App\Models\Service;
use App\Traits\Common\GeneralTrait;
use App\Traits\Common\ModelImageTrait;
use App\Traits\Common\TableTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ArticlesTable extends Component
{
    use WithPagination, TableTrait, GeneralTrait, ModelImageTrait;

    #[Url()]
    public $author = "";
    #[Url()]
    public $title = "";
    #[Url()]
    public $articleableType = Service::class;
    #[Url()]
    public $articleableId = "";

    public $articleableIdsSelectorHtml="";





    public $local = "fr";
    public array $articleableIdsOptions = [];
    public array $stateOptions = [];
    public array $articleTypesOptions = [];

    protected array $filterable = ['title', 'articleableType','author'];

    protected array $validationRules = [
        'title' => ['nullable', 'string', 'max:255'],
        'author' => ['nullable', 'string', 'max:255'],
        'articleableType' => 'nullable|string|min:10',
    ];

    public function mount()
    {
        $this->local = app()->getLocale();
        $this->articleTypesOptions = config('constants.ARTICLEABLE_TYPE')[$this->local] ;
        $this->stateOptions = config('constants.PUBLISHING_STATE')[$this->local] ;
        $this->populateArticleableIdsSelector();

    }

    public function resetFilters()
    {
        $this->reset(['title', 'author', 'articleableId', 'articleableType']);
        $this->resetPage();
    }

#[Computed()]
public function articles()
{
    $nameField = $this->local === 'ar' ? 'name_ar' : 'name_fr';

    $query = Article::query()
        ->with(['author', 'articleable']) // Always eager load relationships
        ->leftJoin('users', 'articles.user_id', '=', 'users.id')
        ->where('articles.articleable_id','like', "%{$this->articleableId}%")
        ->where('articles.articleable_type', $this->articleableType)
        ->where('articles.title_'.$this->local,'like',"%{$this->title}%")
        ->whereHas('author', fn ($q) => $q->where($nameField, 'like', "%{$this->author}%"));


    if ($this->articleableType === Service::class) {
        $query->leftJoin('services', 'services.id', '=', 'articles.articleable_id')
            ->select([
                'articles.*',
                "services.name_{$this->local} as location",
                "users.{$nameField} as author",
            ]);
    } else {
        // For other types, fall back to basic article and author info
        $query->select([
            'articles.*',
            "users.{$nameField} as author",
        ]);
    }

    return $query->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
}




    #[On("selected-value-updated")]
    public function changeArticleState(Article $article, $value)
    {
        try {
            $article->update(['state' => $value]);
        } catch (\Exception $e) {
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    #[On("delete-article")]
    public function deleteMenu(Article $article)
    {
        try {
            $images = Image::where([
                ['imageable_id', $article->id],
                ['imageable_type', Article::class],
            ])->get();

            if ($images->isNotEmpty()) {
                $this->deleteImages($images);
            }

            $article->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting article: ' . $e->getMessage());
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    public function openDeleteDialog($article)
    {
        $data = [
            "question" => "dialogs.name.article",
            "details" => ["article", $article['title_' . $this->local]],
            "actionEvent" => [
                "event" => "delete-article",
                "parameters" => $article
            ]
        ];

        $this->dispatch("open-dialog", $data);
    }



    public function updated(string $property): void
    {
        if ($property === "articleableType") {

            $this->dispatch('remove-wire-ignore');
           $this->populateArticleableIdsSelector();

        }

        if (in_array($property, $this->filterable) || $property === 'perPage') {
            $this->resetPage();
        }

        if (array_key_exists($property, $this->validationRules)) {
            try {
                $this->validateOnly($property, $this->validationRules);
            } catch (ValidationException $e) {
                $this->dispatch('open-errors', $e->validator->errors()->all());
            }
        }
    }

    #[Computed()]
    public function articleableIds()
    {
        return match ($this->articleableType) {
            Service::class => Service::get(['id', 'name_' . $this->local]),
            default => collect(),
        };
    }

        public function populateArticleableIdsSelector()
    {

        $options = match ($this->articleableType) {
            Service::class => $this->populateSelectorOption(
                $this->articleableIds(),
                'id',
                'name_' . $this->local,
                __('selectors.default.services')
            ),
            default => ["" => __('selectors.default.locations')],
        };

        $this->articleableIdsOptions = $options;

    }

    public function render()
    {
        return view('livewire.default.author.articles-table');
    }
}
