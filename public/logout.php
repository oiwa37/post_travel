<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

session_start();
require_once '../classes/login_class.php';

if(!$logout = filter_input(INPUT_POST,'logout')){
    exit('不正なリクエストです。');
}

//ログインしているか判定し、セッションが切れていたらログインし直してもらう
$login = new LoginClass('member');
$result = $login->checkLogin();
if(!$result){
    exit('セッションが切れましたのでログインし直して下さい。');
}
//ログアウトする
LoginClass::logout();



?>



<!DOCTYPE HTML PUBLIC"=//W3C//DTD HTML 4.01 Transitional//EN>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>ログアウト</title>
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
        <link href="s.css" rel="stylesheet">
    </head>
<body>   
    <h2>ログアウト</h2> 
    <p>ログアウト完了</p>
    <a href ="login_form.php">ログイン画面へ</a>

</body>
</html>
