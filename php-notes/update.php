<?php
    if(isset($_POST['json'])){
    $json_d = json_decode($_POST['json'], true);
    $note_id = $json_d['note_id'];
    $note = $json_d['note'];
    $user_id = $json_d['user_id'];
    require 'db.php';          
        $stmt = $pdo->prepare("UPDATE `notes_list` SET `note` = :note WHERE `note_id` = :note_id AND `user_id` = :user_id");
        $stmt -> execute(array(':note_id'=>$note_id, ':note'=>$note, ':user_id'=>$user_id));      
    }; 
?>