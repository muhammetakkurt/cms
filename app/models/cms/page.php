<?php

class CmsPage extends Eloquent
{
	protected $table = 'cms_pages';
	public $timestamps = true;
	protected static $rules = array(
		'parent_id'	=>	'required',
		'name'	=>	'required',
		'sort_order'	=>	'required|numeric',
		'published_on'	=>	'date',
		'published_off'	=>	'date|after_field:published_on',
	);
	protected static $messages = array(
		'parent_id.required'	=>	'Her sayfa bir ana kaynağa bağlı olmalıdır',
		'name.required'	=>	'Lütfen sayfaya bir ad veriniz',
		'sort_order.required'	=>	'Lütfen sayfa için bir sıralama giriniz',
		'sort_order.numeric'	=> 	'Lütfen sayfa için sıralama girerken, sayısal bir değer kullanın',
		'published_on.date'	=>	'Sayfa yayınlanma tarihi, gerçek bir tarih olmalıdır',
		'published_off.date'	=>	'Sayfanın yayından çekme tarihi, gerçek bir tarih olmalıdır',
		'published_off.after_field'	=>	'Sayfanın yayından çekme tarihi, yayınlanma tarihinden sonraki bir tarihe denk gelmelidir',
	);
    public static function validate($data)
    {
        return Validator::make($data, static::$rules, static::$messages);
    }

	public function parent()
	{
		return $this->belongsTo('CmsPage', 'parent_id');
	}

	public function articles()
	{
		return $this->belongsToMany('CmsArticle', 'cms_pages_has_articles', 'cms_page_id')->withPivot('sort_order');
	}

	public function medias()
	{
		return $this->belongsToMany('CmsMedia', 'cms_pages_has_images', 'cms_page_id')->withPivot('sort_order');
	}

	public function delete()
	{
		foreach ($this->medias as $media) {
			$media->pages()->detach($this->id);
		}
		/*
		foreach ($this->articles as $article ) {
			
		}
		*/
		parent::delete();
	}
}