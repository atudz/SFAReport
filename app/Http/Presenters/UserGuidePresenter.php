<?php
namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\ModelFactory;
use Auth;

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
        $this->view->tableHeaders = $this->getUserGuideTableColumns();

        return $this->view('userGuide');
    }
}
