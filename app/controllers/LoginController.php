<?php

class LoginController Extends BaseController
{

	public function getIndex()
    {
    	if(Sentry::check()) return Redirect::to('dashboard');
    	/*
    	if(Request::segment(1)==('admin'))
		{
			View::name('layouts.master', 'layout');
		}
		else
		{
			View::name('layouts.ecommerce', 'layout');	
		}
		$layout = View::of('layout');
		$layout->with = View::make('login');
		*/
		Session::put('user_referer', Request::header('referer'));
		return View::make('login');
    }

    public function postIndex()
    {
    	try
		{
			$posted = Input::get();
		    // Set login credentials
			$credentials = array(
				'email'    => $posted['email'],
				'password' => $posted['password'],
				);

		    // Try to authenticate the user
			$user = Sentry::authenticate($credentials, false);
			if ($user)
			{	
				if ( ! Sentry::check())
				{
				    // User is not logged in, or is not activated
				}
				else
				{
					if (isset($posted['remember']))
					{
						Sentry::loginAndRemember($user);
					}
					
					/*
						$helpers = new Helpers();
        			*/
        			//Helpers::save_log($user->id, 'login',NULL,NULL );
					
        			$userGroups = Sentry::getGroups();
					if ($userGroups[0]->name=='Admin')
					{
						$referer = 'dashboard';
					}
					else
					{
						$referer = Session::get('user_referer');
        				Session::forget('user_referer');
					}
        			return Redirect::to($referer);

				}
			}
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			
			//echo 'Login field is required.';
			Session::put('status_error', 'E-Posta alanı gereklidir.');
			return Redirect::to('login');
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
		    //echo 'Password field is required.';
			Session::put('status_error', 'Şifre alanı gereklidir.');
			return Redirect::to('login');
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
		    //echo 'Wrong password, try again.';
			Session::put('status_error', 'E-Posta veya Şifre yanlış.');
			return Redirect::to('login');
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    //echo 'User was not found.';
			Session::put('status_error', 'E-Posta veya Şifre yanlış.');
			return Redirect::to('login');
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
		    //echo 'User is not activated.';
			Session::put('status_error', 'Kullanıcı akftif değil.');
			return Redirect::to('login');
		}

		// The following is only required if throttle is enabled
		catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
		    //echo 'User is suspended.';
			Session::put('status_error', array(0 => 'Kullanıcı askıya değil.'));
			return Redirect::to('login');
		}
		catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
		    //echo 'User is banned.';
			Session::put('status_error', array(0 => 'Kullanıcı hesabı kapatılmıştır.'));
			return Redirect::to('login');
		}
    }
    /*
	############# FACEBOOK LOGIN ##############
    */
    public function getFb(){
    	$facebook = new Facebook(Config::get('facebook'));
	    $params = array(
	        'redirect_uri' => url('/login/fb-callback'),
	        'scope' => 'email',
	    );
	    return Redirect::to($facebook->getLoginUrl($params));
    }

    public function getFbCallback(){
    	$code = Input::get('code');
	    if (strlen($code) == 0) 
	    {
	    	Session::put('status_error', array(0 => 'Facebook ile iletişim kurulurken bir hata oluştu.'));
			return Redirect::to('login');
	    }
	    	
	 	$facebook = new Facebook(Config::get('facebook'));
	    $uid = $facebook->getUser();
	 
	    if ($uid == 0)
	    {
	    	Session::put('status_error', array(0 => 'Bir hata oluştu.'));
			return Redirect::to('login');
		    	
	    }
	 	
	 	$me = $facebook->api('/me');
	 
	    $userInformation = User::whereEmail($me['email'])->first();
	    if (empty($userInformation)) {
	 	
			try
			{
				$user = Sentry::getUserProvider()->create(array(
			        'email'    => $me['email'],
			        'password' => Str::random(8),
			        'activated' => 1,
			        'first_name' => $me['first_name'],
			        'last_name' => $me['last_name'],
			        'facebook_id' => $uid,
			   	 	));
						   // Find the group using the group id
				    $adminGroup = Sentry::getGroupProvider()->findByName('Customer');
					
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

	        //$user->photo = 'https://graph.facebook.com/'.$me['username'].'/picture?type=large';
	 
	    }
	    else
	    {
	    	if($userInformation->facebook_id != $uid)
	    	{
	    		$userInformation->facebook_id = $uid;
	    		$userInformation->save();	
	    	}
	    }
	 
	    //$profile->access_token = $facebook->getAccessToken();
	    
	 	
	 	$user = Sentry::findUserByLogin($me['email']);
	 	Sentry::login($user, false);
	    
	    Session::put('status_success', array(0 => 'Facebook ile giriş yapıldı.'));
		return Redirect::to(Request::root());
    }
    /*
	############# END FACEBOOK LOGIN ##############
    */

    /*
    ###############################################
	############# TWITTER LOGIN ###################
	###############################################
    */

    public function getTwNewUser()
    {
    	if(Sentry::check()) return Redirect::to(Request::root());
    	
    	$cities = array(0 => 'Seçiniz') + City::OrderBy('name')->lists('name','id');
			
		$towns = array();
		array_unshift($towns, 'Seçiniz');	
		

		$twitterUserInformation = array();
			//require_once('config.php');

			/* If access tokens are not available redirect to connect page. */
			
			if (!Session::has('access_token') || !Session::has('access_token.oauth_token') || !Session::has('access_token.oauth_token_secret'))
			{
			    
			    //return Redirect::to('twitter/clear-sessions');
			    //header('Location: ./clearsessions.php');
			}
			else
			{
				require_once(app_path().'/plugins/twitteroauth/twitteroauth.php');

				/* Get user access tokens out of the session. */
				$access_token = Session::get('access_token');

				/* Create a TwitterOauth object with consumer/user tokens. */
				$connection = new TwitterOAuth(Config::get('twitter.CONSUMER_KEY'), Config::get('twitter.CONSUMER_SECRET'), $access_token['oauth_token'], $access_token['oauth_token_secret']);

				/* If method is set change API call made. Test is called by default. */
				$content = $connection->get('account/verify_credentials');

				$first_name = '';
		        for ($k=0; $k < count($replace)-1; $k++) { 
		          $first_name.=$replace[$k].' ';
		        }
		        $twitterUserInformation['first_name'] = trim($first_name);
		        $twitterUserInformation['last_name'] = '';
		        if(isset($replace[count($replace)-1]))
		        {
		        	$twitterUserInformation['last_name'] = 	$replace[count($replace)-1];
		        }
		        $twitterUserInformation['content'] = $content;
		        $twitterUserInformation['twitter_id'] = $content->id;
		        
			}
			
			/* Some example calls */
			//$connection->get('users/show', array('screen_name' => 'abraham'));
			//$connection->post('statuses/update', array('status' => date(DATE_RFC822)));
			//$connection->post('statuses/destroy', array('id' => 5437877770));
			//$connection->post('friendships/create', array('id' => 9436992));
			//$connection->post('friendships/destroy', array('id' => 9436992));

			/* Include HTML to display on the page */

		$data = array('first_name' , $twitterUserInformation['first_name'] , 'last_name' => $twitterUserInformation['last_name'] , 'twitterUserContent' => $twitterUserInformation['content'] , 'twitter_account_id' => $twitterUserInformation['twitter_id']);
		return View::make('newCustomer',$data)
			->with('cities', $cities)
			->with('towns', $towns)
			->with('twitterUserInformation' , $twitterUserInformation);
    }

    public function getTw()
	{
		require_once(app_path().'/plugins/twitteroauth/twitteroauth.php');
		/* Build TwitterOAuth object with client credentials. */
		$connection = new TwitterOAuth(Config::get('twitter.CONSUMER_KEY'), Config::get('twitter.CONSUMER_SECRET'));
		 
		/* Get temporary credentials. */
		$request_token = $connection->getRequestToken(Config::get('twitter.OAUTH_CALLBACK'));

		/* Save temporary credentials to session. */
		$token = $request_token['oauth_token'];
		Session::put('oauth_token',$request_token['oauth_token']);
		Session::put('oauth_token_secret', $request_token['oauth_token_secret']);
		 
		/* If last connection failed don't display authorization link. */

		switch ($connection->http_code) {
		  case 200:
		    /* Build authorize URL and redirect user to Twitter. */
		    $url = $connection->getAuthorizeURL($token);
		    return Redirect::to($url);
		    //header('Location: ' . $url); 
		    break;
		  default:
		    /* Show notification if something went wrong. */
		    return 'Could not connect to Twitter. Refresh the page or try again later.';
		}

	}
	public function getTwClearSessions()
	{
		Session::flush();
		return Redirect::to('login');
		//return '<a href="'.URL::to('login/tw-redirect').'">Giriş yap</a>';
	}
	public function getTwCallback()
	{
		//session_start();
		include(app_path().'/plugins/twitteroauth/twitteroauth.php');
		

		/* If the oauth_token is old redirect to the connect page. */
		if (isset($_REQUEST['oauth_token']) && Session::get('oauth_token') !== $_REQUEST['oauth_token']) {
			Session::put('oauth_status', 'oldtoken');
		  	
		  	return Redirect::to('login/tw-clear-sessions');
		  	//header('Location: ./clearsessions.php');
		}

		/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
		$connection = new TwitterOAuth(Config::get('twitter.CONSUMER_KEY'), Config::get('twitter.CONSUMER_SECRET'), Session::get('oauth_token'), Session::get('oauth_token'));

		/* Request access tokens from twitter */
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

		/* Save the access tokens. Normally these would be saved in a database for future use. */
		Session::put('access_token',$access_token);
		//Session::get('access_token') = $access_token;

		/* Remove no longer needed request tokens */
		Session::forget('oauth_token');
		Session::forget('oauth_token_secret');
		//unset($_SESSION['oauth_token']);
		//unset($_SESSION['oauth_token_secret']);

		/* If HTTP response is 200 continue otherwise send to connect page to retry */
		if (200 == $connection->http_code) {
		  /* The user has been verified and the access tokens can be saved for future use */
		  Session::put('status' , 'verified');
		  //$_SESSION['status'] = 'verified';

		  return Redirect::to('login/tw-new-user');
		  //header('Location: ./index.php');
		} else {
		  /* Save HTTP status for error dialog on connnect page.*/
		  return Redirect::to('login/tw-clear-sessions');
		  //header('Location: ./clearsessions.php');
		}

	}

    /*
    ###############################################
	############# END TWITTER LOGIN ###############
	###############################################
    */


    /*
    ###############################################
	############# GOOGLE PLUS LOGIN ###############
	###############################################
    */
    public function getGp()
    {
    	
    	require_once app_path().'/plugins/googleplus/Google_Client.php'; // include the required calss files for google login
		require_once app_path().'/plugins/googleplus/contrib/Google_PlusService.php';
		require_once app_path().'/plugins/googleplus/contrib/Google_Oauth2Service.php';
		
		//Session::flush();

		$client = new Google_Client();
		$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/plus.me')); // set scope during user login
		$plus 		= new Google_PlusService($client);
		$oauth2 	= new Google_Oauth2Service($client); // Call the OAuth2 class for get email address

		
		if(Input::get('code')) 
		{
			$client->authenticate(); // Authenticate
			Session::put('access_token',$client->getAccessToken()); // get the access token here
			//$_SESSION['access_token'] = $client->getAccessToken(); // get the access token here
			//header ($_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
			//header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
			
			return Redirect::to('login/gp');
			//header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
		}

		if(Session::has('access_token')) {
			$client->setAccessToken(Session::get('access_token'));
		}

		if ($client->getAccessToken()) {
		  $user 		= $oauth2->userinfo->get();
		  $me 			= $plus->people->get('me');
		  $optParams 	= array('maxResults' => 100);
		  
		  // The access token may have been updated lazily.
		  //$_SESSION['access_token'] 		= $client->getAccessToken();
		  Session::put('access_token',$client->getAccessToken());
		  $email 							= filter_var($user['email'], FILTER_SANITIZE_EMAIL); // get the USER EMAIL ADDRESS using OAuth2
		} else {
			$authUrl = $client->createAuthUrl();
		}

		if(isset($me)){ 
			Session::put('gplusuer',$me);
			//$_SESSION['gplusuer'] = $me; // start the session
		}
		if(isset($authUrl)) {
			return Redirect::to($authUrl);
		}
		if(Session::has('gplusuer'))
		{
			$userInformation = User::whereEmail($email)->first();
		    if (empty($userInformation)) {
		 	
				try
				{
					$createUser = Sentry::getUserProvider()->create(array(
				        'email'    => $email,
				        'password' => Str::random(8),
				        'activated' => 1,
				        'first_name' => $me['name']['givenName'],
				        'last_name' => $me['name']['familyName'],
				        'gplus_id' => $me['id'],
				   	 	));
							   // Find the group using the group id
					    $customerGroup = Sentry::getGroupProvider()->findByName('Customer');
						
						// Assign the group to the user
					    $createUser->addGroup($customerGroup);
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

		        //$user->photo = 'https://graph.facebook.com/'.$me['username'].'/picture?type=large';
		 	}
		 	else
		 	{
		 		if($userInformation->gplus_id != $me['id'])
		 		{
		 			$userInformation->gplus_id = $me['id'];
		 			$userInformation->save();	
		 		}
		 	}

		 	Session::flush();
		 	$loginUser = Sentry::findUserByLogin($email);
		 	Sentry::login($loginUser, false);
		    
		    Session::put('status_success', array(0 => 'Google Plus ile giriş yapıldı.'));
			return Redirect::to(Request::root());

		}
		
	}
    /*
    ###############################################
	############# END GOOGLE PLUS LOGIN ###########
	###############################################
    */
}