<?php

class AdminCmsArticleCommentController extends \BaseController {

	public function __construct()
    {
    	/*
		 *  Filter.php 'deki productCategory filtresini çalıştır. 
		 *  Kullacının productCategory izini yoksa giriş vermez.
		 */
        $this->beforeFilter('cmsArticleComments');
	
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('admin.cms.articleComment.articleComment')
			->with('cmsArticleComments', CmsArticleComment::orderBy('status', 'asc')
												  ->orderBy('created_at', 'desc')
												  ->paginate(20)
			);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return Redirect::back();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
		$inputs = Input::all();
		$cmsArticleComment = new CmsArticleComment;
		
		if (!isset($inputs['status']))
		{
			$inputs['status'] = 0;
		}
		$validation = $cmsArticleComment->validate($inputs);
		if(!$validation->fails())
		{
			$cmsArticleComment->comment = $inputs['comment'];
			$cmsArticleComment->author_name = $inputs['author_name'];
			$cmsArticleComment->article_id = $inputs['article_id'];
			$cmsArticleComment->status = $inputs['status'];
			
			if ($cmsArticleComment->save())
			{
				Session::put('status_success', array(0 => 'Makaleye yorum başarı ile eklendi.'));
				return Redirect::back();
			}
			else
			{
				Session::put('status_error', array(0 => 'Makaleye yorum eklenirken bir hata oluştu. İşlem gerçekleştirilemedi.'));
				return Redirect::back();
			}	
		}
		else
		{
			Helpers::validationErrorsYield2Sessions($validation->messages());
			return Redirect::back()->withInput();	
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
		return Redirect::back();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cmsArticleComment = CmsArticleComment::find($id);
		$articleObj = $cmsArticleComment->article;
		$article = array('id' => $articleObj->id, 'title' => $articleObj->title);
		return View::make('admin.cms.articleComment.edit')
			->with('cmsArticleComment', $cmsArticleComment)
			->with('article', $article);
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
		$cmsArticleComment = CmsArticleComment::find($id);
		$validation = $cmsArticleComment->validate($inputs);
		if (!isset($inputs['status']))
		{
			$inputs['status'] = 0;
		}
		if (!$validation->failed())
		{
			$cmsArticleComment->comment = $inputs['comment'];
			if(@isset($inputs['author_id']))
			{
				$cmsArticleComment->author_id = $inputs['author_id'];
			}
			else
			{
				$cmsArticleComment->author_name = $inputs['author_name'];
			}
			$cmsArticleComment->article_id = $inputs['article_id'];
			$cmsArticleComment->status = $inputs['status'];
			
			if ($cmsArticleComment->save())
			{
				Session::put('status_success', array(0 => 'Ürün Yorumu başarı ile düzenlendi.'));
				return Redirect::back();
			}
			else
			{
				Session::put('status_error', array(0 => 'Ürün Yorumu düzenlenirken bir hata oluştu. İşlem gerçekleştirilemedi.'));
				return Redirect::back();
			}
		}
		else
		{
			Helpers::validationErrorsYield2Sessions($validation->messages());
			return Redirect::back()->withInput();	
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
		$cmsArticleComment = CmsArticleComment::find($id);
		$cmsArticleComment->delete();
		return Redirect::back();
	}

	/**
	*  View'da check edilenleri silen fonksiyon
	*  Post olarak gelen değişkeni siler
	*/
	public function deleteSelected()
	{
		$selects = Input::get('selected');
		if(isset($selects))
		{
			foreach ($selects as $select) {
				$variable = CmsArticleComment::find($select);
				$variable->delete();
			}
		}
		return Redirect::back();
	}



}