<?php
    $products = [];

    $search=$_GET['search'] ??'';

    $query="SELECT * FROM products WHERE title LIKE :search";
    $stmt=$pdo->prepare($query);
    $stmt->execute([':search'=>"%$search%"]);
    while($row=$stmt->fetch()){
            $fav_query="SELECT id FROM favorite_products_users WHERE user_id=:userId AND product_id=:productId";    
            $fav_stmt=$pdo->prepare($fav_query);
            $favParams=[
                ':userId'=>$_SESSION['user_id']??0,
                ':productId'=>$row['id']
            ];
            $fav_stmt->execute($favParams);
            $row['isFavorite']=$fav_stmt->fetch()?1:0;
            $products[]=$row;
    } 
    $search='';
    if(!empty($search)){
        setcookie('lastSearch', $search, time()+3600,'/','localhost',false,true);
    };
?>

<div class="row">
    <form class="mb-4" method="GET">
        <div class="input-group">
            <input type="hidden" name="page" value="products">
            <input type="text" class="form-control" placeholder="Търси продукт" name="search" value="<?php echo $_GET['search'] ?? ''?>">
            <button class="btn btn-primary" type="submit">Търсене</button>
        </div>
    </form>
    <?php
    if  (isset($_COOKIE['lastSearch'])){
        echo '<div class="alert alert-info" role="alert">
        Последно търсене: '.$_COOKIE['lastSearch'].'
        </div>';
    }
    ?>
</div>
<div class="d-flex flex-wrap justify-content-between">
    <?php
    if(count($products)>0){
    foreach ($products as $product) {
        $favBtn=$editDeleteButtons='';
        if(isset($_SESSION['user_name'])){
            if($product['isFavorite']=='1'){
            $favBtn='
            <div class="card-footer text-center">
            <button class="btn btn-danger btn-sm remove-favorite" data-product="'.$product['id'].'">Премахни от любими</button></div>';
            }else{
            $favBtn='
            <div class="card-footer text-center">
            <button class="btn btn-primary btn-sm add-favorite" data-product="'.$product['id'].'">Добави в любими</button></div>';
        }
        }
        if(isAdmin()){
        $editDeleteButtons='
         <div class="card-header d-flex flex-row justify-content=between">
            <a href="?page=edit_product&id='.$product['id'].'" class="btn btn-warning btn-sm"> Редактирай</a>
            <form method="post" action="./handlers/handleDeleteProduct.php">
                <input type="hidden" name="id" value="'.$product['id'].'">
                <button type="submit"  class="btn btn-danger btn-sm">Изтрий</button>
            </form>
        </div>
        ';    
        }
        echo'
        <div class="card mb-4" style="width: 18rem;">
        '.$editDeleteButtons.'
        <img src="uploads/'.htmlspecialchars($product['image']).'" class="card-img-top" alt="Product Image">
        <div class="card-body">
            <h5 class="card-title">'.htmlspecialchars($product['title']).'</h5>
            <p class="card-text">'.htmlspecialchars($product['price']).'</p>

        </div>
        '.$favBtn.'
    </div>
        ';
    }
}else{
        echo '<div class="alert alert-warning" role="alert">
    Няма продукти
    </div>';
}
    ?>
</div>