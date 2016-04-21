<?php

use Illuminate\Database\Eloquent\Model;
class User extends Model {

	//


	public $timestamps = false;
	protected $table = 'autism_users';
	protected $fillable = ['name','phone','address','email','password','type'];

	protected $hidden = ['password'];
	
	public function online(){
		return  $this->hasOne('OnlineUser','id');
	}

	public function video()
	    {
	      return $this->hasMany('Video','user_id');
	    }
  public function article()
			{
				return $this->hasMany('Article','user_id');
			}


}
