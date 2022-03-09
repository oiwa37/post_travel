<?php 
session_start();
require_once '../classes/login_class.php';

//エラーメッセージ
$err = [];


//バリデーション
if(!$email = filter_input(INPUT_POST,'email')){
    $err['email'] = 'メールアドレスを記入して下さい。';
}
if(!$password = filter_input(INPUT_POST,'password')){
    $err['password'] = 'パスワードを記入して下さい。';
}

//エラーがあった場合＄_SESSION(連想配列)に＄errを入れてlogin_form.phpに戻す
if(count($err) > 0){
    $_SESSION = $err;
    header('Location:login_form.php');
    return;
}

//ログイン成功時
$login = new LoginClass('member');
$result = $login->login($email, $password);
if($result){
    header('Location:mypage.php');
}else{
    header('Location:login_form.php');
    return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン完了画面</title>
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="s.css" rel="stylesheet">
</head>
<body>
</body>
</html>