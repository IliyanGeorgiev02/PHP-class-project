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

if(mb_strlen($title)==0||mb_strlen($price)==0){
$_SESSION['flash']['message']['type']='danger';
$_SESSION['flash']['message']['text']='Попълнете всички полета';
header('Location: ../index.php?page=add_product');
exit;
}
if(!isset($_FILES['image']) || $_FILES['image']['error']!=0){
    $_SESSION['flash']['message']['type']='danger';
    $_SESSION['flash']['message']['text']='Попълнете всички полета';
    header('Location: ../index.php?page=add_product');
    exit;
}
$newFilename=time().'_'.$_FILES['image']['name'];
$uploadDir='../uploads/';

if(!is_dir($uploadDir)){
    mkdir($uploadDir, 0775, true);
}


if(!move_uploaded_file($_FILES['image']['tmp_name'],$uploadDir.$newFilename)){
    $_SESSION['flash']['message']['type']='danger';
    $_SESSION['flash']['message']['text']='Възникна грешка при качване на файл';
    header('Location: ../index.php?page=add_product');
    exit;
}else{
    $query="INSERT INTO products (title,price,image) values(:title,:price,:image)";
    $stmnt=$pdo->prepare($query);
    $params=[':title'=>$title,
        ':price'=>$price,
        ':image'=>$newFilename
];
if($stmnt->execute($params)){
    $_SESSION['flash']['message']['type']='success';
    $_SESSION['flash']['message']['text']='Успешно добавен продукт!';
    header('Location: ../index.php?page=products');

    exit;
}else{
    $_SESSION['flash']['message']['type']='danger';
    $_SESSION['flash']['message']['text']='Възникна грешка при добавяне на продукт';

    header('Location: ../index.php?page=add_product');
    exit;
}
}

?>