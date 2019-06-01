<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();

        $perms = array(

        	array(
        		"name"=>"add_user",
        		"display_name"=>"Add User",
        		"description"=>"N/A"
        	),
        	array(
        		"name"=>"edit_user",
        		"display_name"=>"Edit User",
        		"description"=>"N/A"
        	),
        	array(
        		"name"=>"del_user",
        		"display_name"=>"Delete User",
        		"description"=>"N/A"
        	)
        );

        foreach($perms as $perm)
			App\Permission::create($perm);
    }
}
