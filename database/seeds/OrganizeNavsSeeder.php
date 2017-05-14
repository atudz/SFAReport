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
        	$invoiceSeriesNav->parent_id = 2;
        	$invoiceSeriesNav->order = 6;
        	$invoiceSeriesNav->class = 'glyphicon glyphicon-share-alt';
        	$invoiceSeriesNav->save();
        }
        
        $bounceCheckNav = ModelFactory::getInstance('Navigation')->where('name','Bounce Check Report')->first();
        if($bounceCheckNav)
        {
        	$bounceCheckNav->name = 'Bounce Check';
        	$bounceCheckNav->parent_id = 2;
        	$bounceCheckNav->order = 7;
        	$bounceCheckNav->class = 'glyphicon glyphicon-share-alt';
        	$bounceCheckNav->save();
        }
    }
}
