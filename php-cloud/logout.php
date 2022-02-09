<?php
session_start();

if(isset($_POST['logout'])){

unset($_SESSION['token']);

header("Location: /");

}
?>