<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('role_user')->delete();
        DB::table('users')->delete();

        App\User::create(array(

        	'name'=>"pitsolu",
        	'password'=>bcrypt("p@55w0rd**8"),
        	'email'=>"pitsolu@gmail.com"
        ));

        $userIds = DB::table('users')->pluck('id');
		$roleIds = DB::table('roles')->pluck('id');	

		$faker = Faker\Factory::create();

		$userRoles = [];

		foreach(range(0, count($roleIds)) as $idx){

			$userRole = array(

            	'role_id' => $faker->randomElement($roleIds),
            	'user_id' => $faker->randomElement($userIds)
            );

			$key = sha1(json_encode($userRole));
			if(!in_array($key, array_keys($userRoles)))
				$userRoles[$key] = $userRole;
        }

        DB::table('role_user')->insert($userRoles);
    }
}
