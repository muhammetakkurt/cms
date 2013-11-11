<?php

class UserSettingsController Extends BaseController
{

	public function getIndex()
    {
    	if(Sentry::check()) return Redirect::to(Request::root());
    	return View::make('newCustomer');
  	}

    public function postIndex()
    {
    	try
		{
			$inputs = Input::all();
		    // Create the user
		    $user = Sentry::createUser(array(
		        'email'    => $inputs['email'],
		        'password' => $inputs['password'],
		        'first_name' => $inputs['first_name'],
		        'last_name' => $inputs['last_name'],
		        'activated'=> true,
		        'twitter_id' => $inputs['twitter_id'],
		    ));
		    /*
			*	Kayıt oldu
		    */
		    //Helpers::save_log($user->id, 'singup' , NULL , NULL);
		 	$customerGroup = Sentry::findGroupByName('Customer');
		    // Assign the group to the user
		    $user->addGroup($customerGroup);

		    $result = $this->smallLogin($inputs['email'], $inputs['password']);

		    $order_referer = Session::get('order_referer');
		    if ($order_referer==1)
		    {
		    	return Redirect::to('order');	
		    }
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			Session::put('status_error', array(0 => 'E-posta alanı gereklidir.'));
			return Redirect::back();
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			Session::put('status_error', array(0 => 'Şifre alanı gereklidir.'));
			return Redirect::back();
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
			$result = $this->smallLogin($inputs['email'], $inputs['password']);
			if($result) {
				Session::put('status_success', array(0 => 'Daha önce zaten kayıt olmuştunuz. Aktif üyeliğinizle oturumunuz açıldı.'));
			} else {
			    Session::put('status_error', array(0 => 'Bu e-posta adresi ile kayıtlı bir üyemiz zaten var.'));
			}
			return Redirect::back();
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		   	Session::put('status_error', array(0 => 'Grup bulunamadı.'));
			return Redirect::back();
		}

		Session::put('status_success', array(0 => '<b>Kaydınız başarıyla tamamlandı!</b><br /><p>Oturum açmanıza yalnızca bir adım kaldı. E-posta adresinize gönderdiğimiz aktivasyon bağlantısını ziyaret ettikten sonra oturum açabilir, üye olmanın avantajlarından yararlanmaya hemen başlayabilirsiniz!</p>'));
		return Redirect::to(Request::root());
    }

    public function getActivated($activation_code)
    {
    	try
		{
		    $user = Sentry::getUserProvider()->findByActivationCode($activation_code);
			$user->activated = 1;


		    // Update the user
		    if ($user->save())
		    {	
		    	
		    	// Kayıt oldu - Kendini active etti.
		    	/*
		    	$helpers = new Helpers();
		    	*/
				//Helpers::save_log($user->id, 'activate_profile' , NULL , NULL);
				
		    	
		    	Session::put('status_success', array(0 => 'Aktivasyon başarıyla gerçekleşti şimdi giriş yapabilirsiniz.'));
				return Redirect::to('login');
		    
		    }
		    else
		    {
		    	
		    }
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			Session::put('status_error', array(0 => 'Kullanıcı bulunamadı.'));
			return Redirect::to('login');
		}
    }

    public function postResetPassword()
    {
    	try
		{
			$post = Input::get();
		   	$user = Sentry::getUserProvider()->findByLogin($post['email_reset']);
			
			$resetCode = $user->getResetPasswordCode();

			$data = array('resetCode' => $resetCode);
			Mail::send('emails.auth.reminder', $data, function($message) use ($user)
			{
			    $message->to($user->email, $user->first_name.' '.$user->last_name)->subject('Yeni Şifre Talebi!');
			});
			
			/*
			*	Şifresini Unuttu loglandı.
			*/
			/*
			$helpers = new Helpers();
			*/
			//Helpers::save_log($user->id, 'lost_password' , NULL , NULL);
			

			Session::put('status_success', array(0 => 'Girdiğiniz mail adresinize şifre tanımlama bağlantısı gönderildi.'));
			return Redirect::to('login');
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			Session::put('status_error', array(0 => 'Kullanıcı bulunamadı.'));
			return Redirect::to('login');
		}
    }

    public function getNewPassword($reset_password_code)
    {
		try
		{
		   $user = Sentry::getUserProvider()->findByResetPasswordCode($reset_password_code);
			$full_name = $user->first_name.' '.$user->last_name;
			$data = array('full_name' => $full_name );
			return View::make('admin.newpassword',$data);
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			Session::put('status_error', array(0 => 'Kullanıcı bulunamadı.'));
			return Redirect::to('login');
		}
    }

    public function postNewPassword($reset_password_code)
    {
		try
		{
			$inputs = Input::all();
		    $user = Sentry::getUserProvider()->findByResetPasswordCode(Request::segment(3));
			if (($inputs['password']!='') && ($inputs['password']==$inputs['passwordr']))
			{
				$user->password=$inputs['password'];
				if($user->save())
				{
					/*
					*	Parola sıfırlandı ve kayır edildi.
					*/
					/*
					$helpers = new Helpers();
					$helpers->save_log($user->id, 'lost_password' , NULL , NULL , NULL );
					*/
					//Helpers::save_log($user->id, 'reset_password' , NULL , NULL);
					
					Session::put('status_error', array(0 => 'Şifreniz başarıyla değiştirildi giriş yapabilirsiniz.'));
					return Redirect::to('login');
				}
				else
				{
					Session::put('status_error', array(0 => 'Şifreniz değiştirilirken bir hata oluştu. Tekrar deneyiniz.'));
					return Redirect::to('login');
				}
			}
			else
			{
				Session::put('status_error', array(0 => 'Girdiğiniz şifreler birbirleri ile uyuşmamaktadır.'));
				return Redirect::back();
			}

		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			Session::put('status_error', array(0 => 'Kullanıcı bulunamadı.'));
			return Redirect::to('login');
		}
    }
    /**
     *	@name   Small Login
     *	@param  String $userMail, String $userPassword
     *	@return Bool
     */
    protected function smallLogin($userMail, $userPassword)
    {
    	$credentials = array(
    		'email'		=>	$userMail,
    		'password'	=>	$userPassword
    	);
    	try {
    		$user = Sentry::authenticate($credentials, false);
    	} catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
    	    return false;
    	} catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
    	    return false;
    	} catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
    		return false;
    	} catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
    		return false;
    	} catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
    		return false;
    	}
    	return true;
    }
}