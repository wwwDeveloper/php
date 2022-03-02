<?php
	
    if(isset($_POST['json'])){
    $json_d = json_decode($_POST['json'], true);
    $note_id = $json_d['note_id'];
    $note = $json_d['note'];
    $user_id = $json_d['user_id'];
    require 'db.php';
    $stmt = $pdo->prepare("INSERT INTO `notes_list` (user_id, note_id, note) VALUES (:user_id, :note_id, :note)");
        
    $stmt -> execute(array(':user_id'=>$user_id, ':note_id'=>$note_id, ':note'=>$note));      

    }; 

?>