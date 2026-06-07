<?php

namespace App\Livewire\Default;

use Livewire\Component;

class OpenModalButton extends Component
{

    public $classes="";
    public $title="";
    public $content="";
    public $toolTipMessage="";
    public $modalTitle="";
    public $type="";
    public array $modalTitleOptions=[];
    public $modalContent=[];
    public $containsTinyMce=false;


    public function openModal(){

         $this->dispatch("open-modal",[
             "type"=>$this->type,
            "title"=>$this->modalTitle ,
            'title_options'=>$this->modalTitleOptions,
             "component"=>$this->modalContent,
             'containsTinyMce'=>$this->containsTinyMce,

            ]);
    }
    public function render()
    {
        return view('livewire.default.open-modal-button');
    }
}
