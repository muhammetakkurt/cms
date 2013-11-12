<?php

class AdminCmsPageController extends \BaseController {

	public function __construct()
    {
    	/*
		 *  Filter.php 'deki cmsPages filtresini çalıştır. 
		 *  Kullacının cmsPages izini yoksa giriş vermez.
		 */
        $this->beforeFilter('cmsPages');
	
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$pages = CmsPage::orderBy('sort_order')->paginate(20);
		$data = array('pages' => $pages);
		return View::make('admin.cms.pages.pages',$data);
	}

	/*
	*	View Sayfasındaki arama alanının çalıştığı function().
	*/
	public function search()
	{
		
		$search = Input::get('q');
		if($search!='')
		{
			$pages = CmsPage::where('name', 'like', '%'.$search.'%')->paginate(20);	
		}
		else
		{
			return Redirect::to('cms-pages');
		}
		
		$data = array('pages' => $pages);
		return View::make('admin.cms.pages.pages',$data);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$pages = CmsPage::all();
		$pagesSelect = array('0' => '/');
		foreach ($pages as $page) {
			$pagesSelect[$page->id] = $page->name;
		}
		$data = array('pages' => $pagesSelect );
		return View::make('admin.cms.pages.create' , $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$inputs = Input::all();
		$page = new CmsPage;
		$validation = $page->validate($inputs);
		if($validation->fails())
		{
			Helpers::validationErrorsYield2Sessions($validation->messages());
			return Redirect::back();
		}
		$page->name = $inputs['name'];
		$page->parent_id = $inputs['parent_id'];
		if($inputs['sort_order']!='')
		{
			$page->sort_order = $inputs['sort_order'];	
		}
		else
		{
			$page->sort_order = 1;
		}
		$page->published_on = $inputs['published_on'];
		$page->published_off = $inputs['published_off'];
		if($page->published_off == "")
		{
			$page->published_off = null;
		}
		if ($page->save())
		{
			/*
			if (isset($inputs['article']))
			{
				foreach ($inputs['article'] as $article) 
				{
					$articleSortOrder = array();
					if (isset($inputs['article'][$article['id']]['sort_order']))
					{
						$articleSortOrder = array('sort_order' => $inputs['article'][$article['id']]['sort_order']);	
					}
					else
					{
						$articleSortOrder = array('sort_order' => 1);
					}

					$page->articles()->attach($article['id'] , $articleSortOrder);
				}	
			}
			*/

			if(isset($inputs['medias']))
			{
				$mediaInputs =  $inputs['medias'];
				foreach ($mediaInputs as $mediaInput) 
				{

					$cmsMedia = CmsMedia::where('path' , '=' , $mediaInput['path'])->first();
					if($cmsMedia)
					{
						if($mediaInput['sort_order']=='')
						{
							$mediaInput['sort_order'] = 0;
						}
						$page->medias()->attach($cmsMedia->id, array('sort_order' => $mediaInput['sort_order']));
					}
					else
					{	
						$newMedia = new CmsMedia;
						$validation = $newMedia->validate($mediaInput);
						if(!$validation->fails())
						{
							$newMedia->path = $mediaInput['path'];
							$newMedia->name = $mediaInput['name'];
							$newMedia->sort_order = $mediaInput['sort_order'];
							$newMedia->save();
						}
						else
						{
							Helpers::validationErrorsYield2Sessions($validation->messages());
							return Redirect::back();
						}
						$page->medias()->attach($newMedia->id, array('sort_order' => $newMedia->sort_order));
					}
				}
			}
			
			Session::put('status_success', array(0 => 'Sayfa başarı ile eklendi.'));
			return Redirect::to('cms-pages');
		}
		else
		{
			Session::put('status_error', array(0 => 'Sayfa eklenirken bir hata oluştu. İşlem gerçekleştirilemedi.'));
			return Redirect::back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return Redirect::to('cms-pages');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$pages = CmsPage::all();
		$pagesSelect = array('0' => '/');
		foreach ($pages as $page) {
			$pagesSelect[$page->id] = $page->name;
		}
		$page = CmsPage::find($id);
		$data = array('pages' => $pagesSelect , 'page' => $page);
		return View::make('admin.cms.pages.edit' , $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$inputs = Input::all();
		$page = CmsPage::find($id);
		$validation = $page->validate($inputs);
		if($validation->fails())
		{
			Helpers::validationErrorsYield2Sessions($validation->messages());
			return Redirect::back();
		}
		$page->name = $inputs['name'];
		$page->parent_id = $inputs['parent_id'];
		if($inputs['sort_order']!='')
		{
			$page->sort_order = $inputs['sort_order'];	
		}
		else
		{
			$page->sort_order = 1;
		}
		$page->published_on = $inputs['published_on'];
		$page->published_off = $inputs['published_off'];
		if($page->published_off == "")
		{
			$page->published_off = null;
		}
		if ($page->save())
		{
			/*
			if (isset($inputs['article']))
			{
				$pageArticlesArray = array();
				$existingArticles  = array();
				foreach ($inputs['article'] as $article) 
				{
					$pageArticlesArray [] = $article['id'];
				}	
				foreach ($page->articles as $article) 
				{
					if(!in_array($article->id, $pageArticlesArray))
					{
						$page->articles()->detach($article->id);
					}
					else
					{
						$existingArticles[] = $article->id;
					}

				}
				foreach ($pageArticlesArray as $article)
				{
					if(!in_array($article, $existingArticles))
					{	
						if ($article>0)
						{	
							$articleSortOrder = array();
							if (isset($inputs['article'][$article]['sort_order']))
							{
								$articleSortOrder = array('sort_order' => $inputs['article'][$article]['sort_order']);	
							}
							else
							{
								$articleSortOrder = array('sort_order' => 1);
							}

							$page->articles()->attach($article , $articleSortOrder);
						}
					}
					else
					{
						if ($article>0)
						{	
							$articleSortOrder = array();
							if (isset($inputs['article'][$article]['sort_order']))
							{
								$articleSortOrder = array('sort_order' => $inputs['article'][$article]['sort_order']);	
							}
							else
							{
								$articleSortOrder = array('sort_order' => 1);
							}
							$page->articles()->detach($article);
							$page->articles()->attach($article , $articleSortOrder);
						}
					}
				}
			}
			else
			{
				foreach ($page->articles as $article) 
				{
					$page->articles()->detach($article->id);
				}
			}
			*/

			if (isset($inputs['medias']))
			{	

				// Seçilen resim varmı?
				if ($inputs['medias']!='')
				{
					foreach ($page->medias as $media) 
					{
						$media->pages()->detach($page->id);
					}

					$mediaInputs =  $inputs['medias'];
					foreach ($mediaInputs as $mediaInput) 
					{

						$cmsMedia = CmsMedia::where('path' , '=' , $mediaInput['path'])->first();
						if($cmsMedia)
						{
							if($mediaInput['sort_order']=='')
							{
								$mediaInput['sort_order'] = 0;
							}
							$page->medias()->attach($cmsMedia->id, array('sort_order' => $mediaInput['sort_order']));
						}
						else
						{	
							$newMedia = new CmsMedia;
							$validation = $newMedia->validate($mediaInput);
							if(!$validation->fails())
							{
								$newMedia->path = $mediaInput['path'];
								$newMedia->name = $mediaInput['name'];
								$newMedia->sort_order = $mediaInput['sort_order'];
								$newMedia->save();
							}
							else
							{
								Helpers::validationErrorsYield2Sessions($validation->messages());
								return Redirect::back();
							}
							$page->medias()->attach($newMedia->id, array('sort_order' => $newMedia->sort_order));
						}
					}

				}
				else 
				{
					foreach ($page->medias as $media) 
					{
						$media->pages()->detach($page->id);
					}
				}
			}
			else 
			{
				foreach ($page->medias as $media) 
				{
					$media->pages()->detach($page->id);
				}
			}


			Session::put('status_success', array(0 => 'Sayfa başarı ile güncellendi.'));
			return Redirect::to('cms-pages');
		}
		else
		{
			Session::put('status_error', array(0 => 'Sayfa güncellenirken bir hata oluştu. İşlem gerçekleştirilemedi.'));
			return Redirect::back();
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
		if($id != 1 and $id != 2 and $id != 3 and $id != 4 and $id != 5)
		{
			$page = CmsPage::find($id);
			$page->delete();
			return Redirect::back();	
		}
		else
		{
			Session::put('status_error', array(0 => 'Bu sayfaları silemezsiniz.'));
			return Redirect::back();
		}
		
	}

	/**
	 *  View'da check edilenleri silen fonksiyon
	 *  Post olarak gelen değişkeni siler
	 */
	public function deleteSelected()
	{
		$selects = Input::get('selected');
		if (isset($selects))
		{
			foreach ($selects as $selectedItem) {
				$this->destroy($selectedItem);
			}
		}
		return Redirect::back();
	}

}