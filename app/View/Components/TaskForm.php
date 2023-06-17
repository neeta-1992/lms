<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\User;
class TaskForm extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $userData = $this->userData();
        return view('components.task-form',compact('userData'));
    }


    private  function userData(){

        $userData = auth()->user();
        $userType = $userData?->user_type ?? 0;
        if ($userType == User::ADMIN) {
            $type = [User::COMPANYUSER, User::ADMIN];
        } elseif ($userType == User::COMPANYUSER) {
            $type = [User::COMPANYUSER];
        } elseif ($userType == User::AGENT) {
            $type = [User::AGENT];
        } elseif ($userType == User::SALESORG) {
            $type = [User::SALESORG];
        } elseif ($userType == User::INSURED) {
            $type = [User::INSURED];
        }
        return User::getData(['type' => $type])->get()?->pluck("name", 'id');
    }
}
