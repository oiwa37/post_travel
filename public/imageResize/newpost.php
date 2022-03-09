<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

session_start();
require_once '../../functions/functions.php';
require_once '../../classes/article_class.php';
require_once '../../classes/login_class.php';

// ログインしているか判定し、していなければ新規登録画面へ
$login = new LoginClass('member');
$result = $login->checkLogin();
if(!$result){
    $_SESSION['login_err'] = 'ユーザ登録してログインして下さい';
    header('Location:../register_form.php');
    return;
}

//入力エラーがあればform.phpに戻る
$title = filter_input(INPUT_POST,'title');
$content = filter_input(INPUT_POST,'content');
if($title =="" || mb_strlen($title) > 30 || $content == "" || mb_strlen($content)>1000){
    header('Location:../form.php');
    return;
}



$article = $_POST; 
$image = $_FILES['image'];
$tmp_path = $image['tmp_name'];

$art = new Article('article');
// $art->articleValidate($article);



//ファイルが存在有無で分岐
if(file_exists($tmp_path)){
    $art->imageValidate($article,$image);
}else{
    $art->newpost($article);
}


?>

<p><a href ="../mypage.php">戻る</a></p>
