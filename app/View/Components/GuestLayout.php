<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GuestLayout extends Component
{

     public $class ;
     /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $class=[]) {
        $this->class = $class;
    }/**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {

        return view('layouts.guest',['class'=>$this->class]);
    }
}
