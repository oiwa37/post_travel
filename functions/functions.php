<link href="s.css" rel="stylesheet">

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
 * 表示するタイトルの長さを制限する。
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
 * 表示するアドレスの長さを制限する。
 * @param $text  整型したい文字列
 * @return $title | $text 整形後の文字列もしくはオリジナル
 */
function addLimit($text){
    $limit = 15;     //文字数の上限
    if(mb_strlen($text) > $limit) { 
    $title = mb_substr($text,0,$limit);
    echo $title. '…' ;
    } else {
    echo $text;
    }
}
/**
 * 表示するユーザ名の長さを制限する。
 * @param $text  整型したい文字列
 * @return $title | $text 整形後の文字列もしくはオリジナル
 */
function userLimit($text){
    $limit = 10;     //文字数の上限
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
    echo '<select name="prefecture" class="select-pref">';
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


/**
 * 県名をローマ字から漢字に変換
 * @param void $pref_name
 * @return string $pref_change
 */
function changePrefName($pref_name){

    if ($pref_name=='hokkaido') {$pref_change='北海道';return $pref_change;}
    if ($pref_name=='aomori')   {$pref_change='青森県'; return $pref_change;}
    if ($pref_name=='iwate')    {$pref_change='岩手県'; return $pref_change;}
    if ($pref_name=='akita')    {$pref_change='秋田県'; return $pref_change;}
    if ($pref_name=='miyagi')   {$pref_change='宮城県'; return $pref_change;}
    if ($pref_name=='yamagata') {$pref_change='山形県'; return $pref_change;}
    if ($pref_name=='fukushima'){$pref_change='福島県'; return $pref_change;}
    if ($pref_name=='niigata')  {$pref_change='新潟県'; return $pref_change;}
    if ($pref_name=='ibaraki')  {$pref_change='茨城県'; return $pref_change;}
    if ($pref_name=='tochigi')  {$pref_change='栃木県'; return $pref_change;}
    if ($pref_name=='gunma')    {$pref_change='群馬県'; return $pref_change;}
    if ($pref_name=='chiba')    {$pref_change='千葉県'; return $pref_change;}
    if ($pref_name=='saitama')  {$pref_change='埼玉県'; return $pref_change;}
    if ($pref_name=='tokyo')    {$pref_change='東京都'; return $pref_change;}
    if ($pref_name=='kanagawa') {$pref_change='神奈川県'; return $pref_change;}
    if ($pref_name=='yamanashi'){$pref_change='山梨県'; return $pref_change;}
    if ($pref_name=='nagano')   {$pref_change='長野県'; return $pref_change ;}
    if ($pref_name=='toyama')   {$pref_change='富山県'; return $pref_change ;}
    if ($pref_name=='ishikawa') {$pref_change='石川県'; return $pref_change ;}
    if ($pref_name=='shizuoka') {$pref_change='静岡県'; return $pref_change ;}
    if ($pref_name=='aichi')    {$pref_change='愛知県'; return $pref_change ;}
    if ($pref_name=='gifu')     {$pref_change='岐阜県'; return $pref_change ;}
    if ($pref_name=='fukui')    {$pref_change='福井県'; return $pref_change ;}
    if ($pref_name=='shiga')    {$pref_change='滋賀県'; return $pref_change ;}
    if ($pref_name=='mie')      {$pref_change='三重県'; return $pref_change ;}
    if ($pref_name=='wakayama') {$pref_change='和歌山県'; return $pref_change;}
    if ($pref_name=='nara')     {$pref_change='奈良県'; return $pref_change;}
    if ($pref_name=='kyoto')    {$pref_change='京都府'; return $pref_change;}
    if ($pref_name=='osaka')    {$pref_change='大阪府'; return $pref_change;}
    if ($pref_name=='hyogo')    {$pref_change='兵庫県'; return $pref_change;}
    if ($pref_name=='okayama')  {$pref_change='岡山県'; return $pref_change;}
    if ($pref_name=='hiroshima'){$pref_change='広島県'; return $pref_change;}
    if ($pref_name=='yamaguchi'){$pref_change='山口県'; return $pref_change;}
    if ($pref_name=='tottori')  {$pref_change='鳥取県'; return $pref_change;} 
    if ($pref_name=='shimane')  {$pref_change='島根県'; return $pref_change;} 
    if ($pref_name=='kagawa')   {$pref_change='香川県'; return $pref_change;}     
    if ($pref_name=='tokushima'){$pref_change='徳島県'; return $pref_change;}
    if ($pref_name=='ehime')    {$pref_change='愛媛県'; return $pref_change;}    
    if ($pref_name=='kochi')    {$pref_change='高知県'; return $pref_change;}    
    if ($pref_name=='fukuoka')  {$pref_change='福岡県'; return $pref_change;} 
    if ($pref_name=='oita')     {$pref_change='大分県'; return $pref_change;}   
    if ($pref_name=='miyazaki') {$pref_change='宮崎県'; return $pref_change;}
    if ($pref_name=='kagoshima'){$pref_change='鹿児島県'; return $pref_change;}
    if ($pref_name=='kumamoto') {$pref_change='熊本県'; return $pref_change;}
    if ($pref_name=='saga')     {$pref_change='佐賀県'; return $pref_change;}   
    if ($pref_name=='nagasaki') {$pref_change='長崎県'; return $pref_change;}
    if ($pref_name=='okinawa')  {$pref_change='沖縄県'; return $pref_change;}
    
}

?>