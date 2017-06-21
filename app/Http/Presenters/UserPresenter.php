<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\FilterFactory;
use App\Factories\PresenterFactory;
use App\Factories\ModelFactory;
use DB;
use Lava;
use PDF;

class UserPresenter extends PresenterCore
{
	/**
	 * Return User List view
	 * @param string $type
	 * @return string The rendered html view
	 */
	public function userList()
	{
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

		$this->view->roles = $this->getRoles();		
		$this->view->assignmentOptions = $this->getAssignmentOptions();
		$this->view->tableHeaders = $this->getUserTableColumns();
		$this->view->areas = PresenterFactory::getInstance('Reports')->getArea(true);
		$this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('user-list',$user_group_id,$user_id);

		ModelFactory::getInstance('UserActivityLog')->create([
		    'user_id'       	=> $user_id,
		    'navigation_id' 	=> ModelFactory::getInstance('Navigation')->where('slug','=','user-list')->value('id'),
            'action_identifier' => 'visit',
		    'action'        	=> 'visit User Management - User List'
		]);

		return $this->view('users');
	}

	/**
	 * Display Contact us form.
	 * @return string The rendered html view
	 */
	public function contactUs()
	{
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

		$this->view->branch = PresenterFactory::getInstance('Reports')->getArea(true);
		$this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('contact-us',$user_group_id,$user_id);

		ModelFactory::getInstance('UserActivityLog')->create([
		    'user_id'       	=> $user_id,
		    'navigation_id' 	=> ModelFactory::getInstance('Navigation')->where('slug','=','contact-us')->value('id'),
            'action_identifier' => 'visit',
		    'action'        	=> 'visit Support Page - Contact Us'
		]);

		return $this->view('contactUs');
	}

	/**
	 * Return Summary of incidents reports.
	 * @return string The rendered html view
	 */
	public function summaryOfIncidentReport()
	{
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

		$this->view->roles = $this->getRoles();
		$this->view->name = $this->contactUsName();
		$this->view->tableHeaders = $this->getIncidentReportTableColumns();
		$this->view->branch = PresenterFactory::getInstance('Reports')->getArea(true);
		$this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('summary-of-incident-report',$user_group_id,$user_id);

		ModelFactory::getInstance('UserActivityLog')->create([
		    'user_id'       	=> $user_id,
		    'navigation_id' 	=> ModelFactory::getInstance('Navigation')->where('slug','=','summary-of-incident-report')->value('id'),
            'action_identifier' => 'visit',
		    'action'        	=> 'visit Support Page - Summary of Incident Report'
		]);
		return $this->view('summaryOfIncidentReport');
	}
	
	/**
	 * Return User Group Rights view
	 * @param string $type
	 * @return string The rendered html view
	 */
	public function userGroupRights()
	{
		$this->view->tableHeaders = $this->getRoleTableColumns();
		return $this->view('userGroupRights');
	}

	
	/**
	 * Display add edit form
	 * @param number $userId
	 * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory>
	 */
	public function addEdit($userId=0)
	{
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

		$this->view->assignmentOptions = $this->getAssignmentOptions();
		$this->view->roles = $this->getRoles();
		$this->view->gender = $this->getGender();
		$this->view->areas = PresenterFactory::getInstance('Reports')->getArea(true);
		$this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('user-list',$user_group_id,$user_id);

		ModelFactory::getInstance('UserActivityLog')->create([
		    'user_id'       	=> $user_id,
		    'navigation_id' 	=> ModelFactory::getInstance('Navigation')->where('slug','=','user-list')->value('id'),
            'action_identifier' => 'visit',
		    'action'        	=> 'visit User Management - User List (Add)'
		]);

		return $this->view('addEdit');
	}

	/**
	 * Get user info
	 * @param number $userId
	 * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory>
	 */
	public function getUser($userId)
	{
		$user = ModelFactory::getInstance('User')->find($userId);
		$user->jr_salesman_code = '';
		if (strpos($user->salesman_code, '-')) {
			$code = explode('-', $user->salesman_code);
			$user->jr_salesman_code = $user->salesman_code;
			$user->salesman_code = $code[0];
		}
		$data = $user ? $user->toArray() : [];

		return $data;
	}
	
	
	/**
	 * Display add edit form
	 * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory>
	 */
	public function edit()
	{
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

		$this->view->assignmentOptions = $this->getAssignmentOptions();
		$this->view->roles = $this->getRoles();
		$this->view->gender = $this->getGender();
		$this->view->areas = PresenterFactory::getInstance('Reports')->getArea(true);
		$this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('user-list',$user_group_id,$user_id);

		ModelFactory::getInstance('UserActivityLog')->create([
		    'user_id'       	=> $user_id,
		    'navigation_id' 	=> ModelFactory::getInstance('Navigation')->where('slug','=','user-list')->value('id'),
            'action_identifier' => 'visit',
		    'action'        	=> 'visit User Management - User List (Edit)'
		]);

		return $this->view('edit');
	}
	
	
	public function changePassword(){
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;
        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('user-management',$user_group_id,$user_id);
		ModelFactory::getInstance('UserActivityLog')->create([
		    'user_id'       	=> $user_id,
		    'navigation_id' 	=> ModelFactory::getInstance('Navigation')->where('slug','=','user-management')->value('id'),
            'action_identifier' => 'visit',
		    'action'        	=> 'visit My Profile - Change Password'
		]);
		return $this->view('changePassword');
	}
	
	public function profile(){
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

		$this->view->assignmentOptions = $this->getAssignmentOptions();
		$this->view->roles = $this->getRoles();
		$this->view->gender = $this->getGender();
		$admin = $this->isAdmin();
		$this->view->areas = PresenterFactory::getInstance('Reports')->getArea();
		$this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('user-management',$user_group_id,$user_id);
		$this->view->readOnly = $this->view->navigationActions['read_only_profile'] ? 'changePassword' : '';

		$user_id_for_chart = $this->request->has('user_id') ? $this->request->get('user_id') : $user_id;
		$this->view->chart = $this->prepareUserStatisticsChart($user_id_for_chart,'Desktop');
		$this->view->chart_mobile = $this->prepareUserStatisticsChart($user_id_for_chart,'Mobile');

		ModelFactory::getInstance('UserActivityLog')->create([
		    'user_id'       	=> $user_id,
		    'navigation_id' 	=> ModelFactory::getInstance('Navigation')->where('slug','=','user-management')->value('id'),
            'action_identifier' => 'visit',
		    'action'        	=> 'visit My Profile'
		]);
		return $this->view('myProfile');
	}
	
	/**
	 * Get my profile
	 * @return \App\Http\Presenters\Ambigous
	 */
	public function myProfile(){
		ModelFactory::getInstance('UserActivityLog')->create([
		    'user_id'       	=> auth()->user()->id,
		    'navigation_id' 	=> ModelFactory::getInstance('Navigation')->where('slug','=','user-management')->value('id'),
            'action_identifier' => '',
		    'action'        	=> 'retrieving My Profile'
		]);
		ModelFactory::getInstance('UserActivityLog')->create([
		    'user_id'       	=> auth()->user()->id,
		    'navigation_id' 	=> ModelFactory::getInstance('Navigation')->where('slug','=','user-management')->value('id'),
            'action_identifier' => '',
		    'action'        	=> 'done retrieving My Profile'
		]);
		$user_id = $this->request->has('user_id') ? $this->request->get('user_id') : auth()->user()->id;
		return response()->json($this->getUser($user_id));
	}
	
	/**
	 * Get user roles
	 */
	public function getRoles()
	{
		return \DB::table('user_group')->where('name', '!=', 'Supper Admin')->lists('name','id');
	}

	/**
	 * Get User name of report.
     */
	public function contactUsName()
	{
		return ModelFactory::getInstance('ContactUs')->distinct()->get()->lists('full_name', 'full_name');
	}

	/**
	 * Get the prepared list of summary of incident reports.
	 * @param bool $withCode
	 * @return
	 */
	public function getPreparedSummaryOfIncidentReportList($withCode = true)
	{
		$summary = ModelFactory::getInstance('ContactUs')->with('users', 'areas', 'file');
		if ($this->request->has('name') && !is_numeric($this->request->get('name'))) {
			$filterName = FilterFactory::getInstance('Text');
			$summary = $filterName->addFilter($summary, 'name', function ($self, $model) {
				return $model->where('full_name', $self->getValue());
			});
		}

		if ($this->request->has('branch') && $this->request->get('branch') != 0) {
			$filterBranch = FilterFactory::getInstance('Select');
			$summary = $filterBranch->addFilter($summary, 'branch', function ($self, $model) {
				return $model->where('location_assignment_code', $self->getValue());
			});
		}

		if ($this->request->has('incident_no') && $this->request->get('incident_no') != '') {
			$filterIncidentNo = FilterFactory::getInstance('Text');
			$summary = $filterIncidentNo->addFilter($summary, 'incident_no', function ($self, $model) {
				return $model->where('id', $self->getValue());
			});
		}
		if ($this->request->has('subject') && $this->request->get('subject') != '') {
			$filterSubject = FilterFactory::getInstance('Text');
			$summary = $filterSubject->addFilter($summary, 'subject', function ($self, $model) {
				return $model->where('subject', $self->getValue());
			});
		}

		if ($this->request->has('action') && $this->request->get('action') != '') {
			$filterAction = FilterFactory::getInstance('Text');
			$summary = $filterAction->addFilter($summary, 'action', function ($self, $model) {
				return $model->where('action', $self->getValue());
			});
		}

		if ($this->request->has('status') && $this->request->get('status') != '') {
			$filterStatus = FilterFactory::getInstance('Text');
			$summary = $filterStatus->addFilter($summary, 'status', function ($self, $model) {
				return $model->where('status', $self->getValue());
			});
		}

		if ($this->request->has('date_range_from') && $this->request->get('date_range_from') != '' && $this->request->has('date_range_to') && $this->request->has('date_range_to') != '') {
			if ($this->request->get('date_range_from') > $this->request->has('date_range_to')) {
				$response['exists'] = true;
				$response['error'] = 'Invalid date range.';

				return response()->json($response);
			}

			$filterDateRange = FilterFactory::getInstance('DateRange');
			$summary = $filterDateRange->addFilter($summary, 'date_range', function ($self, $model) {
				return $model->whereBetween('created_at', $self->formatValues($self->getValue()));
			});
		}
		if ($withCode) {
			return $summary->orderBy('created_at', 'desc')->get();
		} else {
			return $summary;
		}
	}

	/**
	 * Get the list of summary of incident reports.
	 * @return mixed
     */
	public function getSummaryOfIncidentReports()
	{

		$data['records'] = $this->getPreparedSummaryOfIncidentReportList();
		$data['total'] = count($data['records']);

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'       	=> auth()->user()->id,
            'navigation_id' 	=> ModelFactory::getInstance('Navigation')->where('slug','=','summary-of-incident-report')->value('id'),
            'action_identifier' => '',
            'action'        	=> 'done loading User Guide data'
        ]);

		return response()->json($data);
	}
	
	/**
	 * Get user emails
	 */
	public function getUserEmails($id=0, $json=true)
	{
		$prepare = \DB::table('user');
		if($id)
		{
			$prepare = $prepare->where('id','<>',$id);
		}
		$result = $prepare->whereNull('deleted_at')->lists('email','id');
		return $json ? response()->json($result) : $result;
	}
	
	/**
	 * Get user emails
	 */
	public function getUsernames($id=0, $json=true)
	{
		$prepare = \DB::table('user');
		if($id)
		{
			$prepare = $prepare->where('id','<>',$id);
		}
		
		$result = $prepare->whereNull('deleted_at')->lists('username','id');
		return $json ? response()->json($result) : $result;
	}
	
	/**
	 * Get assignment options
	 * @return multitype:string
	 */
	public function getAssignmentOptions()
	{
		return [
			1 => 'Permanent',
			2 => 'Reassigned',
			3 => 'Temporary'			
		];	
	}
	
	/**
	 * Get gender
	 * @return multitype:string
	 */
	public function getGender()
	{
		return [
				//0 => 'NA',
				1 => 'Male',
				2 => 'Female'
		];
	}
	
	public function getUsers()
	{
		$select = '
				user.id,
				user.created_at,
				CONCAT(user.firstname,\' \',user.lastname) fullname,
				app_area.area_name,
				IF(user.location_assignment_type = 1, \'Permanent\', IF(user.location_assignment_type = 2, \'Reassigned\', IF(user.location_assignment_type = 3, \'Temporary\', \'\'))) assignment,
				user_group.name role,
				user.status,
				user.email
				';
		
		$prepare = \DB::table('user')
						->selectRaw($select)
						->leftJoin('user_group','user.user_group_id','=','user_group.id')
						->leftJoin('app_area','app_area.area_code','=','user.location_assignment_code');

		if ($this->request->has('sort') || $this->request->has('order')) {
			$sort = $this->request->get('sort') != 'lastname' ? $this->request->get('sort') : 'fullname';
			$prepare->orderBy($sort, $this->request->get('order'));
		}
		 
		$fnameFilter = FilterFactory::getInstance('Text');
		$prepare = $fnameFilter->addFilter($prepare,'fullname', function($filter, $model){
						return $model->where(function ($query) use ($filter){
							$query->where('user.firstname','like','%'.$filter->getValue().'%')
								  ->where('user.lastname','like','%'.$filter->getValue().'%','or');
						});						
					});
				
		$roleFilter = FilterFactory::getInstance('Select');
		$prepare = $roleFilter->addFilter($prepare,'user_group_id');
		
		$createdFilter = FilterFactory::getInstance('DateRange');
		$prepare = $createdFilter->addFilter($prepare,'created_at', function ($filter, $model){
					return $model->whereBetween(\DB::raw('DATE(user.created_at)'),$filter->getValue());			
					});
		
		$branchFilter = FilterFactory::getInstance('Select');
		$prepare = $branchFilter->addFilter($prepare,'location_assignment_code');
		
		$assignmentFilter = FilterFactory::getInstance('Select');
		$prepare = $assignmentFilter->addFilter($prepare,'location_assignment_type');
		
		$exclude = [1,auth()->user()->id];
		$prepare->whereNotIn('user.id',$exclude);
		$prepare->whereNull('user.deleted_at');
		
		//dd($prepare->toSql());
		$result = $this->paginate($prepare);
		
		$items = $result->items();
		
		foreach($items as $k=>$item)
		{
			if($item->status == 'A')
				$items[$k]->active = true;
			else
				$items[$k]->active = false;
		}
		
		$data['records'] = $items;
		$data['total'] = $result->total();
		

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'       	=> auth()->user()->id,
            'navigation_id' 	=> ModelFactory::getInstance('Navigation')->where('slug','=','user-list')->value('id'),
            'action_identifier' => '',
            'action'        	=> 'done loading User Management - User List data'
        ]);

		return response()->json($data);
		
		
	}
	

	public function getUserGroup()
	{
		$select = 'id, name';
		
		$prepare = \DB::table('user_group')
						->selectRaw($select);	
		 
		//dd($prepare->toSql());
		$result = $this->paginate($prepare);
		
		$items = $result->items();
		
		$data['records'] = $items;
		$data['total'] = $result->total();
		
		return response()->json($data);
		
		
	}

	/**
	 * Get User Table Columns
	 * @return multitype:multitype:string
	 */
	public function getUserTableColumns()
	{
		$headers = [
				['name'=>'Full Name', 'sort'=>'lastname'],
				['name'=>'Email', 'sort'=>'email'],
				['name'=>'Role', 'sort'=>'role'],
				['name'=>'Branch', 'sort'=>'area_name'],
				['name'=>'Assignment', 'sort'=>'assignment'],
				['name'=>'Date Created', 'sort'=>'created_at'],
				['name'=>'Actions'],				
		];
		 
		return $headers;
	}

	/**
	 * Get Summary incident of report table columns.
	 * @return multitype:multitype:string
	 */
	public function getIncidentReportTableColumns()
	{
		$headers = [
			['name' => 'Incident #', 'sort' => 'id'],
			['name' => 'Date', 'sort' => 'created_at'],
			['name' => 'Subject', 'sort' => 'subject'],
			['name' => 'Summary', 'sort' => 'message'],
			['name' => 'Reported By', 'sort' => 'name'],
			['name' => 'Branch', 'sort' => 'location_assignment_code'],			
			['name' => 'Status', 'sort' => 'status'],					
			['name' => 'Action', 'sort' => 'action'],
		];

		return $headers;
	}

	/**
	 * Get UserGroup Table Columns
	 * @return multitype:multitype:string
	 */
	public function getRoleTableColumns()
	{
		$headers = [
				['name'=>'ID', 'sort'=>'id'],
				['name'=>'Name', 'sort'=>'name']		
		];
		 
		return $headers;
	}

	/**
	 * This function will query the max file size in settings table.
	 * @return mixed
	 */
	public function getFileSize()
	{
		return ModelFactory::getInstance('Setting')->where('name', 'max_file_size')->select('value')->first();
	}

	public function prepareUserStatisticsChart($user_id,$name){
		$user_statistics = ModelFactory::getInstance('UserActivityLog')
							->select(
								DB::raw('DISTINCT(action_identifier)'),
								DB::raw('COUNT(*) as count')
							)
							->where('action_identifier', '!=', '')
							->where('user_id', '=', $user_id)
							->groupBy('action_identifier')
							->get();

		$reasons = Lava::DataTable();
		$reasons
			->addStringColumn('Reasons')
    		->addNumberColumn('Percent');

		foreach ($user_statistics as $statistics) {
			$reasons
				->addRow([
					ucwords($statistics->action_identifier), 
					$statistics->count
				]);
		}

		return Lava::PieChart($name, $reasons, [
		    'title'  => 'User Statistics',
		    'is3D'   => false,
		    'height' => 400,
		    'width'  => 400,
		    'legend' => [
		        'position' => 'top',
		        'maxLines' => 8
		    ],
            'events' => [
                'ready' => 'getImageCallback'
            ]
		]);
	}

	public function statisticsDownload($user_id){
		$user_info = $this->getUser($user_id);

		$user_info['gender'] = 'Not Specified';

		if($user_info['gender'] == 1){
			$user_info['gender'] = 'Male';
		}

		if($user_info['gender'] == 2){
			$user_info['gender'] = 'Female';
		}

		foreach ($this->getRoles() as $key => $value) {
			if($user_info['user_group_id'] == $key){
				$user_info['role'] = $value;
				break;
			}
		}
		$user_info['assignment_type'] = '-';
		foreach ($this->getAssignmentOptions() as $key => $value) {
			if($user_info['location_assignment_type'] == $key){
				$user_info['assignment_type'] = $value;
				break;
			}
		}
		$user_info['branch'] = '-';
		foreach (PresenterFactory::getInstance('Reports')->getArea() as $key => $value) {
			if($user_info['location_assignment_code'] == $key){
				$user_info['branch'] = $value;
				break;
			}
		}

		$pdf = PDF::loadView('User.pdfUserStatistics',[
			'image_string' => $this->request->get('image_string'),
			/*'image_string' => 'iVBORw0KGgoAAAANSUhEUgAAAZAAAAGQCAYAAACAvzbMAAAgAElEQVR4XuxdB1QU1/f+6FVp0lFAsKFi7y3GqIldsUajxiSm9/pP1fxM7z0xlsTejYkl9t6liAURBRUEFZAivez+zx2yuOACu7Ozy+xy3zk5SeDd8r47vG9emXstlEqlEtwYAUaAEWAEGAEdEbBgAtERMe7OCDACjAAjICDABMIPAiPACDACjIAoBJhARMHGQowAI8AIMAJMIPwMMAKMACPACIhCgAlEFGwsxAgwAowAI8AEws8AI8AIMAKMgCgEmEBEwcZCjAAjwAgwAkwg/AwwAowAI8AIiEKACUQUbCzECDACjAAjwATCzwAjwAgwAoyAKASYQETBxkKMACPACDACTCD8DDACjAAjwAiIQoAJRBRs9S9UUFAAyoPp5ORU/86wB4wAI9AgEWACERH2K1euIDg4GL///jsef/xxQUNRURF69OiBsLAwLF++HJaWliI01y1y+PBhTJ8+HYmJiULnbt264aeffhL+TS0lJQXnz5/HkCFD6lR24sQJgYDatm2Lv/76C2PHjsXJkyfRtWvXWmXFytXpEHdgBBgBk0KACUREuBISEtCyZUv8+OOPePbZZysJpEuXLggJCREmY0MQSFpaGvz8/DB48GA8+uijuHnzJl5++WV4eXnhwoULcHZ2RseOHfHMM89U+lXT8FQkGB0dLcgQKfzxxx+CvhYtWtSIilg5ETCzCCPACMgcASYQEQGqiUBoBdK6dWusXLkSOTk5+Oyzz4R/wsPD8dBDD+G9994T3vhv3LiB//u//xMmbPr5119/LcjR5EzEMHr0aGzatAnt27fHt99+W0lGRBJt2rTBc889h48++giNGzfGrl27cPr0aURERAh23377bcHeuHHjBHvr1q3DN998g3PnzuG+++7DW2+9BSI66r9lyxZ07txZ+Jm/v7+wknn33XcFAvntt9/w4YcforCwEMOHD8f//vc/NG3atFY58u3SpUuCvvXr1wtjI329e/dGVlZWjXiICAGLMAKMgAwQYAIREQRtCIQm37lz5wqTcnp6OubMmYPXX39dmJSJaGJjY/HGG28IJEKNJniaZGllo2rvv/++oEPVcnNz0atXL2GLihpN/q+99ppAFnZ2dvjggw8E/dSef/55zJgxQ9iOou2tCRMm4Msvv4Srqysi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BAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDT8W9NhAAAAZUlEQVQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgIABCShBBAIECDQKGJDG1mQmQIBAgMA/b+E05RjJAv0AAAAASUVORK5CYII=',*/
			'user_info'    => $user_info
		]);
		return $pdf->setPaper('letter','portrait')->stream();
		// return $pdf->setPaper('letter','portrait')->download('invoice.pdf');
	}
}
