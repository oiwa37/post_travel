<?php 
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );



session_start();
require_once '../functions/functions.php';
require_once '../classes/article_class.php';
require_once '../classes/login_class.php';
require_once '../classes/prefecture_class.php';



//ログインしているか判定し、していなければ新規登録画面へ ｓ
$login = new LoginClass('member');
$result = $login->checkLogin();
if(!$result){
    $_SESSION['login_err'] = 'ユーザ登録してログインして下さい';
    header('Location:register_form.php');
    return;
}
$login_user = $_SESSION['login_user'];
$id_member = $login_user['id_member'];


//メンバー個々の県別の記事取得
$art = new Article('prefecture');

$pref_color = $_POST['pref_color'];
$pref_name =  $_POST['pref_name'];


prefColor($id_member,$pref_name,$pref_color);

function prefColor($id_member,$pref_name,$pref_color){

    $art = new Article('prefecture');
    $sql = "UPDATE prefecture 
                SET $pref_name = :pref_color
                WHERE id_member = :id_member";
    $dbh = $art->dbconnect();
    $dbh->beginTransaction();
    try{
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id_member',$id_member,PDO::PARAM_INT);
        $stmt->bindValue(':pref_color',$pref_color,PDO::PARAM_STR);
        $stmt->execute();
        $dbh->commit();
        header('Location:./mypage.php');
        echo '更新完了';
    }catch(PDOException $e){
        $dbh->rollBack();
        echo '接続失敗'.$e->getMessage();
    }
}



?>

