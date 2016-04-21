<?php


$json = file_get_contents('php://input');

$_POST = json_decode($json,TRUE);

require __DIR__.'/./vendor/autoload.php';
require './config.php';
require './classes/boot.php';
require './classes/User.php';
require './classes/Group.php';
require './classes/UserGroup.php';
require './classes/Fund.php';
require './classes/Transaction.php';

require_once './classes/session.php';

$session = new Session();

//Do  and stuff here


$type = $_POST['type'];

switch($type){

  case "login" : $out = login(); break;
	case "createGroup" : $out = createGroup(); break;
	case "addTransaction" : $out = addTransaction(); break;
	case "getTransaction" : $out = getTransaction(); break;
	case "getTransaction" : $out = getTransaction(); break;

}



echo json_encode($out,TRUE);



/*********** Functions *********/


function login(){
	$u = User::where('phone',$_POST['phone'])->where('password',$_POST['password'])->first();

	if($u){

	        $session->logIn($u->id, $u->type);
	        $out['status'] = "success";

	      }else{
	        $out['status'] = "fail";
	        $out['error'] = "invalid credentials.";

	      }
				return $out;
}

function createGroup(){

	$name = $_POST['name']; //do validation

	$out['group']= $group = Group::create(['name'=>$name]);
	$users = $_POST['users'];
	foreach ($users as $key => $value) {
		$users[$key]['groupid']=$group->id;
	}

	var_dump(UserGroup::insert($users));
	$out['status']='success';
	$out['groupid']=$group->id;
 return $out;
}

function addTransaction(){
	$name=$_POST['name'];
	$amount=$_POST['amount'];
	$gid=$_POST['gid'];
  $out['transaction']=Transaction::create(['name'=>$name,"amount"=>$amount,'groupid'=>$gid]);
}



 ?>
