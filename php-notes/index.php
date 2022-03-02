<?php 
session_start();
if(isset($_SESSION['logged_user'])){
    header("Location: profile.php");   
}
//include 'login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href="css/authorization.css">
    <title>Авторизация</title>
</head>
<body>

<div class="container">
<div class="auth">

<!-- auth_header -->
<!-- <div class="auth_header">
    <a href="#" class="auth_logo">
        <img src="img/label.jpg" class="auth_logo-img">
    </a>
</div> -->

<!-- auth_block -->
<div class="auth_block">
    <div class="auth_block-title">Авторизация</div>



<form method="post" action="login.php" class="auth_form">

<div class="form-group">
<label for="login">Login</label>
<input type="text" name="login" class="form-control">
<span class="text-danger"></span>
</div>

<div class="form-group">
<label for="password">Введите пароль</label>
<input type="password" name="password" class="form-control">
<div class="text-danger">

<?php
if($_SESSION['message'])
{
echo '<span style="color:red;">'.$_SESSION['message'].'<span>';
}   
unset($_SESSION['message']);
?>
</div>
</div>

<button type="submit" class="btn btn-primary" name="do_login">Войти</button>
<div class="auth_footer">Нет учётной записи?
    <a href="register.php">Зарегистрироваться</a>
</div>

</form>

</div> <!-- auth_block -->
</div> <!-- auth -->
 </div> <!-- container -->


</body>
</html>



