<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

session_start();
require_once '../classes/login_class.php';

//$_POSTに値が入っているかチェック
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
//ログアウトしたら、トップ画面へ遷移
LoginClass::logout();
header('Location:top.php');


?>
