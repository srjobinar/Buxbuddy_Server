<?php

use Illuminate\Database\Eloquent\Model;
class User extends Model {

	//


	public $timestamps = false;
	protected $table = 'user';
	protected $fillable = ['name','phone','password'];

	protected $hidden = ['password'];

	// public function group(){
	// 	return  $this->hasOne('OnlineUser','id');
	// }

	public function group()
	    {
	      return $this->hasMany('UserGroup','userid');
	    }
  public function transaction()
			{
				return $this->hasMany('UserTransaction','userid');
			}


}
