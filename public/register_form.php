<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

session_start();
require_once '../functions/functions.php';
require_once '../classes/login_class.php';

//ログイン状態であればマイページへ移動
$login = new LoginClass('member');
$result = $login->checkLogin();
if($result){
    header('Location:mypage.php');
    return;
}



$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録画面</title>
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="s.css" rel="stylesheet">
</head>
<body>
    <h2>新規登録フォーム</h2>
    <?php if(isset($login_err)):?>
                <p><?php echo $login_err;?></p>
            <?php endif;?>
    <form method="POST" action ="register_done.php">
    <p>
        <label for="username">ユーザ名:</label>
        <input type="text" name="username">
    </p>
    <p>
        <label for="email">メールアドレス:</label>
        <input type="email" name="email">
    </p>
    <p>
        <label for="password">パスワード:</label>
        <input type="password" name="password">
    </p>
    <p>
        <label for="password_conf">パスワード確認:</label>
        <input type="password" name="password_conf">
    </p>
    <input type="hidden" name="csrf_token" value=<?php echo h(setToken());?>> 
    <p>
        <input type="submit" value="新規登録">
    </p>
</form>
    <a href="login_form.php">ログインする</a>
<a href="top.php">戻る</a>

</body>
</html>