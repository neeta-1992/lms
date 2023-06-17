<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    public $activePage ;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $activePage=null,array $class=[])
    {

        $this->activePage = activePageName();
        $this->class = $class;

    }
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $pageId = $this->activePage;
        return view('layouts.app',['activePage'=> $this->activePage,'pageId'=>$pageId,'class'=>$this->class]);
    }
}
