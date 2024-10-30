<?php
require_once('../functions.php');
$users = [
    [
        'email' => 'john@gmail.com',
        'password' => '123456',
        'name' => 'John Jones',
        'hash'=> '$argon2i$v=19$m=65536,t=4,p=1$YUlNYXMyMFlSdEl6anhULw$LKeAEL5vsaBlwKXpsfaoU7iOlEPpawtXpnd4RTHRsnE',
    ],
    [
        'email' => 'ana@gmail.com',
        'password' => 'qwerty',
        'name' => 'Ana Smith',
        'hash'=> '$argon2i$v=19$m=65536,t=4,p=1$MzY3QzhsV1NFeEg5NElLUw$m3QTqMAVhqfnUeH5mOdF86VNQuePy4kBYs684SlCPB8',
    ],
    [
        'email' => 'ivan@gmail.com',
        'password' => 'asd123',
        'name' => 'Ivan Ivanov',
        'hash'=> '$argon2i$v=19$m=65536,t=4,p=1$VWcwQy4waVhkOC84eGU4aQ$PnQGAK6bXVFqXZyAbJJTx5pSx78CkGI2f7yB6JOysK4',
    ],
];
foreach ($users as $user) {
    if ($user['email'] == $_POST['email'] && password_verify($_POST['password'],$user['hash'])) {
        session_start();
        $_SESSION['user_email']= $user['email'];
        $_SESSION['user_name']= $user['name'];
        setcookie('user_email', $user['email'], time()+3600,'/','localhost',false,true);
}else{
   // debug('fail',true);  
}
}
header('Location: ../index.php?page=home');
exit;

?>