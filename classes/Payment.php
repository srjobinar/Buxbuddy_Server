<?php

use Illuminate\Database\Eloquent\Model;
class Payment extends Model {

	//


	public $timestamps = false;
	protected $table = 'payments';
	protected $fillable = ['fromid','toid','amount','groupid','status'];




}
