<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;

class ReportsPresenter extends PresenterCore
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function dashboard()
    {
        $this->view->title = 'Dashboard';
        return $this->view('dashboard');
    }

}
