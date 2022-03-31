<?php 
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );


session_start();
require_once '../functions/functions.php';
require_once '../classes/article_class.php';
require_once '../classes/login_class.php';
require_once '../classes/prefecture_class.php';


//ログインしているか判定し、していなければ新規登録画面へ遷移
$login = new LoginClass('member');
$result = $login->checkLogin();
if(!$result){
    $_SESSION['login_err'] = 'ユーザ登録してログインして下さい';
    header('Location:register_form.php');
    return;
}
$login_user = $_SESSION['login_user']; //ユーザ情報を格納
$id_member = $login_user['id_member']; //ユーザID


$art = new Article('prefecture');
$pref_color = $_POST['pref_color']; //色コード
$pref_name =  $_POST['pref_name']; //県名

$pref_class = new Prefecture('prefecture');
$pref_class->prefColor($id_member,$pref_name,$pref_color);


?>

