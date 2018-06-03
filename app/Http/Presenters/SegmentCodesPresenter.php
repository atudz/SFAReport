<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use App\Factories\ModelFactory;

class SegmentCodesPresenter extends PresenterCore
{
    /**
     * Segment Codes Main Page
     * @return Blade View
     */
    public function index()
    {
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

        $this->view->tableHeaders = [
            ['name' => 'Segment Code'],
            ['name' => 'Description'],
            ['name' => 'SAP ABBREVIATION'],
            ['name' => 'Actions'],
        ];

        return $this->view('index');
    }

    /**
     * Segment Codes Form for Create/Update
     * @return Blade View
     */
    public function add()
    {
        $this->view->state = $this->request->has('id') ? 'Edit Row' : 'Add Row';
        return $this->view('add');
    }
}