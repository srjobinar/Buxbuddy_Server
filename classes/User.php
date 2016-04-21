<?php

use Illuminate\Database\Eloquent\Model;
class User extends Model {

	//


	public $timestamps = false;
	protected $table = 'user';
	protected $fillable = ['name','phone','password'];

	protected $hidden = ['password'];



}
