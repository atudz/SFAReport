<?php

use Illuminate\Database\Seeder;

class AlterRoleUserMatrixMenuIconTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $navigation_slugs = ['user-access-matrix','role-access-matrix'];

        foreach ($navigation_slugs as $slug) {
            if(DB::table('navigation')->where('slug', '=', $slug)->count()){
                DB::table('navigation')
                    ->where('slug', '=', $slug)
                    ->update([
                        'class' => 'glyphicon glyphicon-share-alt',
                    ]);
            }
        }
    }
}
