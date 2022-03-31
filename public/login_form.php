<?php
session_start();
require_once '../classes/login_class.php';

//ログイン状態であればマイページへ遷移
$login = new LoginClass('member');
$result = $login->checkLogin();
if($result){
    header('Location:mypage.php');
    return;
}

$err = $_SESSION;

//配列を消す(エラーメッセージを一度のみ表示にするため)
$_SESSION = array();
//セッションファイルを削除
session_destroy();

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
                <li>           
                <form method="POST" action ="login.php">
                <input type ="hidden" name="email" value="guest@guest.com">
                <input type ="hidden" name="password"  value="111111">
                <input type ="submit" name ="top_login" value ="ゲストログイン" class="top-login">
            </form></li>
            </ol>
        </nav> 
    </div>
</header>



<div class ="login-form">
    <h2>ログイン</h2>
    <?php if(isset($err['msg'])):?>
    <p class="err-msg"><?php echo $err['msg'];?></p>
    <?php endif;?>
    <form method="POST" action ="login.php">
        <p>
            <label for="email"></label>
            <input type="email" name="email" class="form" placeholder="Email">
            <?php if(isset($err['email'])):?>
                <p class="err-msg"><?php echo $err['email'];?></p>
            <?php endif;?>
        </p>
        <p>
            <label for="password"></label>
            <input type="password" name="password" class ="form" placeholder="Password">
            <?php if(isset($err['password'])):?>
                <p class="err-msg"><?php echo $err['password'];?></p>
            <?php endif;?>
        </p>
        <p>
            <input type="submit" value="ログイン" class="login-button">
        </p>
        <a class ="register-button" href="register_form.php">新規登録はこちら</a>
    </form>
</div>


<footer>
    <div class ="footer">
        <p>&copy; 2022 oiwa
            &nbsp;&nbsp; <a href ="../config/terms.php" class="footer-link">利用規約</a>
            &nbsp;&nbsp; <a href ="../config/privacy.php" class="footer-link">プライバシーポリシー</a>
            &nbsp;&nbsp; <a href ="http://oiwa1105.com/script/mailform/contact/" class="footer-link">お問い合わせ</a></p>
    </div>
</footer> 

</body>
</html>