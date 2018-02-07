<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;

class DeleteRemarksPresenter extends PresenterCore
{
    public function setDeleteRemarksTable($records,$table){
        foreach ($records as $index => $record) {
            $records[$index]->delete_remarks_table = $table;
        }
        return $records;
    }
}