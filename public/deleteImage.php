<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

session_start();
require_once '../classes/article_class.php';
require_once '../config/dbconnect.php';


//ログインしているか判定し、セッションが切れていたらログインし直してもらう
// $login = new LoginClass('member');
// $result = $login->checkLogin();
// if(!$result){
//     exit('セッションが切れましたのでログインし直して下さい。');
// }


$del_image = $_POST['deleteImage'];
//元画像
$file_dir = '/Applications/MAMP/htdocs/post_travel/images/';
$deleteImage = $file_dir.$del_image; 
//リサイズ後の画像
$refile_dir = '/Applications/MAMP/htdocs/post_travel/public/newpost/';
$deleteReImage = $refile_dir.'new'.$del_image;

//DBに保存されている画像を削除する
$del = new Article('article');
$result = $del->deleteimage($del_image);

?>



<!DOCTYPE HTML PUBLIC"=//W3C//DTD HTML 4.01 Transitional//EN>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>画像削除</title>
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
        <link href="s.css" rel="stylesheet">
    </head>
<body>  

    <?php if(!empty($del_image)){ ?>
    <?php unlink($deleteImage); ?>
    <?php unlink($deleteReImage); ?>
    <?php echo '画像削除しました!';?>
    <?php }else{ ?>
    <?php echo '削除する画像がありません';} ?>

    <a href ="login_form.php">ホームへ</a>

</body>
</html>
