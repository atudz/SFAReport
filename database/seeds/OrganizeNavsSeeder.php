<?php

use Illuminate\Database\Seeder;
use App\Factories\ModelFactory;

class OrganizeNavsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $userGuideNav = ModelFactory::getInstance('Navigation')->where('name','User Guide')->first();
        if($userGuideNav)
        {
        	$userGuideNav->parent_id = 8;
        	$userGuideNav->order = 2;
        	$userGuideNav->class = 'glyphicon glyphicon-share-alt';
        	$userGuideNav->save();
        }
        
        $invoiceSeriesNav = ModelFactory::getInstance('Navigation')->where('name','Invoice Series Mapping')->first();
        if($invoiceSeriesNav)
        {
        	$invoiceSeriesNav->parent_id = 0;
        	$invoiceSeriesNav->order = 16;
        	$invoiceSeriesNav->class = 'glyphicon glyphicon-file';
        	$invoiceSeriesNav->save();
        }
        
        $bounceCheckNav = ModelFactory::getInstance('Navigation')->where('name','Bounce Check')->first();
        if($bounceCheckNav)
        {
        	$bounceCheckNav->name = 'Bounce Check';
        	$bounceCheckNav->parent_id = 0;
        	$bounceCheckNav->order = 17;
        	$bounceCheckNav->class = 'glyphicon glyphicon-check';
        	$bounceCheckNav->save();
        }
    }
}
