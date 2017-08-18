<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use App\Factories\ModelFactory;

class SfiTransactionDataPresenter extends PresenterCore
{
    public function index()
    {
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

        $this->view->salesman = PresenterFactory::getInstance('Reports')->getSalesman(true);
        $this->view->jrSalesmans = PresenterFactory::getInstance('VanInventory')->getJrSalesman();
        $reportsPresenter = PresenterFactory::getInstance('Reports');
        $this->view->areas = $reportsPresenter->getArea();
        $this->view->customers = $reportsPresenter->getCustomer(true,[
            '1000_Adjustment',
            '2000_Adjustment',
            '1000_Van to Warehouse Transaction',
            '2000_Van to Warehouse Transaction',
        ]);
        $this->view->companyCode = $reportsPresenter->getCompanyCode();
        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('sfi-transaction-data',$user_group_id,$user_id);
        $this->view->tableHeaders = [
            ['name' => 'SO number'],
            ['name' => 'Reference number'],
            ['name' => 'Activity Code'],
            ['name' => 'Customer Code'],
            ['name' => 'Customer Name'],
            ['name' => 'Customer Address'],
            ['name' => 'Remarks'],
            ['name' => 'Van Code'],
            ['name' => 'Device Code'],
            ['name' => 'Salesman Code'],
            ['name' => 'Salesman Name'],
            ['name' => 'Area'],
            ['name' => 'Invoice No/ Return Slip No.'],
            ['name' => 'Invoice Date/ Return Date'],
            ['name' => 'Invoice/Return Posting Date'],
            ['name' => 'Taxable Amount'],
            ['name' => 'Vat Amount'],
            ['name' => 'Discount Rate Per Item'],
            ['name' => 'Discount Amount Per Item'],
            ['name' => 'Collective Discount Rate'],
            ['name' => 'Collective Discount Amount'],
            ['name' => 'Reference No.'],
            ['name' => 'Remarks'],
            ['name' => 'Total Sales'],
            ['name' => 'Segment'],
            ['name' => 'Segment Abbr.'],
            ['name' => 'Document Type'],
            ['name' => 'Company Code'],
            ['name' => 'Header Text'],
            ['name' => 'GL Account'],
            ['name' => 'Tax Code'],
            ['name' => 'PROFIT CENTER'],
            ['name' => 'DETAIL TEXT']
        ];

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => $user_id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','sfi-transaction-data')->value('id'),
            'action_identifier' => 'visit',
            'action'            => 'visit SFI Transaction Data'
        ]);

        return $this->view('index');
    }
}