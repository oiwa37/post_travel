<?php 
session_start();
require_once '../classes/login_class.php';

//エラーメッセージ用の配列
$err = [];


//メールアドレス・パスワードのバリデーション
if(!$email = filter_input(INPUT_POST,'email')){
    $err['email'] = 'メールアドレスを記入して下さい。';
}
if(!$password = filter_input(INPUT_POST,'password')){
    $err['password'] = 'パスワードを記入して下さい。';
}

//エラーがあった場合＄_SESSION(連想配列)に＄errを入れてログインフォーム（login_form.php）に戻す
if(count($err) > 0){
    $_SESSION = $err;
    header('Location:login_form.php');
    return;
}

//ログイン成功時はマイページへ遷移
//失敗時はエラーメッセージを入れてログインフォームへ戻す
$login = new LoginClass('member');
$result = $login->login($email, $password);
if($result){
    header('Location:mypage.php');
}else{
    header('Location:login_form.php');
    return;
}


?>
