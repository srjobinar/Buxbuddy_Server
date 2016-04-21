<?php

class Session {

    const USER_ADMIN = 1;
    const USER_REGULAR = 2;
    const USER_TRAINER =3;
    const USER_DOCTOR = 4;

    private $loggedin = false;
    private $username;
    private $usertype;

    // giving more capabilities. Chat Api Sync.

    function __construct() {
        session_start();
        $this->checkLogin();
    }

    private function checkLogin(){
        if(isset($_SESSION['username'])&&isset($_SESSION['usertype'])){
            $this->username = $_SESSION['username'];
            $this->usertype = $_SESSION['usertype'];
            $this->loggedin = true;
        }else{
            unset($this->username);
            unset($this->usertype);
            $this->loggedin = false;
        }
    }

    function forceLogin($loc){
      if(!$this->getLoggedin()){
        header("Location: ".$loc);
      }
    }

    function redirectIfAuth($l1,$l2,$l3,$l4){

      if($this->getLoggedin()){
        if($this->getUsertype()==Session::USER_ADMIN){
          header("Location: $l1");
        }else if($this->getUsertype()==Session::USER_TRAINER){
          header("Location: $l2");
        }else if($this->getUsertype()==Session::USER_DOCTOR){
          header("Location: $l3");
        }else{
          header("Location: $l4");
        }
      }
    }

    function logIn($user,$user_type){
        if(!$user) return;
        $this->username = $_SESSION['username'] = $user;
        $this->usertype = $_SESSION['usertype'] = $user_type;
        $this->loggedin = true;

        if($this->usertype==session::USER_DOCTOR||$this->usertype==session::USER_REGULAR){
          //add to online table.
          $date = date('Y-m-d h:i:s');
          OnlineUser::destroy(['id'=>$this->username]);
          $u = OnlineUser::create(['id'=>$this->username,'lastseen'=>$date]);
        }

    }

    function logOut(){

      if($this->usertype==session::USER_DOCTOR||$this->usertype==session::USER_REGULAR){
        OnlineUser::destroy(['id'=>$this->username]);
      }
        unset($_SESSION['username']);
        unset($_SESSION['usertype']);
        unset($this->username);
        unset($this->usertype);
        $this->loggedin = false;

    }

    function getLoggedin() {
        return $this->loggedin;
    }

    function getUsername() {
        return $this->username;
    }

    function getUsertype() {
        return $this->usertype;
    }

}

?>
