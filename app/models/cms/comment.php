<?php
	class CmsArticleComment extends Eloquent
	{
		protected $table	=	"cms_article_comments";
		/**
		 * Add messages according to $rules variable
		 */
		protected static $rules = array(
			'article_id'				=> 'required|integer',
			'author_id'					=> 'required_without:author_name|integer',
			'author_name'       		=> 'required_without:author_id',
			'status'					=> 'required',
			'comment'					=> 'required|min:3',
		);
		protected static $messages = array(
			'article_id.required'       =>  'Yorumun yapılacağı içerik tanımlanamadı',
			'article_id.integer'        =>  'Yorum sıra numarası, sayısal değerlerden oluşmalıdır',
			'author_id.required'        =>  'Lütfen yorum için yazar girmelisiniz',
			'author_id.integer'         =>  'Yazar, sayısal değerlerden oluşmalıdır',
			'author_name.required'      =>  'Lütfen yorum için yazar isimi girmelisiniz',
			'author_name.string'        =>  'Yazar adı, alfanumerik karakterlerden oluşmalıdır',
			'status.required'           =>  'Lütfen yorum durumunu seçiniz',
			'comment.required'          =>  'Lütfen yorum giriniz',
			'comment.min'               =>  'Yorum, minimum 3 harften oluşmalıdır',
		);
		public static function validate($data)
		{
		  return Validator::make($data, static::$rules, static::$messages);
		}
		public $timestamps = true;
			
		public function article()
		{
			return $this->belongsTo('CmsArticle');
		}
		public function user()
		{
	    	return $this->belongsTo('User', 'author_id');
		}
	}
/** End of comment.php