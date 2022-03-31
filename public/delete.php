<?php
session_start();
require_once '../functions/functions.php';
require_once '../classes/article_class.php';
require_once '../classes/login_class.php';

//ログインしているか判定し、していなければ新規登録画面へ遷移
$login = new LoginClass('member');
$result = $login->checkLogin();
if(!$result){
    $_SESSION['login_err'] = 'ユーザ登録してログインして下さい';
    header('Location:register_form.php');
    return;
}

$login_user = $_SESSION['login_user'];

//記事IDから記事を削除する
$art = new Article('article');
$result = $art->delete($_GET['id_article']);


?>
