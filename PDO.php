<?php 
use PDO;
$pdo = new PDO('mysql:dbname=db.data;host=localhost', 'root', null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);