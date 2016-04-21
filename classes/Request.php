<?php

use Illuminate\Database\Eloquent\Model;
class Request extends Model {

	//


	public $timestamps = false;
	protected $table = 'requests';
	protected $fillable = ['fromid','transid','status','groupid'];


}
