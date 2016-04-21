<?php

$json = file_get_contents('php://input');
$_POST = json_decode($json,TRUE);

$out['values'] = $_POST;

require __DIR__.'/./vendor/autoload.php';
require './config.php';
require './classes/boot.php';

require_once './classes/session.php';


use Illuminate\Validation\Factory as ValidatorFactory;
use Symfony\Component\Translation\Translator;

$error = 0;
const ERROR_DB = 1;
const ERROR_INVALID = 3;
const ERROR_VALFAIL = 4;
const ERROR_MAILTAKEN = 5;


$session = new Session();
$session->redirectIfAuth('./admin/index.php','./trainer/index.php','./doctor/index.php','./index.php');

$factory = new ValidatorFactory(new Translator('en'));

if(isset($_POST['type'])){
  $type = $_POST['type'];

  if($type=="login"){

    $validator = $factory->make($_POST, ['phone'=>'required','password'=>'required'],$messages);

    if($validator->passes()) {
      $u = User::where('phone',$_POST['phone'])->where('password',$_POST['password'])->first();
      if($u){

        $session->logIn($u->id, $u->type);
        $out['status'] = "success";

      }else{
        $out['status'] = "fail";
        $out['error'] = "invalid credentials.";

      }
    }else{
        $out['status'] = "fail";
        $out['error'] = "phone/password missing in data.";
    }

  }else if($type=="signup"){
    $rules = array(
      'name' => 'required',
      'email' => 'required|email',
      'phone' => 'required|numeric|digits_between:10,15',
      'address' =>'required',
      'password' => 'required'
    );
    $validator = $factory->make($_POST, $rules,$messages);
    if($validator->passes()) {
      $_POST['type'] = Session::USER_REGULAR;
      //check if email exits
      $u = User::where('email',$_POST['email'])->first();
      if($u){
        $error = ERROR_DB;
      }else{
        if($u = User::create($_POST)){

        $session->logIn($u->id, $u->type);

        }else{
          $error = ERROR_DB;
        }
      }
    }else{
      $error = ERROR_VALFAIL;
    }
  }
}else{
 //type not set
 $out['status'] = "fail";
 $out['error'] = "type not set.";
}

echo json_encode($out,TRUE);

 ?>
