<?php

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

	//
	public $timestamps = false;
	protected $table = 'autism_articles';
	protected $fillable = ['name','author','content','user_id'];

	public function user()
			{
				return $this->belongsTo('User');
			}
}
