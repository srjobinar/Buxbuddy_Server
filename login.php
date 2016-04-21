<?php

require __DIR__.'/./vendor/autoload.php';
require './config.php';
require './helpers/boot.php';

require_once './helpers/OnlineUser.php';
require_once './helpers/session.php';
require_once './helpers/User.php';
require './helpers/functions.php';

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
$messages = getErrorMessages();

if(isset($_POST['type'])){
  $type = $_POST['type'];
  if($type=="login"){

    if($_POST['email']==$admin_email&&$_POST['password']==$admin_password){
      $session->logIn(1, Session::USER_ADMIN);
      $session->redirectIfAuth('./admin/index.php','./trainer/index.php','./doctor/index.php','./index.php');
    }

    $validator = $factory->make($_POST, ['email'=>'required','password'=>'required'],$messages);
    if($validator->passes()) {
      $u = User::where('email',$_POST['email'])->where('password',$_POST['password'])->first();
      if($u){
        $session->logIn($u->id, $u->type);
        $session->redirectIfAuth('./admin/index.php','./trainer/index.php','./doctor/index.php','./index.php');
      }else{
        $error = ERROR_INVALID;
      }
    }else{
      $error = ERRROR_VALFAIL;
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
          $session->redirectIfAuth('./admin/index.php','./trainer/index.php','./doctor/index.php','./index.php');
        }else{
          $error = ERROR_DB;
        }
      }
    }else{
      $error = ERROR_VALFAIL;
    }
  }
}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Autism</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link href="./static/css/awe.css" rel="stylesheet">
  <link href="./static/css/player.css" rel="stylesheet">
  <script type="text/javascript" src="./static/js/jquery.min.js"></script>
  <script type="text/javascript" src="./static/js/bootstrap.min.js"></script>
</head>
<body>


<div class="loginpage">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 col-md-offset-3 col-sm-12">
        <h1>Autism Community</h1>
        <h4>Login</h4>
        <?php
        if(isset($type)&&$type=="login"){
          printLoginErrors($error,$validator->messages());
        }
         ?>
        <form class="form-horizontal" action="login.php" method="POST">
          <input type="hidden" name="type" value="login" />
          <div class="form-group">
                  <input class="form-control" placeholder="Email" name="email"  type="email" required>
          </div>
                <div class="form-group">
                  <input class="form-control" placeholder="Password" name="password" type="password" required>
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-primary" value="Login"/>
                </div>

        </form>

        <h4>Sign Up</h4>
        <?php
        if(isset($type)&&$type=="signup"){
          printSignUpErrors($error,$validator->messages());
        } ?>

        <form class="form-horizontal" action="login.php" method="POST">
          <input type="hidden" name="type" value="signup" />
          <div class="form-group">
                  <input class="form-control" placeholder="Name" name="name"  type="text" required>
          </div>
          <div class="form-group">
                  <input class="form-control" placeholder="Email" name="email"  type="email" required>
          </div>
          <div class="form-group">
                  <input class="form-control" placeholder="Phone" name="phone"  type="text" required>
          </div>
          <div class="form-group">
                  <input class="form-control" placeholder="Address" name="address"  type="text" required>
          </div>
                <div class="form-group">
                  <input class="form-control" placeholder="Password" name="password" type="password" required>
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-primary" value="Sign Up"/>
                </div>
              </div>
        </form>

      </div>
    </div>
  </div>
</div>



    <script>
      $(document).ready(function() {

      });
    </script>
</body>

</html>
