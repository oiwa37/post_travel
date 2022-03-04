<?php


/**
 * 表示する記事の長さを制限する。
 * @param $text  整型したい文字列
 * @return $title | $text 整形後の文字列もしくはオリジナル
 */
function textLimit($text){
    $limit = 50;     //文字数の上限
    if(mb_strlen($text) > $limit) { 
    $title = mb_substr($text,0,$limit);
    echo $title. '…' ;
    } else {
    echo $text;
    }
}
/**
 * 表示するタイトつの長さを制限する。
 * @param $text  整型したい文字列
 * @return $title | $text 整形後の文字列もしくはオリジナル
 */
function titleLimit($text){
    $limit = 11;     //文字数の上限
    if(mb_strlen($text) > $limit) { 
    $title = mb_substr($text,0,$limit);
    echo $title. '…' ;
    } else {
    echo $text;
    }
}

/**
 * XSS対策：エスケープ処理 (配列ver.)
 * @param string 対象の文字列
 * @return string 処理された文字列
 */
function f($before){
    foreach($before as $key => $value){
        $after[$key] = htmlspecialchars($value,ENT_QUOTES,'UTF-8');
    }
    return $after;
}

/**
 * XSS対策：エスケープ処理
 * @param string 対象の文字列
 * @return string 処理された文字列
 */
function h($str){
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
    }

/**
 * CSRF対策
 * @param void
 * @return string $csrf_token
 */
function setToken(){
    //トークンを生成
    //フォームからそのトークンを送信
    //送信後の画面でそのトークンを照会（セッションに入ってるものとreturnされたもの
    //トークンを削除
    $csrf_token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $csrf_token;
    return $csrf_token;
}

/**
 * 県名のドロップダウンリスト
 */
function select_prefecture(){
    echo '<select name="prefecture">';
    echo '<option value="北海道">北海道</option>';
    echo '<option value="青森県">青森県</option>';
    echo '<option value="岩手県">岩手県</option>';
    echo '<option value="宮城県">宮城県</option>';
    echo '<option value="秋田県">秋田県</option>';
    echo '<option value="山形県">山形県</option>';
    echo '<option value="福島県">福島県</option>';
    echo '<option value="茨城県">茨城県</option>';
    echo '<option value="栃木県">栃木県</option>';
    echo '<option value="群馬県">群馬県</option>';
    echo '<option value="埼玉県">埼玉県</option>';
    echo '<option value="千葉県">千葉県</option>';
    echo '<option value="東京都">東京都</option>';
    echo '<option value="神奈川県">神奈川県</option>';
    echo '<option value="新潟県">新潟県</option>';
    echo '<option value="富山県">富山県</option>';
    echo '<option value="石川県">石川県</option>';
    echo '<option value="福井県">福井県</option>';
    echo '<option value="山梨県">山梨県</option>';
    echo '<option value="長野県">長野県</option>';
    echo '<option value="岐阜県">岐阜県</option>';
    echo '<option value="静岡県">静岡県</option>';
    echo '<option value="愛知県">愛知県</option>';
    echo '<option value="三重県">三重県</option>';
    echo '<option value="滋賀県">滋賀県</option>';
    echo '<option value="京都府">京都府</option>';
    echo '<option value="大阪府">大阪府</option>';
    echo '<option value="兵庫県">兵庫県</option>';
    echo '<option value="奈良県">奈良県</option>';
    echo '<option value="和歌山県">和歌山県</option>';
    echo '<option value="鳥取県">鳥取県</option>';
    echo '<option value="島根県">島根県</option>';
    echo '<option value="岡山県">岡山県</option>';
    echo '<option value="広島県">広島県</option>';
    echo '<option value="山口県">山口県</option>';
    echo '<option value="徳島県">徳島県</option>';
    echo '<option value="香川県">香川県</option>';
    echo '<option value="愛媛県">愛媛県</option>';
    echo '<option value="高知県">高知県</option>';
    echo '<option value="福岡県">福岡県</option>';
    echo '<option value="佐賀県">佐賀県</option>';
    echo '<option value="長崎県">長崎県</option>';
    echo '<option value="熊本県">熊本県</option>';
    echo '<option value="大分県">大分県</option>';
    echo '<option value="宮崎県">宮崎県</option>';
    echo '<option value="鹿児島県">鹿児島県</option>';
    echo '<option value="沖縄県">沖縄県</option>';
    echo '</select>';}






?>