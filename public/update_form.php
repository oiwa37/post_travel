<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

session_start();
require_once '../functions/functions.php';
require_once '../classes/article_class.php';
require_once '../classes/login_class.php';

//ログインしているか判定し、していなければ新規登録画面へ
$login = new LoginClass('member');
$result = $login->checkLogin();
if(!$result){
    $_SESSION['login_err'] = 'ユーザ登録してログインして下さい';
    header('Location:register_form.php');
    return;
}
$login_user = $_SESSION['login_user'];


$art = new Article('article');
$result = $art->getById($_GET['id_article']);

$id_article = $result['id_article'];
$title = $result['title'];
$prefecture = $result['prefecture'];
$content= $result['content'];
$post_status= (int)$result['post_status'];
$image = $result['image'];

//画像のパスを指定
$imageURL ='/post_travel/public/imageResize/'.'new'.$image;
$noImage ='/post_travel/japan.png';

if(isset($image)){
    $currentImage = $imageURL;
}else{
    $currentImage = $noImage;
}



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
        <!-- css -->
        <link href="s.css" rel="stylesheet">
        <!-- javascript -->
        <script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js?ver=1.11.3'></script>
    </head>
<body>
<header>
    <div class ="header">      
        <div class ="header-left">
            <a href ="#"><h1>旅の思い出</h1></a>
            <p>日本地図に色を塗ろう</p>
        </div>  
        <nav class ="gnav">
            <ol class="menu">
                <li><a href ="form.php">新規作成</a></li>
                <li><a href ="mypage.php">自分の投稿</a> </li>
                <li><a href ="allpost.php">みんなの投稿</a> </li>
                <li><a href ="pictures.php">写真の投稿</a> </li>
            </ol>
        </nav>
        <div class ="header-right">
            <div class="user-info">
                <p>ログインユーザ:<?php echo h($login_user['name'])?></p>
                <p>メールアドレス:<?php echo h($login_user['email'])?></p>
            </div>  
            <div class ="logout">
                <form method ="POST" action ="logout.php">
                    <input type ="submit" name ="logout" value =" &#xf08b;" class="logout-btn">
                </form>
            </div>
        </div>
    </div>  
</header>



<div class ="content clearfix" >
    <div class = "map">
        <div class ="japan">
            <svg id="map" data-name="japan" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 773.6 846.4">
                <path class="cls-1" data-name ="hokkaido" d="M653.6,2.6,634.1,18.3l7.4,40.9-9.1,16.6L631,101.2l-13.5,8.6,2.3,29.3-14.4,8-29-16.2-8,8.5,9.4,14-32.7,20.8-1.6,22.3,14.6,23.7-10.1,16,6.9,13.8,25.8-21.8,11.4,6.1,11.9-6.7-21.6-22.2-8.7,3.9L562.9,195,575,178.1l12.6,4.1,7.7,16.5L627.8,180,689,229l25.7-46.8L744,167.3l30.8,5.6,25.7-12.7-13-11.8-5-25.9L796.9,103l-1.7-9.6-26.8,19.3-24.1-8.1L689.8,64.9,672.7,28.3Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="aomori" d="M617.5,314l-9.8-13.4,5.8-47.1-23.4-8.3-7.9,15.2,17.9,8.2-3.7,15.8-19.8-.8-3.8-19.9-11.5-4.2-5.4,24.6-14.1,5.8-1,17.1,37.4,40Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="iwate" d="M572.7,397.2l-5.1-28.5,7.8-12.2,6.4-32.7,35.7-9.9L630,356.5l-17.5,43.3L585.1,417Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="akita" d="M540.9,306.9l.4,17.2-9.1,9.7L543,347.7,533.7,383l48,44,.1-103.3.4-14.7Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="yamagata" d="M515.4,413.7l6.3,43.1L554.4,483l8.1-80.2L533.6,383Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="miyagi" d="M575.2,460.2l1.3-20.5,11.4-9.1,14.5,3.6.5-21,9.6-13.3-8-3.3L591.8,406l-19.2-8.8-10.1,5.7-16.2,48.9,12.2,16.4Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="fukushima" d="M495.7,505l1.9-26.5,15.1-4.8,9-16.9,21.9,6.6,2.8-11.7,28.9,8.5-1,48.8-10.1,8.5-45.7,13.2Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="niigata" d="M515.4,413.7l-10.1,28.9-25,12.7-13,25.2-40.9,17.2-2.2,13.8,54.4,14.9,17-21.5L516.8,486l4.8-29.3,3.6-22.8Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="ishikawa" d="M390.5,533.3l6.3-34.1,4.5-4.5,2-16.1,8-2.2,3.9-10.8L386,473.2l-1,31.2-22.4,26.8L383,545.7Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="toyama" d="M390.5,533.3l-4.4-9.5,6.1-20.1,4.5-4.5,5.4,9.7,11.1.7,2.4-9.2,10.7-2.6,4.9,11.3-8.8,22.3-17.5-6Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="ibaraki" d="M564,517.6l-23.2-8.5-30,41.2,9.6,12.5,15,18.8,24.6-1.4-9.3-31.6Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="tochigi" d="M502.7,509,524,496.9l16.8,12.3-5.6,30.4-24.4,10.8L499,522.3Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="gunma" d="M468.2,557.4l-1.8-24.1-9-3.6,3.5-10.4,20-8.1,7.7-10.2,14.2,7.9,8.1,41.3-21.3-6.1Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="chiba" d="M520.9,580.7l7.7,4.1-12,11.4L513.2,620l6.8,1.4,19.2-14.3,4.1-18.8,16.8-8.2-12.7-13.4-15.3,4.2-11.6-8.1-1.5,9.7Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="saitama" d="M520.5,562.8l-5-22.4-31-6.2L459.6,556l13.2,17.4,54.4,6.2Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="tokyo" d="M487.3,578.8l-12.5-1.7,3.5-10.1,40.7,5.6,7.3,3-5.4,5.2-6.3,5.1-13.8-1.6Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="kanagawa" d="M484.4,606.4,469.1,601l4.6-24,13.5,1.8,16.1-2.3,11.2,9.3-6.2,18.4-11.9-7.5-9.4,1.8Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="yamanashi" d="M468.2,557.4l-32.2-.5,9.3,49.1,31.9-16.4,10.1-10.9-9-11.8Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-4" data-name ="shizuoka" d="M453.9,596.9l-6.2,7.6,11,2.4,10.7-1.9,3.1,6.1-5.7,3.2-1.3,17.1,7.6,3.2,11.8-14.9-.5-13.3-6.7-5.8-.5-10.9-15.5-.9Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-4" data-name ="shizuoka" d="M444.7,582l-17.2,15.5-23.3,13.1,6.5,14.9,29.6,7,14.9-19.2,3.4-6.5-4.8-10Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="nagano" d="M431.3,509.1l-12.2,6.2L400.3,563l12.1,42.5,28.9-4.8,3.3-18.7,2.2-18.5,21.3-6.1L478,534l-7.1-18.7-6.5-15.2Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="aichi" d="M410.7,625.4l-15.2,3.5,1.2-7.9-8.6-3.8-4.5,1.1L380,604.5l-3.6-8.6,1.9-20.2,22.5-.9,14.9,19,11.8,3.6-16.2,20Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="gifu" d="M359.3,568.3l8.3-7.1,16.9-2.9-1.4-12.5-.8-18.3,22.9-10,17.3,14-2.9,21.7L411,562l7.5,21.9-2.6,10-19.3-1.8-4.4-9.3-10,1.6-5.7,11.7L368,593l1.3-15.1Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="mie" d="M335.6,661.4l3.1-32.3,14.7-33.3L368,593l18.5-4L380,604.7l-11.7,15.8,15.5,15.9-3.4,9.1-8.9-2.7-16.3,9.5.3,7.6L342.3,673Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="fukui" d="M319.5,570.6l6.9-3,6.2,4.9,21-10.6-4.4-14.5,13.4-16.1,31.2,10.9-4.5,22.3-30,3.9-18.1,13.9L328.7,580Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="nara" d="M329,633.6l-3.2-11L338,605.3l10,13.1-1,34.5-11.4,8.4-12.2-11.2,6.9-7.7Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="wakayama" d="M304,638.7l-.5,20.6,11.6,19.4,16.6,7,10.6-12.8-10.6-46.7Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="osaka" d="M333.3,614.7V596.4L314,598.1l4.9,19.2-.7,7.9L304,638.7l25-5.1Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="shiga" d="M348,618.5l-13.3-20.4,6.5-15.9L360,557.6l21.8,16L368,593l-5.2,16.5-8.9.3Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="kyoto" d="M348,618.5l-14.7-3.8-3.2-10.9-9,2.1L299,589.4l2.6-27.2,14.5-5.7,5.1,4.8-4.9,6.1,3.2,3.2,21.7,11.7.4,17Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="hyogo" d="M318.9,617.2l-15.6,2.3-13.4-9.6L273.8,611l-10.1-11.8,16.7-37.5,21.3.5,3.1,18.7L319.5,593l1.8,12.8Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="tottori" d="M277.1,585l-13.7,5.8-36.9,6.9-4.7-11.2L219.1,573l14.4-4.9,10.5-4.6,20.4,3.4,16-5.2,3.7,21Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="okayama" d="M277.3,584.9l-10.8.1-6.4-7.9L244.8,576l-14.2,12.9-8.3,17.4L232.9,621l11.7-1.6,11.2,5.5L273.7,611l-4.1-10.6Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="shimane" d="M233.5,568.1l-13.4-6.8-17.2,4.4-2,7.4-35.4,29-7.6,2.8-7.3,17.5,14.9,10.3,39.7-22.6,16.7-23.8Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="hiroshima" d="M230.7,588.9l-8.9-2.5-11.9-1-9.2,13.4-18.3,1.7-7.3,19-2.3,9.1,6.6,3.7,11.6-8.2,5.8,9.4,36.1-12.4Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="yamaguchi" d="M175.1,619.5l-12.3,6.6-5.6-10.2.6-10.8L142,617.9l-20.7.5,1.4,23.4,34.3-2.4,19.1,9.8,3.3-16.9Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="kagawa" d="M263.6,628.2l-24.5,6.2.7,13.5,22.5,1.7,13.8-9.4Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="tokushima" d="M276.2,640.3,283,642l2,19.1L267.7,676l-19-6.7-14.4-8.9,5.5-12.4Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="ehime" d="M239.8,648l-22.5,1.8-7-8.6L199,649l-2.7,10.9-15.1,10.9,6.1,31.8,6.2,1.6L239,655.4Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="kochi" d="M193.6,704.1l-.7,6.9,13.3-.6,16.1-30,20.6-7.4,16.2,17,8.6-14.1L239.1,655l-19.2,3.2-12.1,15.5Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="fukuoka" d="M102.6,643.1,84.1,662.9l9.5,19.7,3.6,7.9,21.5,3.5L132,660.8l-9.4-19Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="oita" d="M132.1,660.7l8.6,3.3,9.1-6,7,11.2-10.5,11.5,12.7,1.9,5.3,20-6.7,5.7-29,2.5-13.3-26,4-17.5Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="kumamoto" d="M97.2,690.4l6.3,20.7L90.6,735l4.9,9.9,32.7.4,4.5-43.5L127,687.6l-11.8-2.7Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="miyazaki" d="M132.6,701.9l-13.8,15.4,3.4,19.6-16.1,3.7-1.2,22,15.2,11.5,9.3,5.1,20-60.1,7.9-10.6Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="kagoshima" d="M106.2,740.5l-15.6-5.4-10.1,2.6-1.3,17.7,6.6,10.5-7.7,9.8,1.8,7.1,13.7,5.1,2.9-4.5L93,773.1l6.1-6,6.6,16.6-6.6,9-.5,4.5,19.1-9.9-2-9.7,4.5-3.5Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="saga" d="M93.6,682.5l-9.6.9,1.1,8.3-13.9,1.9L68,669.9l5.9-10.8,10.3,3.7,16.5,5.5Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="nagasaki" d="M85.1,691.8l7.3,9.3-2.1,8.1-7.7,1.3-1.4-10.3-9.7,5.3-6.3-20.7-9.1-11,4.2-5.3L68,670l8.4,17.4Z" transform="translate(-27.4 -2.1)"/>
                <path class="cls-1" data-name ="okinawa" d="M61.3,806.3l-11.2,9L39.8,812l-3.1,5.4,3.5,6-7.8,6.3L27.9,848l10.6-.3,5.3-17.1,22.4-12.8Z" transform="translate(-27.4 -2.1)"/>
            </svg>  
        </div>
    </div>





    <div class="content-update">
        <h2>投稿の更新</h2>
        <div class="update-form">
            <form action="./imageResize/update.php" method="POST" enctype="multipart/form-data">
            <input type ="hidden" name ="id_article" value="<?php echo $id_article; ?>">
            <img src="<?php echo $currentImage; ?>" alt="" class="current-img"/>
            <p>タイトル<div class="err_text" id="err_textbox"></div></p>
            <p><input type ="text" name="title" class="up-title" id="textbox" value="<?php echo $title; ?>"></p>
            <p>県を選ぶ</p>
                <!-- ドロップダウンリスト -->
                <select name="prefecture" class="select-pref">
                <option value="北海道" <?php if($prefecture === "北海道") echo "selected"; ?>>北海道</option>
                <option value="青森県" <?php if($prefecture === "青森県") echo "selected"; ?>>青森県</option>
                <option value="岩手県" <?php if($prefecture === "岩手県") echo "selected"; ?>>岩手県</option>
                <option value="宮城県" <?php if($prefecture === "宮城県") echo "selected"; ?>>宮城県</option>';
                <option value="秋田県" <?php if($prefecture === "秋田県") echo "selected"; ?>>秋田県</option>
                <option value="山形県" <?php if($prefecture === "山形県") echo "selected"; ?>>山形県</option>
                <option value="福島県" <?php if($prefecture === "福島県") echo "selected"; ?>>福島県</option>
                <option value="茨城県" <?php if($prefecture === "茨城県") echo "selected"; ?>>茨城県</option>
                <option value="栃木県" <?php if($prefecture === "栃木県") echo "selected"; ?>>栃木県</option>
                <option value="群馬県" <?php if($prefecture === "群馬県") echo "selected"; ?>>群馬県</option>
                <option value="埼玉県" <?php if($prefecture === "埼玉県") echo "selected"; ?>>埼玉県</option>
                <option value="千葉県" <?php if($prefecture === "千葉県") echo "selected"; ?>>千葉県</option>
                <option value="東京都" <?php if($prefecture === "東京県") echo "selected"; ?>>東京都</option>
                <option value="神奈川県" <?php if($prefecture === "神奈川県") echo "selected"; ?>>神奈川県</option>
                <option value="新潟県" <?php if($prefecture === "新潟県") echo "selected"; ?>>新潟県</option>
                <option value="富山県" <?php if($prefecture === "富山県") echo "selected"; ?>>富山県</option>
                <option value="石川県" <?php if($prefecture === "石川県") echo "selected"; ?>>石川県</option>
                <option value="福井県" <?php if($prefecture === "福井県") echo "selected"; ?>>福井県</option>
                <option value="山梨県" <?php if($prefecture === "山梨県") echo "selected"; ?>>山梨県</option>
                <option value="長野県" <?php if($prefecture === "長野県") echo "selected"; ?>>長野県</option>
                <option value="岐阜県" <?php if($prefecture === "岐阜県") echo "selected"; ?>>岐阜県</option>
                <option value="静岡県" <?php if($prefecture === "静岡県") echo "selected"; ?>>静岡県</option>
                <option value="愛知県" <?php if($prefecture === "愛知県") echo "selected"; ?>>愛知県</option>
                <option value="三重県" <?php if($prefecture === "三重県") echo "selected"; ?>>三重県</option>
                <option value="滋賀県" <?php if($prefecture === "滋賀県") echo "selected"; ?>>滋賀県</option>
                <option value="京都府" <?php if($prefecture === "京都県") echo "selected"; ?>>京都府</option>
                <option value="大阪府" <?php if($prefecture === "大阪県") echo "selected"; ?>>大阪府</option>
                <option value="兵庫県" <?php if($prefecture === "兵庫県") echo "selected"; ?>>兵庫県</option>
                <option value="奈良県" <?php if($prefecture === "奈良県") echo "selected"; ?>>奈良県</option>
                <option value="和歌山県" <?php if($prefecture === "和歌山県") echo "selected"; ?>>和歌山県</option>
                <option value="鳥取県" <?php if($prefecture === "鳥取県") echo "selected"; ?>>鳥取県</option>
                <option value="島根県" <?php if($prefecture === "島根県") echo "selected"; ?>>島根県</option>
                <option value="岡山県" <?php if($prefecture === "岡山県") echo "selected"; ?>>岡山県</option>
                <option value="広島県" <?php if($prefecture === "広島県") echo "selected"; ?>>広島県</option>
                <option value="山口県" <?php if($prefecture === "山口県") echo "selected"; ?>>山口県</option>
                <option value="徳島県" <?php if($prefecture === "徳島県") echo "selected"; ?>>徳島県</option>
                <option value="香川県" <?php if($prefecture === "香川県") echo "selected"; ?>>香川県</option>
                <option value="愛媛県" <?php if($prefecture === "愛媛県") echo "selected"; ?>>愛媛県</option>
                <option value="高知県" <?php if($prefecture === "高知県") echo "selected"; ?>>高知県</option>
                <option value="福岡県" <?php if($prefecture === "福岡県") echo "selected"; ?>>福岡県</option>
                <option value="佐賀県" <?php if($prefecture === "佐賀県") echo "selected"; ?>>佐賀県</option>
                <option value="長崎県" <?php if($prefecture === "長崎県") echo "selected"; ?>>長崎県</option>
                <option value="熊本県" <?php if($prefecture === "熊本県") echo "selected"; ?>>熊本県</option>
                <option value="大分県" <?php if($prefecture === "大分県") echo "selected"; ?>>大分県</option>
                <option value="宮崎県" <?php if($prefecture === "宮崎県") echo "selected"; ?>>宮崎県</option>
                <option value="鹿児島県" <?php if($prefecture === "鹿児島県") echo "selected"; ?>>鹿児島県</option>
                <option value="沖縄県" <?php if($prefecture === "沖縄県") echo "selected"; ?>>沖縄県</option>
                </select>
            <p>本文<div class="err_text" id="err_textarea"></div></p>
            <p><textarea name="content"  cols=90" rows="8" class="blog-text" id="textarea"><?php echo $content; ?></textarea></p>
            <!-- <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> -->
            <p><input name="image" type="file" accept="image/*"></p>
            <p><input type="radio" name="post_status" value="1"
            <?php if($post_status === 1) echo "checked";?>>公開
            <input type="radio" name="post_status" value="2"
            <?php if($post_status === 2) echo "checked";?>>非公開
            <input type="submit" value="この内容で更新する" class="post-button"></p>
        </form>
        </div>
        <div class="del-image">
        <form method ="POST" action ="deleteImage.php">   
            <input type ="hidden" name ="id_article" value="<?php echo $id_article; ?>">
            <input type="hidden" name="deleteImage" value="<?php echo $image; ?>">
            <input type ="submit" name ="delete" value ="画像のみ削除する" class="del-img-btn">
        </form>
        </div>
    </div>  
</div>
    

    <footer>
  <div class ="footer">
    <p>&copy; 2022 oiwa</p>
  </div>
</footer>


<script>
$(function(){
	$("#textbox").bind("blur", function() {
		var _textbox = $(this).val();
		check_textbox(_textbox);
	});
});

function check_textbox(str){
	$("#err_textbox p").remove();
	var _result = true;
	var _textbox = $.trim(str);

	if(_textbox.match(/^[  \r\n\t]*$/)){
		$("#err_textbox").append("<p><i class=\"fa fa-exclamation-triangle\"></i>タイトルを入力してください。</p>");
		_result = false;
	}else if(_textbox.length > 30){
		$("#err_textbox").append("<p><i class=\"fa fa-exclamation-triangle\"></i>タイトルは30文字以内で入力してください。</p>");
		_result = false;
	}
	return _result;
}


$(function(){
	$("#textarea").bind("blur", function() {
	var _textarea = $(this).val();
		check_textarea(_textarea);
	});
});

function check_textarea(str){
	$("#err_textarea p").remove();
	var _result = true;
	var _textarea = $.trim(str);

	if(_textarea.length == 0){
		$("#err_textarea").append("<p><i class=\"fa fa-exclamation-triangle\"></i>本文を入力してください。</p>");
		_result = false;
	}else if(_textarea.length > 1000){
		$("#err_textarea").append("<p><i class=\"fa fa-exclamation-triangle\"></i>本文は1000文字以内で入力してください。</p>");
		_result = false;
	}
	return _result;
}

</script>

</body>
</html>
