<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\ModelFactory;
use App\Factories\PresenterFactory;

class UserActivityLogPresenter extends PresenterCore
{
    /**
     * Loads User Activity Logs Page
     * @return Laravel Blade View
     */
    public function index(){
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

        $this->view->pageTitle = 'User Activity Log';
        $this->view->users = PresenterFactory::getInstance('UserAccessMatrix')->getUserList();
        $this->view->navigations = ModelFactory::getInstance('Navigation')->lists('name','id');
        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('user-activity-log',$user_group_id,$user_id);

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'       => $user_id,
            'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','user-activity-log')->value('id'),
            'action_identifier' => 'visit',
            'action'        => 'visit User Management - User Activity Log'
        ]);

        return $this->view('index');
    }
}