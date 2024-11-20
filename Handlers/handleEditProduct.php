<?php
require_once('../functions.php');
require_once('../db.php');
$title = trim($_POST['title']?? '');
$price = trim($_POST['price']?? '');
$productId = intval($_POST['id']?? 0);


if(mb_strlen($title)==0||mb_strlen($price)==0 || $productId<=0){
$_SESSION['flash']['message']['type']='danger';
$_SESSION['flash']['message']['text']='Попълнете всички полета';
header('Location: ../index.php?page=edit_product&id='.$productId);
exit;
}else{

}
$query="UPDATE products SET title=:title, price=:price WHERE id=:id";
$stmnt=$pdo->prepare($query);
$params=[
':title'=>$title,
':price'=>$price,
':id'=>$productId,
];

if($stmnt->execute($params)){
    $_SESSION['flash']['message']['type']='success';
    $_SESSION['flash']['message']['text']='Успешно редактиран продукт!';
    exit;
}else{
    $_SESSION['flash']['message']['type']='danger';
    $_SESSION['flash']['message']['text']='Възникна грешка при редакция на продукт';
}

    header('Location: ../index.php?page=edit_product&id='.$productId);
    exit;
?>