<?php

class CmsArticle extends Eloquent
{
	protected $table = 'cms_articles';
	public $timestamps = true;
	protected static $rules = array(
		'page_id' => 'required',
		'title'	=>	'required',
		'summary'	=>	'required',
		'content'	=>	'required',
		'published_on'	=> 'date',
		'published_off'	=>	'date|after_field:published_on',
	);
	protected static $messages = array(
		'page_id.required'	=>	'Lütfen makale için bir sayfa seçiniz',
		'title.required'	=>	'Lütfen makale için bir başlık girin',
		'summary.required'	=>	'Lütfen makale için bir açıklama girin',
		'content.required'	=>	'Lütfen makale içeriğini girmeyi unutmayın',
		//'published_on.required'	=>	'Lütfen makale için bir yayınlanma tarihi girin',
		//'published_off.required'	=>	'Lütfen makale için bir yayından çekme tarihi girin',
		//'title.alpha_dash'	=>	'Makale başlığı harf, rakam ve tirelerden oluşmalıdır',
		//'summary.alpha_dash'	=>	'Makale özeti harf, rakam ve tirelerden oluşmalıdır',
		'published_on.date'	=>	'Lütfen makale için geçerli bir yayınlanma tarihi girin',
		'published_off.date'	=>	'Lütfen makale için geçerli bir yayından çekme tarihi girin',
		'published_off.after_field'	=>	'Makalenin yayından kaldırılma tarihi, yayın tarihinden sonraki bir tarihe denk gelmelidir',
	);
    public static function validate($data)
    {
        return Validator::make($data, static::$rules, static::$messages);
    }

	public function page()
	{
		return $this->belongsTo('CmsPage' , 'page_id');
	}

	public function comments()
	{
		return $this->hasMany('CmsArticleComment', 'article_id');
	}

	public function medias()
	{
		return $this->belongsToMany('CmsMedia', 'cms_articles_has_images', 'cms_article_id' , 'cms_media_id')->withPivot('sort_order');
	}

	public function delete()
	{
		foreach ($this->medias as $media) {
			$media->articles()->detach($this->id);
		}
		parent::delete();
	}
}