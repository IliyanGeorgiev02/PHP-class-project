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
$adminPages=['add_product','edit_product'];

if(!isAdmin() && in_array($page,$adminPages)){
    $_SESSION['flash']['message']['type']='warning';
    $_SESSION['flash']['message']['text']='нямате достъп до тази страница!';
    header('Location:index.php');
    exit;
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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
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
                                Swal.fire({
                                    toast:true,
                                    position:'top',
                                    title:'Успешно добавен в любими',
                                    icon:'success',
                                    width: 600,
                                    timer:7000,
                                    timerProgressBar:true,
                                    showConfirmButton:false,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    },
                                    padding: "3em",
                                    color: "#716add",
                                    backdrop: `
                                        rgba(0,0,123,0.4)
                                        url("/images/nyan-cat.gif")
                                        left top
                                        no-repeat
                                    `
                                    });
                            let removeBtn=$(`<button class="btn btn-danger btn-sm remove-favorite" data-product="${productId}">Премахни от любими</button>`);
                            btn.replaceWith(removeBtn);
                        }else{
                            Swal.fire({
                                    toast:true,
                                    position:'top',
                                    title:'Възникна грешка',
                                    icon:'error',
                                    width: 600,
                                    timer:7000,
                                    timerProgressBar:true,
                                    showConfirmButton:false,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    },
                                    padding: "3em",
                                    color: "#716add",
                                    backdrop: `
                                        rgba(0,0,123,0.4)
                                        url("/images/nyan-cat.gif")
                                        left top
                                        no-repeat
                                    `
                                    });
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
                            Swal.fire({
                                    toast:true,
                                    position:'top',
                                    title:'Продукта беше премахнат от любими.',
                                    icon:'success',
                                    width: 600,
                                    timer:7000,
                                    timerProgressBar:true,
                                    showConfirmButton:false,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    },
                                    padding: "3em",
                                    color: "#716add",
                                    backdrop: `
                                        rgba(0,0,123,0.4)
                                        url("/images/nyan-cat.gif")
                                        left top
                                        no-repeat
                                    `
                                    });
                            let addBtn=$(`<button class="btn btn-primary btn-sm add-favorite" data-product="${productId}">Добави в любими</button>`);
                            btn.replaceWith(addBtn);
                        }else{
                            Swal.fire({
                                    toast:true,
                                    position:'top',
                                    title:'Възникна грешка'+res.error,
                                    icon:'error',
                                    width: 600,
                                    timer:7000,
                                    timerProgressBar:true,
                                    showConfirmButton:false,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    },
                                    padding: "3em",
                                    color: "#716add",
                                    backdrop: `
                                        rgba(0,0,123,0.4)
                                        url("/images/nyan-cat.gif")
                                        left top
                                        no-repeat
                                    `
                                    });
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
                        <?php 
                        if(isAdmin()){
                            echo'<li class="nav-item">
                            <a class="nav-link '.($page=='add_product' ? 'active':'').'" href="?page=add_product">Добави продукт</a>
                        </li>';
                        }
                        ?>
                        
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
                $typeIcons=[
                'success'=>'success',
                'danger'=>'error',
                'warning'=>'warning'
                ];
                echo'<script>
                   Swal.fire({
                    toast:true,
                    position:\'top\',
                    title:\''.$flash['message']['text'].'\',
                    icon:\''.$typeIcons[$flash['message']['type']].'\',
                    width: 600,
                    timer:7000,
                    timerProgressBar:true,
                    showConfirmButton:false,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    },
                    padding: "3em",
                    color: "#716add",
                    backdrop: `
                        rgba(0,0,123,0.4)
                        url("/images/nyan-cat.gif")
                        left top
                        no-repeat
                    `
                    });
                </script>';
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