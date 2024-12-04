<?php
require_once('../functions.php');
require_once('../db.php');

if(!isAdmin()){
    $_SESSION['flash']['message']['type']='warning';
    $_SESSION['flash']['message']['text']='нямате достъп до тази страница!';
    header('Location:../index.php');
    exit;
}


$title = trim($_POST['title']?? '');
$price = trim($_POST['price']?? '');
$productId = intval($_POST['id']?? 0);

if(mb_strlen($title)==0||mb_strlen($price)==0 || $productId<=0){
$_SESSION['flash']['message']['type']='danger';
$_SESSION['flash']['message']['text']='Попълнете всички полета';
header('Location: ../index.php?page=edit_product&id='.$productId);
exit;
}

$img_uploaded=false;
if(isset($_FILES['image']) && $_FILES['image']['error']==0){
    $newFilename=time().'_'.$_FILES['image']['name'];
    $uploadDir='../uploads/';   
if(!is_dir($uploadDir)){
    mkdir($uploadDir, 0775, true);
}
if(!move_uploaded_file($_FILES['image']['tmp_name'],$uploadDir.$newFilename)){
    $_SESSION['flash']['message']['type']='danger';
    $_SESSION['flash']['message']['text']='Възникна грешка при качване на файл';
    header('Location: ../index.php?page=edit_product&id='.$productId);
    exit;
}else{
    $img_uploaded=true;
}
}

$query='';
if($img_uploaded){
    $query="UPDATE products SET title=:title, price=:price,image=:image WHERE id=:id";
}else{

    $query="UPDATE products SET title=:title, price=:price WHERE id=:id";
}
$stmnt=$pdo->prepare($query);
$params=[
':title'=>$title,
':price'=>$price,
':id'=>$productId,
];
if($img_uploaded){
$params[':image']=$newFilename;
}



if($stmnt->execute($params)){
    $_SESSION['flash']['message']['type']='success';
    $_SESSION['flash']['message']['text']='Успешно редактиран продукт!';
}else{
    $_SESSION['flash']['message']['type']='danger';
    $_SESSION['flash']['message']['text']='Възникна грешка при редакция на продукт';
}
    header('Location: ../index.php?page=edit_product&id='.$productId);
    exit;
?>