<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('cms.pageDetail')->with('pages', CmsPage::where('published_off', '>', date('Y-m-d H:i:s'))->get());
});

Route::get('about-us', function(){
	return View::make('cms.articleDetail')
		->with('article', CmsArticle::find(2));
});
Route::get('corparate', function(){
	return View::make('cms.articleDetail')
		->with('article', CmsArticle::find(3));
});

Route::get('faq', function(){
	return View::make('cms.faq')
		->with('page', CmsPage::find(6));
});

Route::get('privacy-policy', function(){
	return View::make('cms.articleDetail')
		->with('article', CmsArticle::find(4));
});

Route::get('user-agreement', function(){
	return View::make('cms.articleDetail')
		->with('article', CmsArticle::find(5));
});

Route::get('news-press/{id}', function($id){

	$article = CmsArticle::findOrFail($id);
	return View::make('cms.articleDetail')
		->with('article' , $article);
});

/* Cms Special Routes */
Route::get('contact', function(){
	return View::make('cms.articleDetail')
		->with('article', CmsArticle::find(1));
});

Route::get('news-press', function(){
	$articles = DB::table('cms_articles')
                     ->select('cms_articles.*', 'cms_medias.path')
                     ->join('cms_pages_has_articles', 'cms_articles.id', '=', 'cms_pages_has_articles.cms_article_id')
                     ->leftJoin('cms_medias', 'cms_medias.article_id', '=', 'cms_articles.id')
                     ->whereIn('cms_pages_has_articles.cms_page_id', function($query){
                         $query->select('id')
                               ->from('cms_pages')
                               ->where('cms_pages.parent_id', 2)
                               ->orWhere('cms_pages.id', 2);
                     })
                     ->where('published_on', '<=', date('Y-m-d H:i:s'))
                     ->where(function($query){
                         $query->where('published_off', '>', date('Y-m-d H:i:s'))
                         ->orWhere('published_off', null)
                         ->orWhere('published_off', "0000-00-00 00:00:00");
                     })
                     ->orderBy('published_on')
                     ->paginate(10);
	return View::make(Theme::where('status' , '=' , '1')->first()->name.'.cms.news-press')
		->with('articles' , $articles);
});

Route::get('logout', function()
{	
	/*
	$helpers = new Helpers();
	$helpers->save_log(Sentry::getUser()->id, 'logout' , NULL , NULL , NULL );
	*/
	/*if(Sentry::check())
	{
		Helpers::save_log(Sentry::getUser()->id, 'logout',NULL,NULL );					
	}
	*/
	Sentry::logout();

	return Redirect::to('login');
});


Route::controller('newuser' , 'UserSettingsController');

Route::controller('login', 'LoginController');

if (Sentry::check()) {

	
	Route::controller('dashboard' , 'AdminDashboardController');
	// Profil
	Route::controller('profile', 'AdminProfileController');

	Route::controller('ajaxcms' , 'AdminCmsAjaxController');
	//CMS (İçerik Yönetim Sistemi)
	Route::post('cms-pages/delete-selected', 'AdminCmsPageController@deleteSelected');
	Route::resource('cms-pages', 'AdminCmsPageController');	

	//CMS (İçerik Yönetim Sistemi)
	Route::post('cms-articles/delete-selected', 'AdminCmsArticleController@deleteSelected');
	Route::resource('cms-articles', 'AdminCmsArticleController');	

	//CMS (İçerik Yönetim Sistemi)
	Route::post('cms-article-comments/delete-selected', 'AdminCmsArticleCommentController@deleteSelected');
	Route::resource('cms-article-comments', 'AdminCmsArticleCommentController');

	//Dosya Yöneticisi
	Route::controller('file-manager', 'AdminFileManagerController');

	Route::controller('ajaxusers' , 'AdminUsersAjaxController');
	//	Kullanıcı Grupları
	Route::resource('users-groups', 'AdminUserGroupsController');

	//	Kullanıcılar
	Route::get('users/search','AdminUsersController@search');
	Route::resource('users', 'AdminUsersController');
}