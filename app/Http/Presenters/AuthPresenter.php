<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;

class AuthPresenter extends PresenterCore
{   
    /**
     * Display login form
     * @return \Illuminate\View\View
     */
    public function login()
    {
        if(\Auth::check())
        {
            return redirect('/');
        }
        
        return $this->view('login');
    }

     /**
     * Display login form
     * @return \Illuminate\View\View
     */
    public function forgotPassword()
    {
        if(\Auth::check())
        {
            return redirect('/');
        }
        
        return $this->view('forgot');
    }

}
