<?php
session_start();
$data=$_POST;
$login = $_POST['login'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];



if(isset($data['do_signup'])){  
$login=trim($login);
$password=trim($password);    
if($login == "" || mb_strlen($login)<3)
{
    $_SESSION['message'] = "Логин должен быть не меньше 3-x символов";
    header("Location: register.php");    
}
elseif (!preg_match("/^[a-zA-Z0-9]+$/", $login)) {
 $_SESSION['message'] = "Логин может состоять только из букв английского алфавита и цифр";
    header("Location: register.php");    
} 
elseif ($password == "") 
{
    $_SESSION['message'] = "Пароль должен быть не меньше 3-х символов";
    header("Location: register.php");   
}
else{
    require_once 'db.php';
    $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `login` = :login");   
    $stmt -> execute(array(':login'=>$login));    
    $check_user = $stmt -> rowCount();
    
    if($check_user > 0){
        $_SESSION['message'] = "Пользователь с таким логином уже существует";
        header("Location: register.php");    
    }

    else
    {

        if($password === $password_confirm)

        {    
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO `users` (login, password) VALUES (:login, :password)");        
        
        $stmt -> execute(array(':login'=>$login, ':password'=>$password));
        
        header("Location: register.php");
        
        $_SESSION['message'] = "Регистрация прошла успешно";
        
        }
        else
        {
            $_SESSION['message'] = "Пароли не совпадают";
            header("Location: register.php");   
        }        

    }

} 
    }  //do_signup
    

?>





