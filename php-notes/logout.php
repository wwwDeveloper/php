<?php
session_start();
if(isset($_POST['logout'])){
unset($_SESSION['logged_user']);
header("Location: /");    
};

?>