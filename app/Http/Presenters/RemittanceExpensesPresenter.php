<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use App\Factories\ModelFactory;

class RemittanceExpensesPresenter extends PresenterCore
{
    public function index()
    {
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

        $this->view->salesman = PresenterFactory::getInstance('Reports')->getSalesman(true);
        $this->view->jrSalesmans = PresenterFactory::getInstance('VanInventory')->getJrSalesman();
        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('remittance-expenses-report',$user_group_id,$user_id);
        $this->view->tableHeaders = [
            ['name' => 'ID'],
            ['name' => 'Sr. Salesman'],
            ['name' => 'Jr. Salesman'],
            ['name' => 'Cash Amount'],
            ['name' => 'Check Amount'],
            ['name' => 'Date'],
            ['name' => 'Options'],
        ];

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => $user_id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
            'action_identifier' => 'visit',
            'action'            => 'visit Remittance/Expenses Report'
        ]);

        return $this->view('index');
    }

    /**
     * Auditor's List Form for Create/Update
     * @return Blade View
     */
    public function add()
    {
        $this->view->salesman = PresenterFactory::getInstance('Reports')->getSalesman(true);
        $this->view->jrSalesmans = PresenterFactory::getInstance('VanInventory')->getJrSalesman();
        $this->view->state = $this->request->has('id') ? 'Edit Row' : 'Add Row';

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => $user_id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
            'action_identifier' => 'visit',
            'action'            => 'visit Remittance/Expenses Report ' . ($this->request->has('id') ? 'Edit' : 'Add')
        ]);

        return $this->view('form');
    }
}
