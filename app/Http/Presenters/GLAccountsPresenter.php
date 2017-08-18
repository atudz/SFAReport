<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use App\Factories\ModelFactory;

class GLAccountsPresenter extends PresenterCore
{
    /**
     * GL Accounts Main Page
     * @return Blade View
     */
    public function index()
    {
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('gl-accounts',$user_group_id,$user_id);

        $this->view->tableHeaders = [
            ['name' => 'Code'],
            ['name' => 'Description'],
            ['name' => 'Actions'],
        ];

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => $user_id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
            'action_identifier' => 'visit',
            'action'            => 'visit GL Accounts'
        ]);

        return $this->view('index');
    }

    /**
     * GL Accounts Form for Create/Update
     * @return Blade View
     */
    public function add()
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','gl-accounts')->value('id'),
            'action_identifier' => 'visit',
            'action'            => 'visit GL Accounts Add'
        ]);

        $this->view->state = $this->request->has('id') ? 'Edit Row' : 'Add Row';
        return $this->view('add');
    }
}