<?php

use Illuminate\Database\Eloquent\Model;
class UserGroup extends Model {

	//


	public $timestamps = false;
	protected $table = 'userGroup';
	protected $fillable = ['userid','groupid','admin'];

}
