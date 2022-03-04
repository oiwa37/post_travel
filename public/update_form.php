<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

session_start();
require_once '../functions.php';
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
$imageURL = '/post_travel/images/'.$image;


?>

<!DOCTYPE HTML PUBLIC"=//W3C//DTD HTML 4.01 Transitional//EN>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>投稿更新</title>
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="s.css" rel="stylesheet">
</head>


<body>
    <header>
        <p>ログインユーザ:<?php echo h($login_user['name'])?></p>
        <p>メールアドレス:<?php echo h($login_user['email'])?></p>
        <a href ="logout.php">ログアウト</a>
    </header>
    <h2>更新フォーム</h2>
    <form action="./imageResize/update.php" method="POST" enctype="multipart/form-data">
        <input type ="hidden" name ="id_article" value="<?php echo $id_article; ?>">
    <p>タイトル：</p>
    <input type ="text" name="title" value="<?php echo $title; ?>">

    <!-- ドロップダウンリスト -->
    <select name="prefecture">
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
    
    <p>ブログ本文：</p>
    <!-- cols=文字数rows=行数 -->
    <textarea name="content" id="content" cols="60" rows="15" ><?php echo $content; ?>></textarea>
    <br>
    <!-- <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> -->
    <input name="image" type="file" accept="image/*">
    <br>
    <input type="radio" name="post_status" value="1"
    <?php if($post_status === 1) echo "checked";?>>公開
    <input type="radio" name="post_status" value="2"
    <?php if($post_status === 2) echo "checked";?>>非公開
    <br>
    <input type="submit" value="送信">
    <img src="<?php echo $imageURL; ?>" alt="" />
    <!-- <form method ="POST" action ="deleteImage.php">    -->
        <!-- <input type ="hidden" name ="id_article" value="<?php echo $id_article; ?>"> -->
        <input type="hidden" name="deleteImage" value="<?php echo $image; ?>">
        <!-- <input type ="submit" name ="delete" value ="画像削除">
    </form> -->
    </form>
        <form method ="POST" action ="deleteImage.php">   
        <input type ="hidden" name ="id_article" value="<?php echo $id_article; ?>">
        <input type="hidden" name="deleteImage" value="<?php echo $image; ?>">
        <input type ="submit" name ="delete" value ="画像削除">
        </form>

    <p><a href="mypage.php">home</a></p>
    <button type="button" onclick="history.back()">戻る</button>



    <!-- javascript
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    </script> -->
</body>
</html>
