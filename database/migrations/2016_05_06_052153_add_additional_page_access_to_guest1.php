<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalPageAccessToGuest1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $parentId = $this->getMenuId('Sales & Collection');

        if($parentId)
        {
            $menuId = $this->getMenuId('Report');

            $guestId = $this->getGroupId();

            if($menuId && $guestId)
            {
                $params = ['navigation_id'=>$menuId,'user_group_id'=>$guestId,'created_at' => new DateTime()];
                DB::table('user_group_to_nav')->insert($params);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $parentId = $this->getMenuId('Sales & Collection');

        if($parentId)
        {
            $menuId = $this->getMenuId('Report');

            $guestId = $this->getGroupId();

            if($menuId && $guestId)
            {
                DB::table('user_group_to_nav')
                    ->where('navigation_id', '=', $menuId)
                    ->where('user_group_id', '=', $guestId)
                    ->delete();
            }
        }
    }

    protected function getMenuId($name, $parentId = 0)
    {
        $db = DB::table('navigation')->where('name', '=', $name);

        if($parentId)
        {
            $db->where('parent_id', '=', $parentId);
        }

        return $db->value('id');
    }

    protected function getGroupId()
    {
        return DB::table('user_group')->where(['name'=>'Guest1'])->value('id');
    }
}
