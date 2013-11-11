<?php

class AdminUserGroupsController extends \BaseController {

	public function __construct()
    {
    	/*
		 *  Filter.php 'deki userGroups filtresini çalıştır. 
		 *  Kullacının userGroups izini yoksa giriş vermez.
		 */
        $this->beforeFilter('userGroups');
	
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$groups = Sentry::getGroupProvider()->findAll();
		
		return View::make('admin.userGroups.userGroups')
					->with('usergroups' , $groups);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		return View::make('admin.userGroups.create');
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
			

				/*
				$permissions = $inputs['permissions'];
				$permissionArray = array();
				foreach ($permissions as $permission) {
					if(isset($permission['permission']))
					{
						$permissionArray[$permission['permission']] = 1;	
					}
				}
				*/

				// Create the group
			    $group = Sentry::getGroupProvider()->create(array(
			        'name'        => $inputs['name'],
			        //'permissions' => $permissionArray,
			    ));
			
			
		}
		catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
		{
			Session::put('status_error', array(0 => 'Grup adı gereklidir.'));
			return Redirect::to('users-groups/create');
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
		    Session::put('status_error', array(0 => 'Böyle bir grup zaten var.'));
			return Redirect::to('users-groups/create');
		}
		catch (Exception $e) 
		{
			Session::put('status_error', array(0 => $e->getMessage()));
			return Redirect::to('users-groups/create');
		}
		return Redirect::to('users-groups');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		try
		{
		    $group = Sentry::getGroupProvider()->findById($id);
			$users = DB::select("select *,
				(select CONCAT (users.first_name,' ',users.last_name) from users where users.id=users_groups.user_id limit 1)
				as full_name,
				(select users.created_at from users where users.id=users_groups.user_id limit 1)
				as created_at,
				(select users.email from users where users.id=users_groups.user_id limit 1)
				as email
				from users_groups where group_id in (".$id.")");
			$data = array('usergroup' => $group['original'] ,'users' => $users);
			return View::make('admin.userGroups.detail' , $data);
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
			Session::put('status_error', array(0 => 'Grup bulunamadı.'));
			return Redirect::to('users-groups');     
		}
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		try
		{
			$group = Sentry::getGroupProvider()->findById($id);
			return View::make('admin.userGroups.edit')->with('permissions' , Config::get('app.permissions'))->with('usergroup' , $group['original']);
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
			Session::put('status_error', array(0 => 'Grup bulunamadı.'));
			return Redirect::to('users-groups');     
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		DB::table('groups')->where('id' , '=' , $id)->update(array('permissions' => DB::raw('NULL'))); 
		try
		{
			$inputs = Input::all();

			
				// Find the group using the group id
			    $group = Sentry::getGroupProvider()->findById($id);

			    
			    	/*
					$permissions = $inputs['permissions'];
					$permissionArray = array();
					foreach ($permissions as $permission) {
						if(isset($permission['permission']))
						{
							$permissionArray[$permission['permission']] = 1;	
						}
					}
					*/
					
				    // Update the group details
				    $group->name = $inputs['name'];
				    //$group->permissions = $permissionArray;

				    // Update the group
				    if ($group->save())
				    {
				    	Session::put('status_success', array(0 => 'Grup başarı ile güncellendi.'));
						return Redirect::to('users-groups');
				        // Group information was updated
				    }
				    else
				    {
				    	throw new Exception("Grup güncellenirken hata oluştu.", 1);
				    }
				

			
		    
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
		    Session::put('status_error', array(0 => 'Grup zaten var.'));
			return Redirect::to('users-groups/'.$id.'/edit');
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    Session::put('status_error', array(0 => 'Grup bulunamadı.'));
			return Redirect::to('users-groups/'.$id.'/edit');
		}
		catch (Exception $e) 
		{
			Session::put('status_error', array(0 => $e->getMessage()));
			return Redirect::to('users-groups/'.$id.'/edit');
			
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
		try
		{
		    // Find the group using the group id
		    $group = Sentry::getGroupProvider()->findById($id);

		    // Delete the group
		    $group->delete();
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    Session::put('status_error', array(0 => 'Grup bulunamadı.'));
			return Redirect::to('users-groups');
		}
		return Redirect::to('users-groups');
	}

}