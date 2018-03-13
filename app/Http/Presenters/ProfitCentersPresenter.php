<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use App\Factories\ModelFactory;

class ProfitCentersPresenter extends PresenterCore
{
    /**
     * Profile Centers Main Page
     * @return Blade View
     */
    public function index()
    {
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('profit-centers',$user_group_id,$user_id);

        $this->view->tableHeaders = [
            ['name' => 'Profit Ctr'],
            ['name' => 'AREA'],
            ['name' => 'Actions'],
        ];

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => $user_id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
            'action_identifier' => 'visit',
            'action'            => 'visit Profit Centers'
        ]);

        return $this->view('index');
    }

    /**
     * Profile Centers Form for Create/Update
     * @return Blade View
     */
    public function add()
    {
    	
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','profit-centers')->value('id'),
            'action_identifier' => 'visit',
            'action'            => 'visit Profit Centers Add'
        ]);

        $this->view->areas = PresenterFactory::getInstance('Reports')->getArea();        
        $this->view->state = $this->request->has('id') ? 'Edit Row' : 'Add Row';
        return $this->view('add');
    }
}