<?php

    $host = 'localhost';
    $db = 'crud_php';
    $user = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host; dbname=$db", $user, $password);
    } catch(PDOException $e) {
        echo 'Ошибка соединения с БД: '.$e->getMessage();
    }

?>