<?php


$json = file_get_contents('php://input');

$_POST = json_decode($json,TRUE);

require __DIR__.'/./vendor/autoload.php';
require './config.php';
require './classes/boot.php';
require './classes/User.php';
require './classes/Group.php';

require_once './classes/session.php';

$session = new Session();

//Do  and stuff here


$type = $_POST['type'];

switch($type){

	case "addGroup" : $out = addGroup(); break;

}



echo json_encode($out,TRUE);



/*********** Functions *********/


function addGroup(){

	$name = $_POST['name']; //do validation

	return Group::create(['name'=>$name]);
}



 ?>
