<?php

namespace App\Livewire\Default\SuperAdmin\Scenes;

use App\Livewire\Forms\Hero\ManageForm;
use App\Models\Hero as ModelsHero;
use App\Models\Image;
use App\Traits\Common\GeneralTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Hero extends Component
{

    use GeneralTrait,WithFileUploads;
    public ManageForm $form;
    public ModelsHero $hero;
    public $temporaryImageUrls=[];





    public function updated($property)
    {
        try {
            if ($property === "form.images" && $this->form->images) {

                $this->temporaryImageUrls= [];
                foreach ($this->form->images as $image) {
                    if (!$image->temporaryUrl()) {
                        $this->temporaryImageUrls = []; // Set to empty array if any image doesn't have a temporary URL
                        break; // Exit the loop
                    }
                    $this->temporaryImageUrls[] = $image->temporaryUrl();
                }
            }
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [__('forms.common.errors.img.not_imgs')]);
        }
    }


    public function mount()
    {


            try {
                $this->hero = ModelsHero::first();

                $images = Image::where('imageable_id', $this->hero->id)
                ->where('imageable_type','App\Models\Hero')
                ->where('use_case','hero')->get();
                foreach($images as $image){
                 $this->temporaryImageUrls[] = $image?->url ?? "";
                }

                $this->form->fill([
                    'id' => $this->hero->id,
                    'title_fr' => $this->hero->title_fr,
                    'title_ar' => $this->hero->title_ar,
                    'title_en' => $this->hero->title_ar,
                    'sub_title_ar' => $this->hero->sub_title_ar,
                    'sub_title_fr' => $this->hero->sub_title_fr,
                    'sub_title_en' => $this->hero->sub_title_fr,
                ]);

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                Log::error('Error in Hero mount method: ' . $e->getMessage());
                $this->dispatch('open-errors', __('forms.common.errors.default'));
            }

    }


    public function handleSubmit()
    {
        $this->dispatch('form-submitted');

        $response =$this->form->save($this->hero);
        if ($response['status']) {
            $this->dispatch('open-toast', $response['message']);

        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }


    public function render()
    {
        return view('livewire.default.super-admin.scenes.hero');
    }
}
