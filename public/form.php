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
if (!$result) {
  $_SESSION['login_err'] = 'ユーザ登録してログインして下さい';
  header('Location:register_form.php');
  return;
}

$login_user = $_SESSION['login_user'];
$id_member = $login_user['id_member'];
echo $id_member;

?>

<!DOCTYPE HTML PUBLIC"=//W3C//DTD HTML 4.01 Transitional//EN>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <title>新規投稿</title>
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link href="s.css" rel="stylesheet">
</head>

<body>
  <header>
    <p>ログインユーザ:<?php echo h($login_user['name']) ?></p>
    <p>メールアドレス:<?php echo h($login_user['email']) ?></p>
    <a href="logut.php">ログアウト</a>
  </header>
  <h2>ブログフォーム</h2>
  <form action="./imageResize/newpost.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id_member" value="<?php echo $id_member; ?>">
    <p>タイトル：</p>
    <input type="text" name="title">
    <?php select_prefecture(); ?>

    <p>ブログ本文：</p>
    <!-- cols=文字数　rows=行数 -->
    <textarea name="content" id="content" cols="60" rows="15"></textarea>
    <br>
    <br>
    <input name="image" type="file" accept="image/*">
    <br>
    <br>
    <input type="radio" name="post_status" value="1" checked>公開
    <input type="radio" name="post_status" value="2">非公開
    <br>
    <br>
    <input type="submit" value="送信">
  </form>

  <p><a href="mypage.php">home</a></p>
  <button type="button" onclick="history.back()">戻る</button>



  <!-- javascript
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    </script> -->
</body>

</html>