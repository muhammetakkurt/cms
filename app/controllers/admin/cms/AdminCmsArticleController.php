<?php

class AdminCmsArticleController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$cmsArticles = CmsArticle::paginate(20);
		$data = array('articles' =>$cmsArticles);
		return View::make('admin.cms.articles.articles',$data);
	}

	/*
	*	View Sayfasındaki arama alanının çalıştığı function().
	*/
	public function search()
	{
		
		$search = Input::get('q');
		if($search!='')
		{
			$cmsArticles = CmsArticle::where('title', 'like', '%'.$search.'%')->paginate(20);	
		}
		else
		{
			return Redirect::to('cms-articles');
		}
		
		$data = array('articles' =>$cmsArticles);
		return View::make('admin.cms.articles.articles',$data);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.cms.articles.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$inputs = Input::all();
		$article = new CmsArticle;
		$validation = $article->validate($inputs);
		if(!$validation->fails())
		{
			$article->title = $inputs['title'];
			$article->summary = $inputs['summary'];
			$article->content = $inputs['content'];
			$article->published_on = $inputs['published_on'];
			$article->published_off = $inputs['published_off'];
			if($article->published_off == "")
			{
				$article->published_off = null;
			}

			if ($article->save())
			{
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
							$article->medias()->attach($cmsMedia->id, array('sort_order' => $mediaInput['sort_order']));
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
							$article->medias()->attach($newMedia->id, array('sort_order' => $newMedia->sort_order));
						}
					}
				}
				Session::put('status_success', array(0 => 'Makale başarı ile eklendi.'));
				return Redirect::to('cms-articles');
			}
			else
			{
				Session::put('status_error', array(0 => 'Makale eklenirken bir hata oluştu. İşlem gerçekleştirilemedi.'));
				return Redirect::back();
			}
		}
		else
		{
			Helpers::validationErrorsYield2Sessions($validation->messages());
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
		return Redirect::to('cms-articles');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$article = CmsArticle::find($id);
		$data = array('article' => $article );
		return View::make('admin.cms.articles.edit' , $data);
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
		$article = CmsArticle::find($id);
		$validation = $article->validate($inputs);
		if(!$validation->fails())
		{
			$article->title = $inputs['title'];
			$article->summary = $inputs['summary'];
			$article->content = $inputs['content'];
			$article->published_on = $inputs['published_on'];
			$article->published_off = $inputs['published_off'];
			if($article->published_off == "")
			{
				$article->published_off = null;
			}

			if ($article->save())
			{	
				// Eklenilen resim satırı varmı ? 
				if (isset($inputs['medias']))
				{	

					// Seçilen resim varmı?
					if ($inputs['medias']!='')
					{
						foreach ($article->medias as $media) 
						{
							$media->articles()->detach($article->id);
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
								$article->medias()->attach($cmsMedia->id, array('sort_order' => $mediaInput['sort_order']));
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
								$article->medias()->attach($newMedia->id, array('sort_order' => $newMedia->sort_order));
							}
						}

					}
					else 
					{
						foreach ($article->medias as $media) 
						{
							$media->articles()->detach($article->id);
						}
					}
				}
				else 
				{
					foreach ($article->medias as $media) 
					{
						$media->articles()->detach($article->id);
					}
				}

				Session::put('status_success', array(0 => 'Makale başarı ile güncellendi.'));
				return Redirect::to('cms-articles');
			}
			else
			{
				Session::put('status_error', array(0 => 'Makale güncellenirken bir hata oluştu. İşlem gerçekleştirilemedi.'));
				return Redirect::back();
			}
		}
		else
		{
			Helpers::validationErrorsYield2Sessions($validation->messages());
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
		if($id != 1 and $id != 2 and $id != 3)
		{
			$article = CmsArticle::find($id);
			$article->delete();
			return Redirect::back();	
		}
		else
		{
			Session::put('status_error', array(0 => 'Bu makaleleri silemezsiniz.'));
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
			foreach ($selects as $select) {
				if(!in_array($select, array('1','2','3')))
				{
					$variable = CmsArticle::find($select);
					$variable->delete();	
				}
			}
		}
		return Redirect::back();
	}

}