<?php

use Illuminate\Database\Eloquent\Model;
class Transaction extends Model {

	//


	public $timestamps = false;
	protected $table = 'transactions';
	protected $fillable = ['name','amount','groupid'];

}
