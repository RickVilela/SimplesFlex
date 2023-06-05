<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$email = $_POST['email'];


$pdo = new PDO('mysql:host=localhost; dbname=cadcli;', 'root', '');

$stmt = $pdo->prepare('INSERT INTO cadcli (email) VALUES (:e)');
$stmt->bindValue(':e', $email);


$stmt->execute();

if($stmt->rowCount() >= 1){
    echo json_encode($stmt);
}else{
    echo json_encode("Falha ao retornar dados!");
}
