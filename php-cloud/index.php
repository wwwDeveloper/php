<?php
session_start([ 'cookie_lifetime' => 43000 ]);

if(isset($_SESSION['token'])){
    header("Location: vmlist.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href="css/authorization.css">
    <title>Authorization</title>
</head>
<body>

<div class="container">
<div class="auth">


<!-- auth_block -->
<div class="auth_block">
    <div class="auth_block-title">Authorization</div>

<form action="login.php" method="post" class="auth_form">

<div class="form-group">
<input type="text" name="login" class="form-control" placeholder="User name:">
<span class="text-danger"></span>
</div>

<div class="form-group">
<input type="password" name="password" class="form-control" placeholder="Password:">
<span class="text-danger">
 <?php
     if($_SESSION['message']){
        echo '<p class="text-danger">' . $_SESSION['message'] . '</p>';
    }            
    unset($_SESSION['message']);
 ?>
    
</span>
</div>

<button type="submit" class="btn btn-primary" name="do_login">Login</button>

</form>

</div> <!-- auth_block -->
</div> <!-- auth -->
 </div> <!-- container -->

</body>
</html>



