<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

session_start(); 
require_once '../functions/functions.php';
require_once '../classes/login_class.php';


//トークンを受け取り、値が一致しているか確認
$token = filter_input(INPUT_POST,'csrf_token');
if(!isset($_SESSION['csrf_token'])||$token !==$_SESSION['csrf_token']){
    exit('不正なリクエストです');
}
//セッション削除
unset($_SESSION['csrf_token']);


//エラーメッセージ
$err = [];

//バリデーション
if(!$username = filter_input(INPUT_POST,'username')){
    $err['username'] = 'ユーザー名を入力して下さい。';
}
$email = filter_input(INPUT_POST,'email');
if(!preg_match('/\A[\w\-\._]+@[\w\-\._]+\.[A-Za-z]+\z/',$email)){
    $err['email'] = 'メールアドレスを正しく入力してください。';
}
$password = filter_input(INPUT_POST,'password');
if(!preg_match("/\A[a-z\d]{6,15}+\z/i",$password)){
    $err['pass'] = 'パスワードは英数字6文字以上15文字以下にして下さい。';
}
$password_conf = filter_input(INPUT_POST,'password_conf');
if($password !== $password_conf){
    $err['pass-conf'] = 'パスワードが一致しません。';
}

//エラーがあった場合＄_SESSION(連想配列)に＄errを入れてregister_form.phpに返す
if(count($err) > 0){
    $_SESSION = $err;
    header('Location:register_form.php');
    return;
}


$login = new LoginClass('member','prefecture');
//エラーがなければユーザ登録
if(count($err) === 0){
    $hasCreated = $login->createUser($_POST);
    
    if($hasCreated){
        //登録したメールアドレスから会員IDを取得し、県テーブルを追加
        $user = $login->getUserByEmail($email);
        $id_member = $user['id_member'];
        $prefCreated = $login->createPref($id_member);
        if(!$prefCreated){
            echo 'エラー';
    }elseif(!$hasCreated){
        $err[] = '登録に失敗しました。再度やり直して下さい。';
    }
}
}




?>

<!DOCTYPE html>
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
    <p>ユーザ登録が完了しました。</p> 
    <a class="login-button" href ="login_form.php">ログインしてマイページへ</a>
</div>
    <footer>
    <div class ="footer">
    <p>&copy; 2022 oiwa
            &nbsp;&nbsp; <a href ="../config/terms.php" class="footer-link">利用規約</a>
            &nbsp;&nbsp; <a href ="../config/privacy.php" class="footer-link">プライバシーポリシー</a>
            &nbsp;&nbsp; <a href ="../config/contact.php" class="footer-link">お問い合わせ</a>
            &nbsp;&nbsp; <a href ="../public/top.php" class="footer-link">トップページ</a></p>

    </div>
</footer> 

</body>
</html>
