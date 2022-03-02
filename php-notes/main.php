<?php

    if(isset($_POST['get_notes'])){
    header("Content-Type: application/json; charset=UTF-8"); 
    echo getNotes();        
    }

    function getNotes(){
    require 'db.php';
    $stmt = $pdo->prepare("SELECT * FROM `notes_list` WHERE `user_id` = :user_id ORDER BY id DESC");
    $stmt -> execute(array(':user_id' => $_POST['get_notes']));
    $result = $stmt -> fetchAll(PDO::FETCH_OBJ);    
    $resultJSON = json_encode($result);
    return $resultJSON;    
    }
    
?>