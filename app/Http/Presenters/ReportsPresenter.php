<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;

class ReportsPresenter extends PresenterCore
{
    /**
     * Display main dashboard
     *
     * @return Response
     */
    public function dashboard()
    {
        $this->view->title = 'Dashboard';
        return $this->view('dashboard');
    }
	
    /**
     * Return sales collection view
     * @param string $type
     * @return string The rendered html view
     */
    public function salesCollection($type='report')
    {
    	switch($type)
    	{
    		case 'report':
    			return $this->view('salesCollectionReport');
    			break;
    		case 'posting':
    			return $type;
    			break;
    		case 'summary':
    			return $type;
    			break;
    	}
    }
    
    
    /**
     * Return van & inventory view
     * @param string $type
     * @return string The rendered html view
     */
    public function vanInventory($type='canned')
    {
    	switch($type)
    	{
    		case 'canned':
    			return $type;
    			break;
    		case 'forzen':
    			return $type;
    			break;
    	}
    }
    
    /**
     * Return bir view
     * @param string $type
     * @return string The rendered html view
     */
    public function bir()
    {
    	return 'bir';
    }
    
    
    /**
     * Return report sync view
     * @param string $type
     * @return string The rendered html view
     */
    public function sync()
    {
    	return 'sync';
    }
}
