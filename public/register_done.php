<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

session_start();
require_once '../classes/login_class.php';

$err = [];

//トークンを受け取り、値が一致しているか確認
$token = filter_input(INPUT_POST,'csrf_token');
if(!isset($_SESSION['csrf_token'])||$token !==$_SESSION['csrf_token']){
    exit('不正なリクエストです');
}
//セッション削除
unset($_SESSION['csrf_token']);


//バリデーション
if(!$username = filter_input(INPUT_POST,'username')){
    $err[] = 'ユーザー名を入力して下さい。';
}
$email = filter_input(INPUT_POST,'email');
if(!preg_match('/\A[\w\-\._]+@[\w\-\._]+\.[A-Za-z]+\z/',$email)){
    $err[] = 'メールアドレスを正しく入力してください。';
}
$password = filter_input(INPUT_POST,'password');
if(!preg_match("/\A[a-z\d]{6,15}+\z/i",$password)){
    $err[] = 'パスワードは英数字6文字以上15文字以下にして下さい。';
}
$password_conf = filter_input(INPUT_POST,'password_conf');
if($password !== $password_conf){
    $err[] = 'パスワードが一致しません。';
}

$login = new LoginClass('member');
//エラーがなければユーザ登録
if(count($err) === 0){
    $hasCreated = $login->createUser($_POST);
    if(!$hasCreated){
        $err[] = '登録に失敗しました。';
    }
}





?>

<!DOCTYPE HTML PUBLIC"=//W3C//DTD HTML 4.01 Transitional//EN>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>登録完了</title>
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php if(count($err) > 0) : ?>
    <?php foreach($err as $e) : ?>
        <p><?php echo $e ?></p>
    <?php endforeach ?>
<?php else : ?>
    <p>ユーザ登録が完了しました。</p>
<?php endif ?>    
    <a href="register_form.php">戻る</a>
</body>
</html>
