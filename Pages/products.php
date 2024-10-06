<?php
    // страница продукти
    $products = [
        [
            'image' => 'https://ardes.bg/uploads/original/dell-xps-13-plus-9320-393691.jpg',
            'title' => 'Dell XPS 13',
            'price' => '$999.99'
        ],
        [
            'image' => 'https://cdncloudcart.com/25880/products/images/28368/apple-macbook-air-m1-8gb-ddr4x-256gb-ssd-13-3-wqxga-gold-image_61a8cf36e50dc_600x600.jpeg?1638782461',
            'title' => 'Apple MacBook Air',
            'price' => '$1199.99'
        ],
        [
            'image' => 'https://img-cdn.tnwcdn.com/image?fit=1200%2C900&height=900&url=https%3A%2F%2Fcdn0.tnwcdn.com%2Fwp-content%2Fblogs.dir%2F1%2Ffiles%2F2021%2F08%2FHP-Spectre-x360-14-1-of-7.jpg&signature=0d2f21c8c102f0b5f8f935cee9d98ef6',
            'title' => 'HP Spectre x360',
            'price' => '$1099.99'
        ],
        [
            'image' => 'https://cdn.izotcomputers.com/8270-large_default/laptop-vtora-upotreba-lenovo-thinkpad-x1-carbon-gen-9.jpg',
            'title' => 'Lenovo ThinkPad X1 Carbon',
            'price' => '$1299.99'
        ],
        [
            'image' => 'https://laptop.bg/system/images/300015/normal/asus_zenbook_13_oled_ux325eaoledwb503r.jpg',
            'title' => 'Asus ZenBook 13',
            'price' => '$899.99'
        ],
        [
            'image' => 'https://gfx3.senetic.com/akeneo-catalog/7/1/b/9/71b955b8b0f63a78a44c1a6a845adbf09e281afc_1684023_LDH_00031_image1.jpg',
            'title' => 'Microsoft Surface Laptop 4',
            'price' => '$999.99'
        ],
        [
            'image' => 'https://ardes.bg/uploads/p/acer-swift-3-sf314-43-432825.jpg',
            'title' => 'Acer Swift 3',
            'price' => '$699.99'
        ],
        [
            'image' => 'https://ardes.bg/uploads/original/razer-blade-15-rz09-0421-428703.jpg',
            'title' => 'Razer Blade 15',
            'price' => '$1599.99'
        ]
    ];

    $search='';
    if(isset($_GET['search'])){
        $search = $_GET['search'];
        $products=array_filter($products,function($product) use ($search){
           return str_contains(mb_strtolower($product['title']),mb_strtolower($search));
        });   
    }
?>

<div class="row">
    <form class="mb-4" method="GET">
        <div class="input-group">
            <input type="hidden" name="page" value="products">
            <input type="text" class="form-control" placeholder="Търси продукт" name="search" value="<?php echo $_GET['search'] ?? ''?>">
            <button class="btn btn-primary" type="submit">Търсене</button>
        </div>
    </form>
</div>
<div class="d-flex flex-wrap justify-content-between">
    <?php
    if(count($products)>0){
    foreach ($products as $product) {
        echo'
        <div class="card mb-4" style="width: 18rem;">
        <img src="'.$product['image'].'" class="card-img-top" alt="Product Image">
        <div class="card-body">
            <h5 class="card-title">'.$product['title'].'</h5>
            <p class="card-text">'.$product['price'].'</p>
        </div>
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