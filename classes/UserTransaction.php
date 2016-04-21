<?php

use Illuminate\Database\Eloquent\Model;
class UserTransaction extends Model {



	public $timestamps = false;
	protected $table = 'userTransaction';
	protected $fillable = ['userid','transid','amount'];

	protected $hidden = ['password'];



}
