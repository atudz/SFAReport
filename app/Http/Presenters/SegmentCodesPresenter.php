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

        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('segment-codes',$user_group_id,$user_id);

        $this->view->tableHeaders = [
            ['name' => 'Segment Code'],
            ['name' => 'Description'],
            ['name' => 'SAP ABBREVIATION'],
            ['name' => 'Actions'],
        ];

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => $user_id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','segment-codes')->value('id'),
            'action_identifier' => 'visit',
            'action'            => 'visit Segment Codes'
        ]);

        return $this->view('index');
    }

    /**
     * Segment Codes Form for Create/Update
     * @return Blade View
     */
    public function add()
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','segment-codes')->value('id'),
            'action_identifier' => 'visit',
            'action'            => 'visit Segment Codes Add'
        ]);

        $this->view->state = $this->request->has('id') ? 'Edit Row' : 'Add Row';
        return $this->view('add');
    }
}