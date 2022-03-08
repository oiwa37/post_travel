<?php
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

<div class= "register-form">
    <h2>新規登録</h2>
        <?php if(isset($login_err)):?>
                    <p><?php echo $login_err;?></p>
                <?php endif;?>
    <form method="POST" action ="register_done.php">
        <p>
            <label for="username">ユーザ名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
            <input type="text" name="username" class="form" placeholder="Username">
        </p>
        <p>
            <label for="email">メールアドレス:</label>
            <input type="email" name="email" class="form" placeholder="Email">
        </p>
        <p>
            <label for="password">パスワード&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
            <input type="password" name="password" class="form" placeholder="Password">
        </p>
        <p>
            <label for="password_conf">パスワード確認:</label>
            <input type="password" name="password_conf" class="form" placeholder="Password">
        </p>
        <input type="hidden" name="csrf_token" value=<?php echo h(setToken());?>> 
        <input type="submit" value="新規登録" class ="register-button2">    
    </form>
    <a href="login_form.php" class="login-button">ログインはこちら</a>
</div>

<footer>
    <div class ="footer">
        <p>&copy; 2022 oiwa</p>
    </div>
</footer> 

</body>
</html>