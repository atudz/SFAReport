<?php
namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\ModelFactory;
use Auth;
use App\Factories\PresenterFactory;

class UserGuidePresenter extends PresenterCore
{
    /**
     * Get Summary incident of report table columns.
     * @return multitype:multitype:string
     */
    public function getUserGuideTableColumns()
    {
        $headers = [
            ['name' => 'Role'],
            ['name' => 'Filename'],
            ['name' => 'Action']
        ];

        return $headers;
    }

    /**
     * Get the list of summary of incident reports.
     * @return mixed
     */
    public function getUserGuideReports()
    {
        $data['records'] = $this->getPreparedUserGuideReportList();
        $data['total'] = count($data['records']);

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'       => auth()->user()->id,
            'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','user-guide')->value('id'),
            'action'        => 'finished loading User Guide data'
        ]);

        return response()->json($data);
    }

    public function getPreparedUserGuideReportList()
    {
        $userGroup = ModelFactory::getInstance('UserGroup');
        $userRole = $userGroup->whereId(Auth::user()->user_group_id)->first();

        $userGroup = $userGroup->where('name', '!=', 'Supper Admin')->with('file');
        if ($userRole->name == 'Supper Admin') {
            return $userGroup->get();
        }

        return $userGroup->whereName($userRole->name)->get();
    }

    /**
     * This function will view the user guide.
     * @return mixed
     */
    public function userGuide()
    {
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;
        $this->view->tableHeaders = $this->getUserGuideTableColumns();
        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('user-guide',$user_group_id,$user_id);

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'       => $user_id,
            'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','user-guide')->value('id'),
            'action'        => 'visit User Guide'
        ]);

        return $this->view('userGuide');
    }
}
