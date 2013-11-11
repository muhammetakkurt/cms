<?php 

	/**
	*  Kullanıcılar için gerekli ajax fonksiyonlarını içerir
	*/
	class AdminUsersAjaxController extends BaseController
	{
		
		public function getUsers()
		{
			$users = User::where('first_name', 'like', '%'.Input::get('query').'%')->get();
			$usersSelect = array();
			$i = 0;
			foreach ($users as $user) {
				$usersSelect[$i]['id'] = $user->id;
				$usersSelect[$i]['first_name'] = $user->first_name;
				$i++;
			}
			return json_encode($usersSelect, JSON_UNESCAPED_UNICODE);
		}

		public function getUsersSearch()
		{
			$users = User::where('first_name', 'like', '%'.Input::get('query').'%')->get();
			$usersSelect = array();
			$i=0;
			foreach ($users as $user) {
				$usersSelect[$i]['id'] = $user->id;
				$usersSelect[$i]['name'] = $user->fullName();
				$i++;
			}
			return json_encode($usersSelect, JSON_UNESCAPED_UNICODE);
		}
	}