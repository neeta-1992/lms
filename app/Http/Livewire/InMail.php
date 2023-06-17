<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InMail extends Component
{
    public $mailForm=[];


    public function render()
    {
        return view('livewire.in-mail',['route'=>'']);
    }
}
