<link href="s.css" rel="stylesheet">

<?php
require_once 'env.php';
require_once '/Applications/MAMP/htdocs/post_travel/functions/functions.php';

//DB接続関連
Class Dbc{

    protected $table_name;
    function __construct($table_name){
        $this->table_name = $table_name;
    }

    //travel DBに接続
    public function dbconnect(){
        $host = DB_HOST;
        $db =  DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    try{
        $dbh = new PDO($dsn,$user,$pass,[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $dbh;
    }catch(PDOException $e){
        echo '接続失敗'.$e->getMessage();
        exit();
    };
    return $dbh;
    }

    // //全データ取得
    // public function getAll(){
    //     $dbh = $this->dbconnect();
    //     $sql = "SELECT * FROM $this->table_name 
    //                 WHERE post_status = 1 ORDER BY id_article DESC ";
    //     $stmt = $dbh->query($sql);
    
    //     $result = $stmt->fetchall(PDO::FETCH_ASSOC);
    //     return $result;
    //     $dbh = null;
    // }

    //全データ取得（公開になっているもののみ） 
    function getAll(){
        $dbh = $this->dbconnect();
        $sql = "SELECT *
                    FROM article INNER JOIN member 
                    ON article.id_member = member.id_member
                    WHERE post_status = 1 ORDER BY id_article DESC ";
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
        $dbh = null;
    }

     /**
     * 県別全メンバー記事取得（公開になっているもののみ） 
     * @param string $pref_change
     * @return array|bool $result|false あれば記事なければfalse
     */
    function getAllpref($pref_change){
        try{
        $dbh = $this->dbconnect();
        $sql = "SELECT *
                    FROM article INNER JOIN member 
                    ON article.id_member = member.id_member
                    WHERE post_status = 1
                    AND prefecture = :prefecture
                    ORDER BY id_article DESC ";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':prefecture',(string)$pref_change,PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
        $dbh = null;
    }catch(\PDOException $e){
        echo $e->getMessage();
        return  false;   
    }
}


    /**
     * id_memberから該当メンバーの記事を取得
     * @param string $id_member
     * @return array|bool $result|false あれば記事なければfalse
     */
    public function getMemberPost($id_member){
        try{
        $dbh = $this->dbconnect();
        $sql = "SELECT * FROM $this->table_name 
                    WHERE id_member = ? 
                    ORDER BY id_article DESC ";
        $arr = [];
        $arr[] = $id_member;
        $stmt = $dbh->prepare($sql);
        $stmt->execute($arr);
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
        $dbh = null;
        }catch(\PDOException $e){
        echo $e->getMessage();
        return  false;   
        }
}

    /**
     * id_memberから該当メンバーの県別記事を取得
     * @param string $id_member $pref_change
     * @return array|bool $result|false あれば記事なければfalse
     */
    public function getMemberPref($id_member,$pref_change){
        try{
        $dbh = $this->dbconnect();
        $sql = "SELECT * FROM $this->table_name 
                    WHERE id_member = :id_member
                    AND prefecture = :prefecture
                    ORDER BY id_article DESC ";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id_member',(int)$id_member,PDO::PARAM_INT);
        $stmt->bindValue(':prefecture',(string)$pref_change,PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
        $dbh = null;
        }catch(\PDOException $e){
        echo $e->getMessage();
        return  false;   
        }
}


    /**
     * 写真を取得
     * @param string void
     * @return array $result
     */
function getPicture(){
    $dbh = $this->dbconnect();
    $sql = "SELECT *
                FROM article 
                WHERE image IS NOT NULL 
                AND post_status = 1
                ORDER BY id_article DESC ";
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $result;
    $dbh = null;
}



    //記事IDから記事詳細を取得
    public function getById($id_article){
        if(empty($id_article)){
            exit('IDが不正です。');
        }
        $dbh = $this->dbconnect();   
        $sql = "SELECT * 
                    FROM article INNER JOIN member 
                    ON article.id_member = member.id_member
                    WHERE id_article = :id_article";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id_article',(int)$id_article,PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$result){
            exit('投稿がありません');
        }
    return $result;
    }

    //記事を削除する
    public function delete($id_article){
        if(empty($id_article)){
            exit('IDが不正です。');
        }
        $dbh = $this->dbconnect();
        $sql = "DELETE FROM $this->table_name WHERE id_article = :id_article";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id_article',(int)$id_article,PDO::PARAM_INT);
        $stmt->execute();
        header('Location:./mypage.php');
        }


    //画像データをNULLにする（DBの画像削除）
    public function deleteImage($del_image){
        $result = false;
        if(empty($del_image)){
            header('Location:mypage.php');
        }
        $dbh = $this->dbconnect();
        $sql = "UPDATE $this->table_name SET image = NULL 
        WHERE image = :image";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':image',$del_image,PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
        // echo '画像削除しました';
    }


    /**
     * ページ番号リンクの表示
     * @param int $max_page データの最大件数
     * @param int $page 現在のページ番号
     * @param int $pageRange $pageから前後何件のページ番号を表示するか
     */
    public function paging($max_page,$page=1,$pageRange=2){
        $page = h($page);
        $prev = max($page - 1, 1); // 前のページ番号は1と比較して大きい方を使う
        $next = min($page + 1, $max_page); // 次のページ番号は最大ページ数と比較して小さい方を使う
    
        $start = max($page - $pageRange, 2); //ページ番号の始点
        $end = min($page + $pageRange, $max_page - 1); // ページ番号の終点

        //1ページ目のときのページ番号の終点
        if($page === 1){
        $end = $pageRange * 2;
        }
        // ページ番号を$numsに格納する
        $nums =[]; 
        for ($i = $start; $i <= $end; $i++) {
        $nums[] = $i;
        }

    echo '<div class = "page">';
    //2ページ目以降にいた場合、最初のページへ遷移するリンクをつける
    if ($page > 1 && $page !== 1){
        echo '<a href="mypage.php?page=1" title="最初のページへ">&laquo;</a>';
    } else {
        echo '<span class="first_last_page">&laquo;</span>';
    }

    // // 前のページへのリンク
    // if ($page > 1) {
    //     echo '<a href="mypage.php?page=' . $prev . '" title="前のページへ">&laquo; 前へ</a>';
    // } else {
    //     echo '<span>&laquo; 前へ</span>';
    // }


    // 1ページ目へのリンク
    echo '<a href="mypage.php?page=1">1</a>';
    
    echo '<div class ="dot">';
    if ($start > $pageRange) echo "..."; //ドット表示
    echo '</div>';
    
    //ページリンクをページ番号格納した$nums ループで表示
    foreach ($nums as $num) {
        // 現在地のページ番号
        if ($num === $page) {
        echo '<span class="current">' . $num . '</span>';
        } else {
        // ページ番号リンク表示
        echo '<a href="mypage.php?page='. $num .'">' . $num . '</a>';
        }
    }
    echo '<div class ="dot">';
    if (($max_page - 1) > $end) echo "..."; //ドット表示
    echo '</div>';

    //最後のページ番号へのリンク
    if ($page < $max_page) {
        echo '<a href="mypage.php?page='. $max_page .'" >' . $max_page . '</a>';
    }elseif($page == 1 && $page == $max_page){
        echo '<p></p>';    
    } else {
        echo '<span>' . $max_page . '</span>';
    }

    // 次のページへのリンク
    // if ($page < $max_page){
    //     echo '<a href="mypage.php?page='.$next.'">次へ &raquo;</a>';
    // } else {
    //     echo '<span>次へ &raquo;</span>';
    // }

    //最後のページへのリンク
    if ($page < $max_page){
        echo '<a href="mypage.php?page=' . $max_page . ' title="最後のページへ">&raquo;</a>';
    } else {
        echo '<span class="first_last_page">&raquo;</span>';
    }
    echo '</div>';
    }



    /**
 * ページ番号リンクの表示 allpost ver.
 * @param int $max_page データの最大件数
 * @param int $page 現在のページ番号
 * @param int $pageRange $pageから前後何件のページ番号を表示するか
 */
    public function paging2($max_page,$page=1,$pageRange =2){
        $page = h($page);
        $prev = max($page - 1, 1); // 前のページ番号は1と比較して大きい方を使う
        $next = min($page + 1, $max_page); // 次のページ番号は最大ページ数と比較して小さい方を使う
    
        $start = max($page - $pageRange, 2); //ページ番号の始点
        $end = min($page + $pageRange, $max_page - 1); // ページ番号の終点
        //1ページ目のときのページ番号の終点
        if($page === 1){
        $end = $pageRange * 2;
        }
        // ページ番号を$numsに格納する
        $nums =[]; 
        for ($i = $start; $i <= $end; $i++) {
        $nums[] = $i;
        }

    echo '<div class = "page">';
    //2ページ目以降にいた場合、最初のページへ遷移するリンクをつける
    if ($page > 1 && $page !== 1){
        echo '<a href="allpost.php?page=1" title="最初のページへ">&laquo;</a>';
    } else {
        echo '<span class="first_last_page">&laquo;</span>';
    }

    // 1ページ目へのリンク
    echo '<a href="allpost.php?page=1">1</a>';
    
    echo '<div class ="dot">';
    if ($start > $pageRange) echo "..."; //ドット表示
    echo '</div>';
    
    //ページリンクをページ番号格納した$nums ループで表示
    foreach ($nums as $num) {
        // 現在地のページ番号
        if ($num === $page) {
        echo '<span class="current">' . $num . '</span>';
        } else {
        // ページ番号リンク表示
        echo '<a href="allpost.php?page='. $num .'">' . $num . '</a>';
        }
    }
    echo '<div class ="dot">';
    if (($max_page - 1) > $end) echo "..."; //ドット表示
    echo '</div>';

    //最後のページ番号へのリンク
    if ($page < $max_page) {
        echo '<a href="allpost.php?page='. $max_page .'" >' . $max_page . '</a>';
    }elseif($page == 1 && $page == $max_page){
        echo '<p></p>';     
    } else {
        echo '<span>' . $max_page . '</span>';
    }

    //最後のページへのリンク
    if ($page < $max_page){
        echo '<a href="allpost.php?page=' . $max_page . ' title="最後のページへ">&raquo;</a>';   
    } else {
        echo '<span class="first_last_page">&raquo;</span>';
    }
    echo '</div>';
    }


    /**
 * ページ番号リンクの表示 pictures ver.
 * @param int $max_page データの最大件数
 * @param int $page 現在のページ番号
 * @param int $pageRange $pageから前後何件のページ番号を表示するか
 */
public function paging3($max_page,$page=1,$pageRange =2){
    $page = h($page);
    $prev = max($page - 1, 1); // 前のページ番号は1と比較して大きい方を使う
    $next = min($page + 1, $max_page); // 次のページ番号は最大ページ数と比較して小さい方を使う

    $start = max($page - $pageRange, 2); //ページ番号の始点
    $end = min($page + $pageRange, $max_page - 1); // ページ番号の終点
    //1ページ目のときのページ番号の終点
    if($page === 1){
    $end = $pageRange * 2;
    }
    // ページ番号を$numsに格納する
    $nums =[]; 
    for ($i = $start; $i <= $end; $i++) {
    $nums[] = $i;
    }

echo '<div class = "page">';
//2ページ目以降にいた場合、最初のページへ遷移するリンクをつける
if ($page > 1 && $page !== 1){
    echo '<a href="pictures.php?page=1" title="最初のページへ">&laquo;</a>';
} else {
    echo '<span class="first_last_page">&laquo;</span>';
}

// 1ページ目へのリンク
echo '<a href="pictures.php?page=1">1</a>';

echo '<div class ="dot">';
if ($start > $pageRange) echo "..."; //ドット表示
echo '</div>';

//ページリンクをページ番号格納した$nums ループで表示
foreach ($nums as $num) {
    // 現在地のページ番号
    if ($num === $page) {
    echo '<span class="current">' . $num . '</span>';
    } else {
    // ページ番号リンク表示
    echo '<a href="pictures.php?page='. $num .'">' . $num . '</a>';
    }
}
echo '<div class ="dot">';
if (($max_page - 1) > $end) echo "..."; //ドット表示
echo '</div>';

//最後のページ番号へのリンク
if ($page < $max_page) {
    echo '<a href="pictures.php?page='. $max_page .'" >' . $max_page . '</a>';
}elseif($page == 1 && $page == $max_page){
    echo '<p></p>';       
} else {
    echo '<span>' . $max_page . '</span>';
}

//最後のページへのリンク
if ($page < $max_page){
    echo '<a href="pictures.php?page=' . $max_page . ' title="最後のページへ">&raquo;</a>';
} else {
    echo '<span class="first_last_page">&raquo;</span>';
}
echo '</div>';
}



    //ぺージ番号を渡してデータ配列にフィルターをかける関数
    public function filter ($page,$per_page,$data){
        return array_filter($data, function($i) use ($page, $per_page) {
          return $i >= ($page - 1) * $per_page && $i < $page * $per_page;
        }, ARRAY_FILTER_USE_KEY);
    }


    } 


//   public function delete($id){

//   if(empty($id)){
//     exit('IDが不正です。');
//   }

//   $dbh = $this->dbConnect();

//   //SQL準備 :id⇦プレースホルダー使う場合はbindValueメソッドを設定する必要がある
//   $stmt = $dbh->prepare("DELETE FROM $this->table_name Where id = :id");
//   //引数⇨値、実際に入れたい値、データ型  (int)$idで型を数値型に指定
//   $stmt->bindValue(':id',(int)$id,PDO::PARAM_INT);
//   //SQL実行
//   $stmt->execute();
//   echo 'ブログを削除しました';
//   // return $result;
// }
