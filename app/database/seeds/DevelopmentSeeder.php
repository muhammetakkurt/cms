<?php
	class DevelopmentSeeder extends Seeder
	{
		public function run()
		{
		   
		   	$admins = array();
			$admins = array(
				array(
				 	'email'		 => 'ugur.aydogdu@epigra.com',
					'password'   => '12345',
					'first_name' => 'Uğur',
					'last_name'  => 'Aydoğdu',
					),
				array(
				 	'email'		 => 'ugur.arici@epigra.com',
					'password'   => '12345',
					'first_name' => 'Uğur',
					'last_name'  => 'ARICI',
					),
				array(
				 	'email'		 => 'm_akkurt@live.com',
					'password'   => '12345',
					'first_name' => 'Muhammet',
					'last_name'  => 'AKKURT',
					),
				 array(
				 	'email'		 => 'erdemkeren@gmail.com',
					'password'   => '12345',
					'first_name' => 'Hilmi Erdem',
					'last_name'  => 'KEREN',
					),
				array(
				 	'email'		 => 'admin@admin.com',
					'password'   => 'admin',
					'first_name' => 'Admin',
					'last_name'  => 'Admin',
					),
			);
			$users = array();
			$users = array(
				array(
				 	'email'		 => 'deneme@deneme.com',
					'password'   => 'deneme',
					'first_name' => 'Deneme',
					'last_name'  => 'Deneme',
					'activated'	 => 1,
					),
			);
			
			DB::table('users')->truncate();
		    DB::table('groups')->truncate();
		    DB::table('users_groups')->truncate();	
			/**
			*	Users groups for development purposes
			*	@package: Development
			*
			*	Note that, this variables also save
			*	user groups to database.
			**/
    		$adminGroup = Sentry::getGroupProvider()->create(array(
				'name'	=> 'Admin',
				'permissions' => array('superuser' => 1),
			));

			$customerGroup = Sentry::getGroupProvider()->create(array(
				'name'	=> 'Customer',
				'permissions' => array('User' => 1),
			));

			// Adds activated information for the admins here.
			$i = 0;
			foreach($admins as $user)
			{
				$admins[$i] = array_merge($user, array('activated' => true));
				$i++;
			}

		    // Admins first
			foreach ($admins as $admin) {
				$admin = Sentry::getUserProvider()->create($admin);
				$admin->addGroup($adminGroup);
			}

			// Seeding users
			foreach ($users as $user) {
				$user = Sentry::getUserProvider()->create($user);
				$user->addGroup($customerGroup);
			}


		}
	}