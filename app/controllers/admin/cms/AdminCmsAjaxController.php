<?php 
	/**
	*  Ajax için gerekli CMS sorguları
	*/
	class AdminCmsAjaxController extends BaseController
	{
		
		public function getCmsArticlesSearch()
		{
			$articles = CmsArticle::where('title', 'like', '%'.Input::get('query').'%')->get();
			$articlesSelect = array();
			$i=0;
			foreach ($articles as $article) {
				$articlesSelect[$i]['id'] = $article->id;
				$articlesSelect[$i]['name'] = $article->title;
			$i++;
			}
			return json_encode($articlesSelect, JSON_UNESCAPED_UNICODE);
		}

		public function getCmsPagesSearch()
		{
			$pages = CmsPage::where('name', 'like', '%'.Input::get('query').'%')->get();
			$pagesSelect = array();
			$i=0;
			foreach ($pages as $page) {
				$pagesSelect[$i]['id'] = $page->id;
				$pagesSelect[$i]['name'] = $page->name;
			$i++;
			}
			return json_encode($pagesSelect, JSON_UNESCAPED_UNICODE);
		}

		public function getArticles()
		{
			$articles = CmsArticle::where('title', 'like', '%'.Input::get('query').'%')->get();
			$articlesSelect = array();
			$i = 1;
			foreach ($articles as $article) {
				$articlesSelect[$i]['id'] = $article->id;
				$articlesSelect[$i]['title'] = $article->title;
			}
			return json_encode($articlesSelect, JSON_UNESCAPED_UNICODE);
		}
		public function getArticleSearch()
		{
			$articles = CmsArticle::where('title', 'like', '%'.Input::get('query').'%')->get();
			$articlesSelect = array();
			$i=0;
			foreach ($articles as $article) {
				$articlesSelect[$i]['id'] = $article->id;
				$articlesSelect[$i]['title'] = $article->title;
			$i++;
			}
			return json_encode($articlesSelect, JSON_UNESCAPED_UNICODE);
		}

		public function getArticleById()
		{
			$articleObj = CmsArticle::find(Input::get('query'));
			$article = array();
			$article['id'] = $articleObj->id;
			$article['title'] = $articleObj->title;
			return json_encode($article, JSON_UNESCAPED_UNICODE);
		}

		public function postCmsArticles()
		{
			$inputs = Input::all();

			if(isset($inputs['filter_name']))
			{
				$cmsArticles = CmsArticle::where('title', 'like', '%'.$inputs['filter_name'].'%')->get();
				$cmsArticlesSelect = array();
				$i=0;
				foreach ($cmsArticles as $cmsArticle) {
					$cmsArticlesSelect[$i]['id'] = $cmsArticle->id;
					$cmsArticlesSelect[$i]['name'] = $cmsArticle->title;
				$i++;
				}
				return json_encode($cmsArticlesSelect, JSON_UNESCAPED_UNICODE);	
			}
		}
	}