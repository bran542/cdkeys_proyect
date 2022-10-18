<?php
    session_start();
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'cdkeys_db';

    try {
        $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        //echo 'Connected!';
    } catch (PDOException $e) {
        die('Connected failed: '.$e->getMessage());
    }
?>