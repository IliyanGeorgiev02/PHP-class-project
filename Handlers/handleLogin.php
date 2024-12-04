<?php
require_once('../functions.php');
require_once('../db.php');
$email=$_POST['email']?? '';
$password=$_POST['password']?? '';

$query="SELECT * FROM users WHERE email=:email";
$stmnt=$pdo->prepare($query);
$stmnt->execute([':email'=>$email]);
$user=$stmnt->fetch();

if(!$user){
    header('Location: ../index.php?page=login&error=Грешен имейл или парола');
    exit;
}

if(!password_verify($password,$user['password'])){
    header('Location: ../index.php?page=login&error=Грешен имейл или парола');
    exit;
}
session_start();
$_SESSION['user_email']= $user['email'];
$_SESSION['user_name']= $user['names'];
$_SESSION['user_id']= $user['id'];
$_SESSION['is_admin']=$user['is_admin'];

setcookie('user_email', $user['email'], time()+3600,'/','localhost',false,true);


header('Location: ../index.php?page=home');
exit;

?>