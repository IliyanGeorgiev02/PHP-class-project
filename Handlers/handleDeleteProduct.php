<?php
require_once('../functions.php');
require_once('../db.php');
$productId=intval($_POST['id']??0);
if($productId==0){
    $_SESSION['flash']['message']['type']='danger';
    $_SESSION['flash']['message']['text']='Невалиден продукт';
    header('Location: ../index.php?page=products');
    exit;
}
$query="DELETE FROM products WHERE id=:id";
$stmnt=$pdo->prepare($query);
if($stmnt->execute([':id'=>$productId])){
    $_SESSION['flash']['message']['type']='success';
    $_SESSION['flash']['message']['text']='Успешно изтрит продукт!';
}else{
    $_SESSION['flash']['message']['type']='danger';
    $_SESSION['flash']['message']['text']='Възникна грешка при изтриване на продукт';
}
header('Location: ../products.php?page=add_product');
exit;

?>