<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;

class MainPresenter extends PresenterCore
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function home()
    {
        if (\Auth::check()){
            return PresenterFactory::getInstance('Reports')->dashboard();
        } else {
            return redirect('/');
        }
    }

}
