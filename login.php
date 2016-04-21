<?php


$json = file_get_contents('php://input');

$_POST = json_decode($json,TRUE);

$out['values'] = $_POST;

require __DIR__.'/./vendor/autoload.php';
require './config.php';
require './classes/boot.php';

require_once './classes/session.php';


$u = User::where('phone',$_POST['phone'])->where('password',$_POST['password'])->first();
      
if($u){

        $session->logIn($u->id, $u->type);
        $out['status'] = "success";

      }else{
        $out['status'] = "fail";
        $out['error'] = "invalid credentials.";

      }
    
echo json_encode($out,TRUE);

 ?>
