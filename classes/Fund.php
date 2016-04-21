<?php

use Illuminate\Database\Eloquent\Model;
class Fund extends Model {

	//


	public $timestamps = false;
	protected $table = 'funds';
	protected $fillable = ['userid','groupid','fund'];

	protected $hidden = ['password'];



}
