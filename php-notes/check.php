<?php
session_start();

if(isset($_SESSION['logged_user'])){
    require 'db.php';    
    
    $data = $_SESSION['logged_user'];
    
    $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `login` = :login");
    
    $stmt -> execute(array(':login'=>$data['login']));
    
    $user = $stmt -> fetch(PDO::FETCH_ASSOC);
    
    
    if($user['password'] === $data['password'])
    {    
      
    }
    else
    {
        header("Location: /");
    }        
        
}
  else{
        header("Location: /"); 
}

?>