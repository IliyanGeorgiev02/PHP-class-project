<?php
require_once('../functions.php');
require_once('../db.php');

$error='';
foreach($_POST as $key => $value){
    if(mb_strlen($value)==0){
        $error='Невалидни данни';
        break;
    }
}
if(mb_strlen($error)>0){
    header('Location: ../index.php?page=register&error='.$error);
    exit;
}else{
    $names=trim($_POST['names']);
    $email=trim($_POST['email']);
    $password=trim($_POST['password']);
    $repeat_password=trim($_POST['repeat_password']);

    if($password!=$repeat_password){
        $error='Невалидни данни';
        header('Location: ../index.php?page=register&error='.$error);
        exit;
    }else{
        $password=password_hash($password,PASSWORD_ARGON2I);
        $query="INSERT INTO users (names,email, `password`) VALUES ('$names','$email','$password')";
        $stmt=$pdo->query($query);
        if($stmt){
            header('Location: ../index.php?page=home');
        }else{
            $error='Невалидни данни';
            header('Location: ../index.php?page=register&error='.$error);
            exit;
    }   
    }
}



?>