<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use App\Factories\ModelFactory;

class DocumentTypesPresenter extends PresenterCore
{
    /**
     * Document Types Main Page
     * @return Blade View
     */
    public function index()
    {
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('document-types',$user_group_id,$user_id);

        $this->view->tableHeaders = [
            ['name' => 'Type'],
            ['name' => 'Description'],
            ['name' => 'Actions'],
        ];

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => $user_id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
            'action_identifier' => 'visit',
            'action'            => 'visit Document Types'
        ]);

        return $this->view('index');
    }

    /**
     * Document Types Form for Create/Update
     * @return Blade View
     */
    public function add()
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','document-types')->value('id'),
            'action_identifier' => 'visit',
            'action'            => 'visit Document Types Add'
        ]);

        $this->view->state = $this->request->has('id') ? 'Edit Row' : 'Add Row';
        return $this->view('add');
    }
}