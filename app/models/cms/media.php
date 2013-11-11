<?php

class CmsMedia extends Eloquent
{
	protected $table = 'cms_medias';
	public $timestamps = true;
	protected static $rules = array(
		'name'	=>	'required',
		'path'	=>	'required',
		'sort_order'	=>	'required|numeric',
	);
	protected static $messages = array(
		'name.required'	=>	'Lütfen medya için bir isim girin',
		'path.required'	=>	'Lütfen medyanın dosya yolunu girin',
		'sort_order.required'	=>	'Lütfen meyda için, sıralama bilgisi girin',
		'sort_order.numeric'	=>	'Lütfen medya sıralaması girerken sayısal değerler kullanın',
	);
    public static function validate($data)
    {
        return Validator::make($data, static::$rules, static::$messages);
    }

	public function articles()
	{
		return $this->belongsToMany('CmsArticle', 'cms_articles_has_images', 'cms_media_id', 'cms_article_id');
	}

	public function pages()
	{
		return $this->belongsToMany('CmsPage', 'cms_pages_has_images', 'cms_media_id', 'cms_page_id');
	}
}