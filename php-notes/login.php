<?php
session_start();
$data=$_POST;
$login = $_POST['login'];
$password = $_POST['password'];

if(isset($_SESSION['logged_user'])){
    header("Location: profile.php");   
}else{

    if(isset($data['do_login'])){
        $login=trim($login);
        $password=trim($password); 
            if($login == "")
            {
                $_SESSION['message'] = "Введите ваш логин";
                header("Location: /");    
            }   
            elseif (!preg_match("/^[a-zA-Z0-9]+$/", $login)) {
             $_SESSION['message'] = "Неверный логин";
              header("Location: /");    
            }
            elseif ($password == "") 
            {
                $_SESSION['message'] = "Введите ваш пароль";
                header("Location: /");   
            } 
            else{
                require_once 'db.php';
                $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `login` = :login");   
                $stmt -> execute(array(':login'=>$login));    
                $check_user = $stmt -> rowCount();
                
                if($check_user > 0){
        
                    $user = $stmt -> fetch(PDO::FETCH_ASSOC);
        
                    if(password_verify($password, $user['password'])){
                        
                    
                        $_SESSION['logged_user'] = $user;
                    
                        header("Location: profile.php");
                    
                    }            
                    else
                    {
                    $_SESSION['message'] = "Неверный пароль";
                    header("Location: /");
                    
                    }  //check_user
                       
                }
            
                else
                {
                $_SESSION['message'] = "Пользователя с таким логином не существует";
                header("Location: /");    
                }
            
            }
        }




}

?>

