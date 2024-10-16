<?php
require_once('../functions.php');
$users = [
    [
        'email' => 'john@gmail.com',
        'password' => '123456',
        'name' => 'John Jones',
    ],
    [
        'email' => 'ana@gmail.com',
        'password' => 'qwerty',
        'name' => 'Ana Smith',
    ],
    [
        'email' => 'ivan@gmail.com',
        'password' => 'asd123',
        'name' => 'Ivan Ivanov',
    ],
];
debug($_POST);
foreach ($users as $user) {
    if ($user['email'] == $_POST['email'] && $user['password'] == $_POST['password']) {
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