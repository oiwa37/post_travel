<?php
session_start();
require_once '../classes/login_class.php';

//ログイン状態であればマイページへ移動
$login = new LoginClass('member');
$result = $login->checkLogin();
if($result){
    header('Location:mypage.php');
    return;
}

$err = $_SESSION;

//配列を消す(エラーメッセージを一度のみ表示に)
$_SESSION = array();
//セッションファイルを消す
session_destroy();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>        
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="s.css" rel="stylesheet">
</head>
<body>
    <h2>ログインフォーム</h2>
        <?php if(isset($err['msg'])):?>
                <p><?php echo $err['msg'];?></p>
            <?php endif;?>
<form method="POST" action ="login.php">
    <p>
        <label for="email">メールアドレス:</label>
        <input type="email" name="email">
        <?php if(isset($err['email'])):?>
            <p><?php echo $err['email'];?></p>
        <?php endif;?>
    </p>
    <p>
        <label for="password">パスワード:</label>
        <input type="password" name="password">
        <?php if(isset($err['password'])):?>
            <p><?php echo $err['password'];?></p>
        <?php endif;?>
    </p>
    <p>
        <input type="submit" value="ログイン">
    </p>
</form>
<a href="register_form.php">新規登録はこちら</a>
<a href="top.php">戻る</a>
    
</body>
</html>