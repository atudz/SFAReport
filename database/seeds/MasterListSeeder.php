<?php

use Illuminate\Database\Seeder;
use App\Http\Models\UserGroupToNavPermission;
use App\Http\Models\NavigationPermission;
use Carbon\Carbon;

class MasterListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$today = new Carbon();
    	
    	// Navigation sub menu items
    	$navigation_item = ['name'=>'Master List','url'=>'','slug'=>'master-list','class'=>'glyphicon glyphicon-th-large','parent_id'=>0,'order'=>15,'created_at' => $today,'updated_at'=>$today];
    	
    	$id = DB::table('navigation')->insertGetId($navigation_item);
    	if($id){

    		$adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');
    		$today = new Carbon();
    		$mappings[] = [
    				'navigation_id' => $id,
    				'user_group_id' => $adminID,
    				'created_at'    => $today,
    				'updated_at'    => $today,
    		];
    		
    		DB::table('user_group_to_nav')->insert($mappings);
    		DB::table('navigation')->where('name','Invoice Series Mapping')->update(['parent_id'=>$id,'order'=>1,'class'=>'glyphicon glyphicon-share-alt']);
    		DB::table('navigation')->where('name','Bounce Check')->update(['parent_id'=>$id,'order'=>2,'class'=>'glyphicon glyphicon-share-alt']);
    		DB::table('navigation')->where('name','Master (Customer)')->update(['parent_id'=>$id,'order'=>3,'class'=>'glyphicon glyphicon-share-alt']);
    		DB::table('navigation')->where('name','Master (Salesman)')->update(['parent_id'=>$id,'order'=>4,'class'=>'glyphicon glyphicon-share-alt']);
    		DB::table('navigation')->where('name','Master (Material Price)')->update(['parent_id'=>$id,'order'=>5,'class'=>'glyphicon glyphicon-share-alt']);
    		    		
    		$permissions = [
    				[
    						'created_at' => $today,
    						'updated_at' => $today,
    						'navigation_id' => $id,
    						'permission'    => 'master_list',
    						'description'   => 'Master List'
    				],    				
    		];    		
    		//dd($permissions,$adminID);
    		
    		foreach($permissions as $permission) {
    			$permission_id = NavigationPermission::insertGetId($permission);
    			UserGroupToNavPermission::create(['user_group_id' => $adminID , 'permission_id' => $permission_id]);
    		}
    	}
    	
    }
}
