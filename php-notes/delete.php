<?php

if(isset($_POST['note_id'])){

$note_id = $_POST['note_id'];
require 'db.php';
$sql = 'DELETE FROM notes_list WHERE note_id = :note_id';
$statement = $pdo->prepare($sql);
$statement->bindParam(':note_id', $note_id);
if ($statement->execute()) {
	echo 'note id ' . $note_id . ' was deleted successfully.';
}

} 

 ?>

