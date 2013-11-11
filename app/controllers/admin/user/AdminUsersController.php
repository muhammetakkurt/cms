<?php

class AdminUsersController extends \BaseController {

	public function __construct()
    {
    	/*
		 *  Filter.php 'deki users filtresini çalıştır. 
		 *  Kullacının users izini yoksa giriş vermez.
		 */
        $this->beforeFilter('users');
	
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::paginate(20);
		
		$groups = Sentry::getGroupProvider()->findAll();

		$groupsselect = array();
		foreach ($groups as $group) {
			$groupsselect[$group->id] = $group->name;
		}

		$data = array('users' => $users ,'groups' => $groupsselect );
		return View::make('admin.users.users',$data);
	}

	public function search()
	{
		$search = Input::get('q');
		
		if($search!='')
		{
			$users = User::where('first_name', 'like', '%'.$search.'%')->paginate(20);	
		}
		else
		{
			return Redirect::to('users');
		}

		$groups = Sentry::getGroupProvider()->findAll();

		$groupsselect = array();
		foreach ($groups as $group) {
			$groupsselect[$group->id] = $group->name;
		}

		$data = array('users' => $users ,'groups' => $groupsselect );
		return View::make('admin.users.users',$data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$groups = Sentry::getGroupProvider()->findAll();
		$groupsselect = array();
		foreach ($groups as $group) {
			$groupsselect[$group->id] = $group->name;
		}

		$data = array('groups' => $groupsselect );
		return View::make('admin.users.create',$data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		try
		{
			$inputs = Input::all();
				
			// Create the user
		    $user = Sentry::getUserProvider()->create(array(
		        'email'    => $inputs['email'],
		        'password' => $inputs['password'],
		        'activated' => 1,
		        'first_name' => $inputs['first_name'],
		        'last_name' => $inputs['last_name'],
		   	 	));
					   // Find the group using the group id
			    $adminGroup = Sentry::getGroupProvider()->findById($inputs['group']);

			    // Assign the group to the user
			    $user->addGroup($adminGroup);
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			Session::put('status_error', array(0 => 'E-posta alanı gereklidir.'));
			return Redirect::to('users/create');
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			Session::put('status_error', array(0 => 'Şifre alanı gereklidir.'));
			return Redirect::to('users/create');
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
		    Session::put('status_error', array(0 => 'Bu giriş ile kullanıcı zaten var.'));
			return Redirect::to('users/create');
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		   	Session::put('status_error', array(0 => 'Grup bulunamadı.'));
			return Redirect::to('users/create');
		}

		return Redirect::to('users');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::find($id);
		$activities = Activity::where('user_id', $user->id)
								->orderBy('created_at','desc')
						  		->paginate(10);
		$data = array('user' => $user ,'activities' => $activities);
		return View::make('admin.users.detail',$data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = Sentry::getUserProvider()->findById($id);
		$groups = Sentry::getGroupProvider()->findAll();

		$groupsselect = array();
		foreach ($groups as $group) {
			$groupsselect[$group->id] = $group->name;
		}
		$group = $user->getGroups();
			
		$cities = City::OrderBy('name')->get();
		$cityselect = array(0 => 'Seçiniz');
		foreach ($cities as $city) {
			$cityselect[$city->id] = $city->name;
		}

		$townselect = array(0 => 'Seçiniz');
		if ($user->city_id>0)
		{
			$towns = Town::where('city_id' , '=' , $user->city_id)->orderBy('name')->get();
			
			foreach ($towns as $town) {
			$townselect[$town->id] = $town->name;
			}

		}

		$data = array('user' => $user ,'groups' => $groupsselect , 'group_id' => $group[0]['id'] , 'cities' => $cityselect , 'towns' => $townselect);
		return View::make('admin.users.edit',$data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		try
		{
			$inputs = Input::all();
		    // Update the user
		    
		    // Find the user using the user id
		    $user = Sentry::getUserProvider()->findById($id);

		    // Update the user details
		    $user->email = $inputs['email'];
		    if($inputs['password']!='')
		    {
		    	$user->password = $inputs['password'];	
		    }
		    $user->first_name = $inputs['first_name'];
		    $user->last_name = $inputs['last_name'];
		    $user->city_id = $inputs['city'];
		    $user->town_id = $inputs['town'];

		    $userGroup = $user->getGroups();
			if ($inputs['group']!=$userGroup[0]['id'])
			{
				$deleteGroup = Sentry::getGroupProvider()->findById($userGroup[0]['id']);

			    // Assign the group to the user
			    if ($user->removeGroup($deleteGroup))
			    {	
			    	// Find the group using the group id
				    $adminGroup = Sentry::getGroupProvider()->findById($inputs['group']);
					// Assign the group to the user
				    $user->addGroup($adminGroup);
			    }
			    else
			    {
			        // Group was not removed
			    }
	    	}

			// Update the user
		    if ($user->save())
		    {
		    	Session::put('status_success', array(0 => 'Kullanıcı güncellendi.'));
				return Redirect::to('users');
		        // User information was updated
		    }
		    else
		    {
		    	Session::put('status_success', array(0 => 'Kullanıcı güncellenemedi.'));
				return Redirect::to('users/'.$user->id.'/edit');
		        // User information was not updated
		    }
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
			Session::put('status_error', array(0 => 'Bu kişi zaten kayıtlı.'));
			return Redirect::to('users/'.$user->id.'/edit');
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			Session::put('status_error', array(0 => 'Kullanıcı bulunamadı.'));
			return Redirect::to('users/'.$user->id.'/edit');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		 // Find the user using the user id
	    $user = User::find($id);

	    // Delete the user
	    $user->delete();
	
		return Redirect::to('users');
	}

}