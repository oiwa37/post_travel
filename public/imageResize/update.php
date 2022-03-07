<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

session_start();
require_once '../../functions.php';
require_once '../../classes/article_class.php';
require_once '../../classes/login_class.php';

//ログインしているか判定し、していなければ新規登録画面へ
$login = new LoginClass('member');
$result = $login->checkLogin();
if(!$result){
    $_SESSION['login_err'] = 'ユーザ登録してログインして下さい';
    header('Location:register_form.php');
    return;
}
$login_user = $_SESSION['login_user'];


$article = $_POST;
$image = $_FILES['image'];
$tmp_path = $image['tmp_name'];


$art = new Article('article');
$art->articleValidate($article);



//画像アップデートの際に既存データ・リサイズデータ削除
$del_image = $_POST['deleteImage'];
$file_dir = '/Applications/MAMP/htdocs/post_travel/images/';
$deleteImage = $file_dir.$del_image; 
$refile_dir = '/Applications/MAMP/htdocs/post_travel/public/imageResize/';
$deleteReImage = $refile_dir.'new'.$del_image;


//サーバ・DBに保存されている画像を削除する（NULLに更新）
//新しい画像がある AND 既存データがある
if(file_exists($tmp_path) && !empty($del_image)){ 
    unlink($deleteImage);
    unlink($deleteReImage);
    $result = $art->deleteimage($del_image);
}
//ファイルが存在有無で分岐
if(file_exists($tmp_path)){ 
    $art->imageUpdate($article,$image);
}else{
$art->updatePost($article);
}


?>
<p><a href ="../mypage.php">戻る</a></p>
