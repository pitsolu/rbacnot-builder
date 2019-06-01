<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        $roles = array(

        	array(
        		"name"=>"admin",
        		"display_name"=>"Administrator",
        		"description"=>"N/A"
        	),
        	array(
        		"name"=>"superadmin",
        		"display_name"=>"Super Administrator",
        		"description"=>"N/A"
        	),
        	array(
        		"name"=>"owner",
        		"display_name"=>"Owner",
        		"description"=>"N/A"
        	)
        );

        foreach($roles as $role)
			$roles[] = App\Role::create($role);

		$roleIds = DB::table('roles')->pluck('id');
		$permIds= DB::table('permissions')->pluck('id');	

		$faker = Faker\Factory::create();

		foreach(range(0, count($permIds)) as $idx){

			DB::table('permission_role')->insert([
            	'role_id' => $faker->randomElement($roleIds),
            	'permission_id' => $faker->randomElement($permIds)
            ]);
        }

		// $id = DB::getPdo()->lastInsertId();

		// print_r($id);
    }
}
