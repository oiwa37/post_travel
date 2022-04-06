<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

session_start();
require_once '../classes/article_class.php';
require_once '../config/dbconnect.php';


$del_image = $_POST['deleteImage'];
$file_dir = '/home/xs115618/oiwa1105.com/public_html/post_travel/images/';
$deleteImage = $file_dir.$del_image; //元画像
$refile_dir = '/home/xs115618/oiwa1105.com/public_html/post_travel/public/imageResize/';
$deleteReImage = $refile_dir.'new'.$del_image; //リサイズ後の画像

//DBに保存されている画像を削除する
$del = new Article('article');
$result = $del->deleteimage($del_image);

?>


<!DOCTYPE html>
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
    <?php header('Location:./mypage.php');?>
    <?php }else{ ?>
    <?php header('Location:./mypage.php');} ?>

    <a href ="login_form.php">ホームへ</a>

</body>
</html>
