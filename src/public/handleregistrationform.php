<?php

print_r($GET);

$name = $GET['name'];
$email = $GET['email'];
$password = $GET['psw'];
$repeatpassword = $GET['psw-repeat'];


$pdo = new PDO('pgsql:host=postgres;dbname=testdb', 'user', '123', '');

$pdo->exec("INSERT INTO users(name, email, password) VALUES ('Lev','Lev@ya.ru','456321')") ;

