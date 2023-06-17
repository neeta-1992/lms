<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InMail extends Component
{
    public $pageTitle = "InMail";
    public $activePage = "in-mail";
    public $route = "company.in-mail.";
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($cancel=null,$type=null,$quoteDeleted=false)
    {
        $this->cancel = $cancel;
        $this->type = $type;
        $this->qdelete = $quoteDeleted;
      
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.in-mail',['route'=>$this->route,'activePage'=>$this->activePage,'pageTitle'=>$this->pageTitle,'cancel'=>$this->cancel,'type'=>$this->type,'qdelete'=>$this->qdelete]);
    }
}
