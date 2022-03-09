<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

session_start();
require_once '../classes/login_class.php';

if(!$logout = filter_input(INPUT_POST,'logout')){
    echo '<p>不正なリクエストです。もう一度やり直して下さい。<p>';
    echo '<a class="top-button" href="top.php">トップへ戻る</a>';
    exit;
}

//ログインしているか判定し、セッションが切れていたらログインし直してもらう
$login = new LoginClass('member');
$result = $login->checkLogin();
if(!$result){
    exit('セッションが切れましたのでログインし直して下さい。');
}
//ログアウトしたら、トップ画面へ移動させる
LoginClass::logout();
header('Location:top.php');

?>


<!DOCTYPE HTML PUBLIC"=//W3C//DTD HTML 4.01 Transitional//EN>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>旅の思い出</title>
        <!-- リセットCSS -->
        <link href="https://unpkg.com/ress/dist/ress.min.css" rel="stylesheet">
        <!-- fontawesome -->
        <link href="https://use.fontawesome.com/releases/v6.0.0/css/all.css" rel="stylesheet">
        <!-- google fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kaisei+Decol:wght@700&family=Kiwi+Maru:wght@300&family=Klee+One&display=swap" rel="stylesheet">
        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- css -->
        <link href="login.css" rel="stylesheet">
    </head>
<body>

<header>
    <div class ="header"> 
        <div class ="header-left">
            <a href ="top.php"><h1>旅の思い出</h1></a>
            <p>日本地図に色を塗ろう</p>
        </div>  
        <nav class ="gnav">
            <ol class="menu">
                <li><a href ="register_form.php">新規登録</a> </li>
                <li><a href ="login_form.php">ログイン</a> </li>
                <li><a href ="#">ゲストログイン</a></li>
            </ol>
        </nav> 
    </div>
</header>
<div class ="register-done">
    <p>ログアウトしました。</p> <br>
    <a class="login-button" href ="login_form.php">ログイン</a>
    <a class="top-button" href ="top.php">トップへ</a>
</div>
    <footer>
    <div class ="footer">
        <p>&copy; 2022 oiwa</p>
    </div>
</footer> 

</body>
</html>
