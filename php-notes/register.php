<?php
session_start();
if($_SESSION['logged_user']){
header("Location: profile.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/authorization.css">
    <title>Авторизация и регистрация</title>
</head>
<body>
<div class="container">
<div class="auth">

<!-- auth_header -->
<!-- <div class="auth_header">
    <a href="#" class="auth_logo">
        <img src="img/label.jpg" class="auth_logo-img">
    </a>
</div>-->

<!-- auth_block -->
<div class="auth_block">
    <div class="auth_block-title">Регистрация</div>

 
<form action="signup.php" method="post" class="auth_form">
<div class="form-group">
<label for="login">Логин</label>
<input type="text" name="login" class="form-control">
<span class="text-danger"></span>
</div>

<div class="form-group">
<label for="password">Введите пароль</label>
<input type="password" name="password" class="form-control">
</div>
<div class="form-group">
<label for="password">Подтверждение пароля</label>
<input type="password" name="password_confirm" class="form-control">
<div class="text-danger">
<?php
if($_SESSION['message'] === "Регистрация прошла успешно")
{
echo '<span style="color:green;">'.$_SESSION['message'].'<span>';
}
else
{
    echo '<span>'.$_SESSION['message'].'<span>';    
}            
unset($_SESSION['message']);
?>

</div>

</div>

<button type="submit" class="btn btn-primary" name="do_signup">Зарегистрироваться</button>
<div class="auth_footer">Уже есть учётная запись?
    <a href="index.php">Войти</a>
</div>

</form>

</div> <!-- auth_block -->
</div> <!-- auth -->
 </div> <!-- container -->



</body>
</html>