<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Helpers\Iocns;
class BootstrapTable extends Component
{
    public $data = [];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $data=[],$otherButton=[])
    {
        $this->data = $data;
        $this->otherButton = $otherButton;

        $this->activePage = activePageName();

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        $icons = Iocns::addIons($this->data);
        return view('components.bootstrap-table',['data'=>$this->data,'icons'=>$icons,'activePage'=>$this->activePage,'otherButton'=>$this->otherButton]);
    }


}
