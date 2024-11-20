<?php
// boilerplate index
require_once('./functions.php');
require_once('./db.php');
$page = $_GET['page'] ?? 'home';

$flash=[];
if(isset($_SESSION['flash'])){
    $flash=$_SESSION['flash'];
    unset($_SESSION['flash']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лаптопи</title>
    <!-- Bootstrap 5.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body>
    <script>
        $(function(){
            //adds to favs
            $(document).on('click', '.add-favorite',function(){
                let btn=$(this);
                let productId=$(this).data('product');


                $.ajax({
                    url:'./ajax/add_favorite.php',
                    method:'POST',
                    data:{
                        product_id:productId
                    },
                    success:function(response){
                        let res=JSON.parse(response);
                        console.log(res);
                        if(res.success){
                            alert('Продукта успешно добавен в любими');
                            let removeBtn=$(`<button class="btn btn-danger btn-sm remove-favorite" data-product="${productId}">Премахни от любими</button>`);
                            btn.replaceWith(removeBtn);
                        }else{
                            alert('Грешка! Продукта не е добавен в любими'+res.error);
                        }
                        
                    },error:function(error){
                        console.log(error);
                    }
                });
            });

            $(document).on('click', '.remove-favorite',function(){
                let btn=$(this);
                let productId=$(this).data('product');
                $.ajax({
                    url:'./ajax/remove_favorite.php',
                    method:'POST',
                    data:{
                        product_id:productId
                    },
                    success:function(response){
                        let res=JSON.parse(response);
                        if(res.success){
                            alert('Продукта успешно премахнат от любими');
                            let addBtn=$(`<button class="btn btn-primary btn-sm add-favorite" data-product="${productId}">Добави в любими</button>`);
                            btn.replaceWith(addBtn);
                        }else{
                            alert('Грешка! Продукта не е добавен в любими'+res.error);
                        }
                        
                    },error:function(error){
                        console.log(error);
                    }
                });
            });
        });
    </script>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="#">Лаптопи</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link <?php echo($page=='home' ? 'active':''); ?>" aria-current="page" href="?page=home">Начало</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo($page=='products' ? 'active':''); ?>" href="?page=products">Продукти</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo($page=='contacts' ? 'active':''); ?>" href="?page=contacts">Контакти</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo($page=='add_product' ? 'active':''); ?>" href="?page=add_product">Добави продукт</a>
                        </li>
                    </ul>
                    <div>
                        <?php 
                        if (isset($_SESSION['user_name'])) {
                            echo '<span class="text-white">Здравейте, ' .htmlspecialchars($_SESSION['user_name']) . '</span>';
                            echo '
                                <form method="POST" action="./Handlers/handleLogout.php" class="m-0">
                                    <button type="submit" class="btn btn-outline-light">Изход</button>
                                </form>
                            ';
                        } else {
                            echo '<a href="?page=login" class="btn btn-outline-light">Вход</a>';
                            echo '<a href="?page=register" class="btn btn-outline-light">Регистрирай</a>';
                        }                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main class="container py-4" style="min-height:80vh;">
        <?php
            if(isset($flash['message'])){
                echo'
                <div class="alert alert-'.$flash['message']['type'].'" role="alert">
                '.$flash['message']['text'].'
                </div>
                ';
            }
            if(file_exists('Pages/'.$page.'.php')) {
                require_once('./Pages/'.$page.'.php');
            }else{
                require_once('./Pages/notFound.php');
            }
        ?>
    </main>
    <footer class="bg-dark text-center py-5 mt-auto">
        <div class="container">
            <span class="text-light">© 2024 All rights reserved</span>
        </div>
    </footer>
</body>
</html>