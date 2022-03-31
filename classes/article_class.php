<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

require_once '/home/xs115618/oiwa1105.com/public_html/post_travel/config/dbconnect.php';


Class Article extends Dbc{
    
    /**
    * 新規の投稿をDBに追加する（画像なしver）
    * @param $article フォームから入力されたデータ
    * @return bool $result 投稿の保存成功でtrue
    */
    public function newpost($article){
        $sql = 'INSERT INTO 
                    article(id_member,title,prefecture,content,post_status)
                VALUE
                    (:id_member,:title,:prefecture,:content,:post_status)';
        $dbh = $this->dbconnect();
        $dbh->beginTransaction();
        try{
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id_member',$article['id_member'],PDO::PARAM_STR);
            $stmt->bindValue(':title',$article['title'],PDO::PARAM_STR);
            $stmt->bindValue(':prefecture',$article['prefecture'],PDO::PARAM_STR);
            $stmt->bindValue(':content',$article['content'],PDO::PARAM_STR);
            $stmt->bindValue(':post_status',$article['post_status'],PDO::PARAM_INT);
            $result = $stmt->execute();
            $dbh->commit();
            header('Location:../mypage.php');
            return $result;
        }catch(PDOException $e){
            $dbh->rollBack();
            echo '接続失敗'.$e->getMessage();
        }
    }


    /**
     * 投稿の編集内容をDBに更新する → マイページへリダイレクト
     * @param $article フォームから入力されたデータ
     * @return void
     */
    public function updatePost($article){
        $sql = 'UPDATE article 
                    SET title = :title,prefecture =:prefecture,content = :content,post_status = :post_status
                    WHERE id_article = :id_article';
        $dbh = $this->dbconnect();
        $dbh->beginTransaction();
        try{
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':title',$article['title'],PDO::PARAM_STR);
            $stmt->bindValue(':prefecture',$article['prefecture'],PDO::PARAM_STR);
            $stmt->bindValue(':content',$article['content'],PDO::PARAM_STR);
            $stmt->bindValue(':post_status',$article['post_status'],PDO::PARAM_INT);
            $stmt->bindValue(':id_article',$article['id_article'],PDO::PARAM_INT);
            $stmt->execute();
            $dbh->commit();
            header('Location:../mypage.php');
        }catch(PDOException $e){
            $dbh->rollBack();
            echo '接続失敗'.$e->getMessage();
        }
    }


    /**
     * 投稿の編集内容をDBに更新する → マイページへリダイレクト
     * @param $article フォームから入力されたデータ
     * @return void
     */
    public function articleValidate($article){
        if(empty($article['title'])){
            exit('タイトルを入力して');
        }
        if(mb_strlen($article['title']) > 30){
            exit('30文字以下でお願い');
        }
        
        if(empty($article['content'])){
            exit('本文を入力して');
        }   
    }


    /**画像のバリデーション→アップロードされた画像データを一時ファイルから指定ファイルへ移動し、DBに記事保存。
     * （画像がありver）
     * @param $article フォームから入力されたデータ
     * @param $image フォームからアップロードされた画像ファイル
     * @return array $err_msg エラーメッセージ 
     */
    public function imageValidate($article,$image){

        $filename = basename($image['name']); //ファイル名
        $tmp_path = $image['tmp_name']; //一時保存されるファイルパス
        $file_err = $image['error']; //エラーコード
        $filesize = $image['size']; //ファイルのバイト数
        $upload_dir = '/home/xs115618/oiwa1105.com/public_html/post_travel/images/';
        $save_filename = date('Ymdhis') . $filename; //ファイル名に頭に日付をつけて保存
        $err_msg = array();
        $save_path = $upload_dir.$filename; //ファイルの保存先パス


        //ファイルのバリデーション
        //ファイルサイズは1MB未満か確認
        if ($filesize > 1048576 || $file_err == 2) {
            array_push($err_msg, '投稿できるファイルサイズは1MB未満です。');
        }
        //保存を許可する拡張子を指定し、画像の拡張子が許可されているかチェック
        $allow_ext = array('jpg', 'jpeg');
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION); //ファイルの拡張子を取得
        //配列の中にあったらtrueを返すin_array  NGならメッセージを出したいので！in_array
        if (!in_array(strtolower($file_ext), $allow_ext)) {
            array_push($err_msg, 'jpeg形式の画像ファイルを添付して下さい');
        }
        
        //エラーメッセージがなければ画像を保存する
        if (count($err_msg) === 0) {
            //ファイルはあるかどうかチェック。あれば一時ファイルから保存先に移動
            if (is_uploaded_file($tmp_path)) {
                if(move_uploaded_file($tmp_path,$upload_dir.$save_filename)){
                    $this->fileSave($article,$save_filename); //DBに画像と記事を保存
                    $this->imageResize($save_filename,$file_ext); //画像をリサイズして保存
                    header('Location:../mypage.php');
                }else{
                    array_push($err_msg, 'ファイルが保存されませんでした.再度やり直して下さい。');
                }
            } else {
                array_push($err_msg, 'ファイルが選択されていません。もう一度やり直して下さい。');
            }
        } else {
            return $err_msg;
        }
    }


    /**
   * 画像と記事をDBに保存
   * @param $article フォームから入力された投稿
   * @param $save_filename 保存したファイル名
   * @return bool $result 投稿の保存成功でtrue
   */
    public function fileSave($article,$save_filename){

        $result = false;
        
        $sql = 'INSERT INTO 
                    article(id_member,title,prefecture,image,content,post_status)
                VALUE
                    (:id_member,:title,:prefecture,:image,:content,:post_status)';
        $dbh = $this->dbconnect();
        $dbh->beginTransaction();
        try{
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id_member',$article['id_member'],PDO::PARAM_STR);
            $stmt->bindValue(':title',$article['title'],PDO::PARAM_STR);
            $stmt->bindValue(':prefecture',$article['prefecture'],PDO::PARAM_STR);
            $stmt->bindValue(':image',$save_filename,PDO::PARAM_STR);
            $stmt->bindValue(':content',$article['content'],PDO::PARAM_STR);
            $stmt->bindValue(':post_status',$article['post_status'],PDO::PARAM_INT);
            $result = $stmt->execute();
            $dbh->commit();
            return $result;
        }catch(PDOException $e){
            $dbh->rollBack();
            echo '接続失敗'.$e->getMessage();
        }
    }


    //画像のバリデーション。ファイルを一時ファイルから指定ファイルへ移動しDBに記事更新
    /**画像のバリデーション→アップロードされた画像データを一時ファイルから指定ファイルへ移動し、DBに記事更新。
     * （画像がありver）
     * @param $article フォームから入力されたデータ
     * @param $image フォームからアップロードされた画像ファイル
     * @return array $err_msg エラーメッセージ 
     */
    public function imageUpdate($article,$image){

        $filename = basename($image['name']);
        $tmp_path = $image['tmp_name'];
        $file_err = $image['error'];
        $filesize = $image['size'];
        $upload_dir = '/home/xs115618/oiwa1105.com/public_html/post_travel/images/';
        $save_filename = date('Ymdhis') . $filename;
        $err_msg = array();
        $save_path = $upload_dir.$filename;

        //ファイルのバリデーション
        //ファイルサイズは1MB未満か
        if ($filesize > 1048576 || $file_err == 2) {
            array_push($err_msg, 'ファイルサイズを1MB未満にして下さい。');
        }

        //保存を許可する拡張子を指定し、画像の拡張子が許可されているかチェック
        $allow_ext = array('jpg', 'jpeg');
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION); //ファイルの拡張子を取得
        //配列の中にあったらtrueを返すin_array  NGならメッセージを出したいので！in_array
        if (!in_array(strtolower($file_ext), $allow_ext)) {
            array_push($err_msg, 'jpeg形式の画像ファイルを添付して下さい');
        }

        //エラーメッセージがなければ画像を保存する
        if (count($err_msg) === 0) {
            //ファイルはあるかどうかチェック。あれば一時ファイルから保存先に移動
            if (is_uploaded_file($tmp_path)) {
                if(move_uploaded_file($tmp_path,$upload_dir.$save_filename)){
                    $this->fileUpdate($article,$save_filename);  //DBの画像と記事を更新
                    $this->imageResize($save_filename,$file_ext); //画像リサイズして保存
                    header('Location:../mypage.php');
                }else{
                    array_push($err_msg, 'ファイルが保存されませんでした');
                }
            } else {
                array_push($err_msg, 'ファイルが選択されていません');
            }
        } else {
            foreach ($err_msg as $msg) {
                echo $msg;
                echo '<br>';
            }
        }
    }


    /**
   * DBの画像と記事内容を更新
   * @param $article フォームから入力された投稿
   * @param $save_filename フォームからアップロードされた画像ファイル
   * @return void
   */
        //編集内容をDB更新
        public function fileUpdate($article,$save_filename){
            $sql = 'UPDATE article 
                        SET title = :title,prefecture =:prefecture,image = :image,content = :content,post_status = :post_status
                        WHERE id_article = :id_article';
            $dbh = $this->dbconnect();
            $dbh->beginTransaction();
            try{
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(':title',$article['title'],PDO::PARAM_STR);
                $stmt->bindValue(':prefecture',$article['prefecture'],PDO::PARAM_STR);
                $stmt->bindValue(':image',$save_filename,PDO::PARAM_STR);
                $stmt->bindValue(':content',$article['content'],PDO::PARAM_STR);
                $stmt->bindValue(':post_status',$article['post_status'],PDO::PARAM_INT);
                $stmt->bindValue(':id_article',$article['id_article'],PDO::PARAM_INT);
                $stmt->execute();
                $dbh->commit();
            }catch(PDOException $e){
                $dbh->rollBack();
                echo '接続失敗'.$e->getMessage();
            }
        }


    /**
     * 画像をリサイズして保存する
     * @param $save_filename DBに保存したファイル名
     * @return void
     */
    function imageResize($save_filename){
        $path = '/home/xs115618/oiwa1105.com/public_html/post_travel/images/';
        $image_before =  $path.$save_filename; //リサイズ前の画像
        $new = 'new';
        
        // 元の画像名を指定してサイズを取得
        list($width, $height) = getimagesize($image_before);

        //最大幅に縮小拡大 (縦か横大きい方に合わせて縮小)
        $newwidth = 0; // 新しい横幅
        $newheight = 0; // 新しい縦幅
        $dst_w = 300; // 最大横幅 (コピー先の横幅)
        $dst_h = 300; // 最大縦幅（コピー先の縦幅）

        $zoom1 = $width / $dst_w;
        $zoom2 = $height / $dst_h;
        $zoom = ($zoom1 > $zoom2) ? $zoom1 : $zoom2;
        $newwidth  = floor($width  / $zoom);
        $newheight = floor($height / $zoom);

        // サイズを指定して新しい画像のキャンバスを作成
        $image = imagecreatetruecolor($dst_w, $dst_h); 

        //縮小した画像の小さい幅の方を拡大、大きい方は拡大した分をカットすることで300×300にする。
        $cutwidth = 0;
        $cutheight = 0;
        $rewidth = 300;
        $reheight = 300;

        // サイズを切り取り 300×300にする
        if($newwidth>$newheight){
            $zm = $height / $dst_h;
            $rewidth = $width / $zm;
            $cutwidth = ($rewidth - $dst_w)/2 * -1;
        }elseif($newheight>$newwidth){
            $zm = $width / $dst_w;
            $reheight = $height / $zm;
            $cutheight = ($reheight - $dst_h)/2 * -1;
        }

        // 元の画像から新しい画像を作る準備
        $baseImage= imagecreatefromjpeg($image_before);
        // 画像のコピーと伸縮
        imagecopyresampled($image, $baseImage, $cutwidth, $cutheight, 0, 0, $rewidth, $reheight, $width, $height);
        // コピーした画像を出力する
        imagejpeg($image,$new.$save_filename);
    }
}
        
