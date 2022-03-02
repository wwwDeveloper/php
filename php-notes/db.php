<?php
$dsn = 'mysql:host=localhost;dbname=notes';
$pdo = new PDO($dsn, 'root', 'root');
try {
	$pdo = new PDO($dsn, 'root', 'root');
} catch (PDOException $e) {
	die($e->getMessage());
}

?>