<?php
require_once('../db.php');
$response=[
    'success'=>true,
    'data'=>[],
    'error'=>''
];
$productId=intval($_POST['product_id'] ?? 0);
$response['data']['product_id']=$productId;

if($productId<=0){
    $response['success']=false;
    $response['error']="Невалиден продукт";
}else{
    $userId=$_SESSION['user_id'];
    $query="INSERT INTO favorite_products_users (user_id, product_id) values(:user_id, :product_id)";
    $stmt=$pdo->prepare($query);
    $params=[
        ':user_id'=>$userId,
        ':product_id'=>$productId
    ];
    if(!$stmt->execute($params)){
        $response['success']=false;
        $response['error']="Възникна грешка при добавяне в любими.";
    }
}

echo json_encode($response);
exit;
?>