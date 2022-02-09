<?php
session_start();
require 'include/credentials.php';
require 'include/session.php';

$errors=array();
$data=$_POST;

if(isset($_SESSION['token'])){
    header("Location: vmlist.php");
}


if(isset($data['do_login'])){

    $get_credentials = authorize($data['login'], $data['password']);
    session($get_credentials, $loginurl);
    
       if(session($get_credentials, $loginurl) === "not authorized"){
        $errors[]="Not valid username or password";        
    }

    if(!empty($errors)){

    
    $_SESSION['message'] = array_shift($errors); 

    header("Location: /");   
}


 else{
     if(!$_SESSION['token'])
{
$_SESSION['token'] = session($get_credentials, $loginurl);
};
    header("Location: vmlist.php");
}
}

?>








