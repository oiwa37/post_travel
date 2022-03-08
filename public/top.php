<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

session_start();
require_once '../functions/functions.php';
require_once '../classes/article_class.php';
require_once '../classes/login_class.php';


//ログインしているか判定し、していればマイページへ
// $login = new LoginClass('member');
// $result = $login->checkLogin();
// if(!$result){
//   $_SESSION['login_err'] = 'ユーザ登録してログインして下さい';
//   header('Location:register_form.php');
//   return;
// }

$art = new Article('article','member');
$articleData = $art->getAll();
$imageURL = '/post_travel/images/';


// $login_user = $_SESSION['login_user'];

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
        <link href="top.css" rel="stylesheet">
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
        <li><a href ="register_form.php">新規登録</a> </li>
        <li><a href ="login_form.php">ログイン</a> </li>
        <li><a href ="#">ゲストログイン</a></li>
      </ol>
    </nav> 
  </div>
</header>
<div class ="wrapper">
  <div class ="top-wrapper">
    <div id="photo">
      <img src="../hirosaki_sakura.jpg" width="100%" height="700" alt="弘前公園の桜">
      <img src="../hirosaki_sakura.jpg" width="100%" height="700" alt="長岡花火大会">
      <img src="../hirosaki_sakura.jpg" width="100%" height="700" alt="香嵐渓の紅葉">
      <img src="../hirosaki_sakura.jpg" width="100%" height="700" alt="冬の白川郷">
    </div>
    <div class ="main-title">
    <p>トラベる</p>
    </div>
  </div>
  <div class ="main-wrapper">
    <div class="content">
      <h2 class="content-title">タイトル</h2>
      <img src ="../bicycle1.jpg">
      <p class="content-text">ここに色々と説明を書いていきますここに色々と説明を書いていきますここに色々と説明を書いていきますここに色々と説明を書いていきます</p>
    </div>
    <div class="content">
      <h2 class="content-title">タイトル</h2>
      <img src ="../bicycle1.jpg">
      <p class="content-text"></p>
    </div>
    <div class="content">
      <h2 class="content-title">タイトル</h2>
      <img src ="../bicycle1.jpg">
      <p class="content-text"></p>
    </div>
  </div>
  <div class ="bottom-wrapper">
    <h1>始めてみる</h1>
      <ol class="menu">
        <li><a href ="register_form.php">新規登録</a> </li>
        <li><a href ="login_form.php">ログイン</a> </li>
        <li><a href ="#">ゲストログイン</a></li>
      </ol>
  </div> 

  <footer>
    <div class ="footer">
        <p>&copy; 2022 oiwa</p>
    </div>
</footer> 

</div>




    <!-- javascript -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
      $(function(){
          var setImg = '#photo';
          var fadeSpeed = 1600;
          var switchDelay = 5000;

          $(setImg).children('img').css({opacity:'0'});
          $(setImg + ' img:first').stop().animate({opacity:'1',zIndex:'20'},fadeSpeed);

          setInterval(function(){
              $(setImg + ' :first-child').animate({opacity:'0'},fadeSpeed).next('img').animate({opacity:'1'},fadeSpeed).end().appendTo(setImg);
          },switchDelay);
      });
    </script>
  </body>
</html>
