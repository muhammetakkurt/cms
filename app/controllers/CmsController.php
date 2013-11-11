<?php
	/**
	*	@author Erdem KEREN
	*	@uses   Cms
	*	@todo   
	*
	*	This controller manages the CMS requests
	*	and responses using Cms Workbench
	*/
	class CmsController extends BaseController
	{
		// Returns the view with a page list 
		// and the page requested by the active user

		public function getIndex()
		{
			$newestArticle = array();
			$articles = DB::table('cms_articles')
						                     ->select('cms_articles.*', 'cms_medias.path')
						                     ->join('cms_pages_has_articles', 'cms_articles.id', '=', 'cms_pages_has_articles.cms_article_id')
						                     ->leftJoin('cms_medias', 'cms_medias.article_id', '=', 'cms_articles.id')
						                     ->whereIn('cms_pages_has_articles.cms_page_id', function($query){
						                         $query->select('id')
						                               ->from('cms_pages')
						                               ->where('cms_pages.parent_id', 1)
						                               ->orWhere('cms_pages.id', 1);
						                     })
						                     ->where('published_on', '<=', date('Y-m-d H:i:s'))
						                     ->where(function($query){
						                         $query->where('published_off', '>', date('Y-m-d H:i:s'))
						                         ->orWhere('published_off', null)
						                         ->orWhere('published_off', "0000-00-00 00:00:00");
						                     })
						                     ->orderBy('published_on')
						                     ->paginate(12);
			if(count($articles)>0)
				if($articles->getCurrentPage() == 1)
				{			
					foreach($articles as $article)
					{
						$newestArticle = $article;
						break;
					}
				}
				else
				{
					$newestArticleResult = DB::table('cms_articles')
							                     ->select('cms_articles.*')
							                     ->join('cms_pages_has_articles', 'cms_articles.id', '=', 'cms_pages_has_articles.cms_article_id')
							                     ->whereIn('cms_pages_has_articles.cms_page_id', function($query){
							                         $query->select('id')
							                               ->from('cms_pages')
							                               ->where('cms_pages.parent_id', 1)
							                               ->orWhere('cms_pages.id', 1);
							                     })
							                     ->where('published_on', '<=', date('Y-m-d H:i:s'))
							                     ->where(function($query){
							                         $query->where('published_off', '>', date('Y-m-d H:i:s'))
							                         ->orWhere('published_off', null)
							                         ->orWhere('published_off', "0000-00-00 00:00:00");
							                     })
							                     ->orderBy('published_on')
							                     ->take(1)
							                     ->get();
					$newestArticle = $newestArticleResult[0];
				}
			return View::make(admin..'.cms.category')
						->with('pages', CmsPage::where('parent_id', 1)
											   ->where('published_on', '<=' , date('Y-m-d H:i:s'))
											   ->where(function($query)
											   {
											   		$query->where('published_off', '>' , date('Y-m-d H:i:s'))
											   		->orWhere('published_off', null);
											   })
											   ->lists('name', 'id')
								)
						->with('articles', $articles)
						->with('newestArticle', $newestArticle);
		}

		public function getCategory($categoryId)
		{
			$articles = CmsPage::findOrFail($categoryId)->articles()->paginate(12);
			$newestArticle = CmsPage::find($categoryId)->articles()->first();
			return View::make('admin.cms.category')
				->with('pages', CmsPage::where('parent_id', 1)
									   ->where('published_on', '<=' , date('Y-m-d H:i:s'))
									   ->where(function($query)
									   {
									   		$query->where('published_off', '>' , date('Y-m-d H:i:s'))
									   		->orWhere('published_off', null);
									   })
									   ->lists('name', 'id')
						)
				->with('articles', $articles)
				->with('newestArticle', $newestArticle)
				->with('news', CmsPage::find(2)->articles->take(7));
		}
		public function getContent($contentId)
		{
			return View::make('admin.cms.pageDetail')
							->with('pages', CmsPage::where('parent_id', 1)
												   ->where('published_on', '<=' , date('Y-m-d H:i:s'))
												   ->where(function($query)
												   {
												   		$query->where('published_off', '>' , date('Y-m-d H:i:s'))
												   		->orWhere('published_off', null);
												   })
												   ->lists('name', 'id')
							)
							->with('article', CmsArticle::findOrFail($contentId))
							->with('newsList', CmsPage::findOrFail(2)->articles->take(7));;
		}
		// Returns the view with an article list
		// and the article requested by the active user
		public function getArticle($articleId)
		{
			return View::make('admin.cms.articleDetail')
				->with('article', CmsArticle::find($articleId))
				->with('articles', CmsArticle::all());
		}

		// If the user is a member, let him leave some comments
		// for admins to approve.
		public function postComment($articleId)
		{
			if(Sentry::check())
			{
				$article = CmsArticle::find($articleId);
				if(!is_null($article))
				{
					$inputs = array(
						'article_id'=> $articleId,
						'author_id' => Sentry::getUser()->id,
						'status'	=> 0,
					) + Input::all();
					$comment = new CmsArticleComment();
					$validation = $comment->validate($inputs);
					if($validation->fails())
					{
						Helpers::validationErrorsYield2Sessions($validation->messages());
						return Redirect::back();
					}
					$comment->article_id = $inputs['article_id'];
					$comment->author_id = $inputs['author_id'];
					$comment->status = $inputs['status'];
					$comment->comment = $inputs['comment'];
					$comment->save();
					Helpers::save_log(Sentry::getUser()->id, 'article_comment' , NULL , $articleId);
					Session::put('status_success', array(0 => 'Yorumunuz eklendi. Yöneticiler tarafından onaylandıktan sonra yayına alınacak.'));
					return Redirect::back();
				}
				else
				{
					Session::put('status_error', array(0 => 'Yorum eklemek istediğiniz makale kayıtlarımızda bulunamadı.'));
					return Redirect::back();
				}
			}
			else
			{
				Session::put('status_error', array(0 => 'Lütfen yorum yapmak için kullanıcı girişi yapınız.'));
				return Redirect::back();
			}
		}
	}














/** End of CmsController.php **/