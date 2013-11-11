<?php

class AdminProfileController extends BaseController {


	public function getIndex()
	{
		return View::make('admin.profile.profile');
	}

	public function postIndex()
	{

    	/*
		 *  /profile sayfasında bulunan Profil düzenleme Forundan gelen POST
		 */
    	try
		{
				$posted = Input::get();
			    // Find the user using the user id
			    $user = Sentry::getUserProvider()->findById(Sentry::getUser()->id);

			    // Update the user details
			    if ($posted['first_name'])
			    {
			    	$user->first_name = $posted['first_name'];
			    }
			    else
			    {
			    	Session::put('status_error', array(0 => 'Adı alanını gereklidir.'));
					return Redirect::to('profile');
			    }
			    if ($posted['last_name'])
			    {
			    	$user->last_name = $posted['last_name'];
			    }
			    else
			    {
			    	Session::put('status_error', array(0 => 'Soyadı alanını gereklidir.'));
					return Redirect::to('profile');
			    }
			    $user->email = $posted['email'];
			    // Update the user
			    if ($user->save())
			    {	
			    	/*
			    	$helpers = new Helpers();
			    	*/
        			//Helpers::save_log($user->id, 'profile_edit',NULL,NULL);
			        
			        Session::put('status_success', array(0 => 'Güncelleme gerçekleştirildi.'));
					return Redirect::to('profile');
			    }
			    else
			    {
			        Session::put('status_error', array(0 => 'Güncelleme gerçekleştirilemedi.'));
					return Redirect::to('profile');
			    }
			}
			catch (Cartalyst\Sentry\Users\UserExistsException $e)
			{
			    Session::put('status_error', array(0 => 'Bu E-postada zaten kullanıcı var.'));
				return Redirect::to('profile');
			}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    Session::put('status_error', array(0 => 'Kullanıcı bulunamadı'));
			return Redirect::to('profile');
		}
	}


	public function getChangePassword()
	{
		return View::make('admin.profile.changePassword');
	}
	
	public function postChangePassword()
	{
		/*
		 *  /profile/change-password sayfasında bulunan Şifre değiştirme forumundan gelen POST
		 */
        try
		{
			$posted = Input::get();
		    // Find the user using the user id
		    if (($posted['password'] =='') or ($posted['newpassword'] == '') or  ($posted['newpassword']!=$posted['newpasswordagain']) )
			{
				Session::put('status_error', array(0 => 'Şifre alanlarını kontrol ediniz.'));
				return Redirect::to('profile/change-password');
			}
			else{
					$user = Sentry::getUserProvider()->findById(Sentry::getUser()->id);
					if($user->checkPassword($posted['password']))
				    {
				        try
						{
						    $user->password = $posted['newpassword'];

						    // Update the user
						    // Şifre değiştirme başarılı ! Session'a mesaj yazıp ekrana aktarıyoruz.
						    if ($user->save())
						    {
						        Session::put('status_success', array(0 => 'Şifre değiştirme işlemi gerçekleştirildi.'));
								return Redirect::to('profile/change-password');
						    }
						    else
						    {
						        Session::put('status_error', array(0 => 'Şifre değiştirme işlemi gerçekleştirilemedi.'));
								return Redirect::to('profile/change-password');
						    }
						}
						
						catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
						{
							Session::put('status_error', array(0 => 'Kullanıcı bulunamadı.'));
							return Redirect::to('profile/change-password');
						}
				    }
				    else
				    {
				    	Session::put('status_error', array(0 => 'Şifre yanlış.'));
						return Redirect::to('profile/change-password');
				    }
				}
		    

		    
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		   	Session::put('status_error', array(0 => 'Kullanıcı bulunamadı.'));
			return Redirect::to('profile/change-password');
		}
	}
}
