<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use Mockery\Exception;

class ErrorsPresenter extends PresenterCore
{
    public function showForbiddenPage()
    {
        abort(403);
    }
}