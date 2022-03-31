<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );


require_once '/home/xs115618/oiwa1105.com/public_html/post_travel/config/dbconnect.php';

//記事投稿関連
Class Article extends Dbc{

    /**  
     * 新規の記事をDBに追加する (画像無ver)
     * @param string $article 新規記事
     * @return bool $result 
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
        }catch(\PDOException $e){
            $dbh->rollBack();
            echo $e->getMessage();
        }
    }



    /**  
     * DBに記事の編集内容を更新
     * @param string $article 更新記事
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
        }catch(\PDOException $e){
            $dbh->rollBack();
            echo $e->getMessage();
        }
    }
    


    /** 記事の内容をバリデーション
     * @param string $article 投稿された記事
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


    /**
     * 画像のバリデーション→一時保存ファイルから指定ファイルへ移動しDBに新規記事を追加する(画像有ver)
     * @param string $article 新規記事内容
     * @param string $image アップロードされた画像のパス
     */
    public function imageValidate($article,$image){

        $filename = basename($image['name']); //パスからファイル名を取得
        $tmp_path = $image['tmp_name']; //一時保存先パス
        $file_err = $image['error']; //エラーコード
        $filesize = $image['size']; //ファイルのバイト数
        $upload_dir = '/home/xs115618/oiwa1105.com/public_html/post_travel/images/'; //ファイル保存先
        $save_filename = date('Ymdhis') . $filename; //保存ファイル名の頭に日付を入れる
        $err_msg = array(); //画像バリデーションでのエラーを入れる配列を用意
        $save_path = $upload_dir.$filename;

        //ファイルのバリデーション
        //ファイルサイズは1MB未満か確認
        if ($filesize > 1048576 || $file_err == 2) {
            array_push($err_msg, '投稿できるファイルサイズは1MB未満です。');
        }

        $allow_ext = array('jpg', 'jpeg'); //許可する拡張子を指定
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION);  //ファイルの拡張子を取得
        //許可された拡張子かチェックする
        if (!in_array(strtolower($file_ext), $allow_ext)) {
            array_push($err_msg, 'jpeg形式の画像ファイルを添付して下さい');
        }
        
        //エラーがなければ、画像を保存する
        if (count($err_msg) === 0) {
            //ファイルはあるかどうかチェック。 あれば一時ファイルから保存先へ移動
            if (is_uploaded_file($tmp_path)) {
                if(move_uploaded_file($tmp_path,$upload_dir.$save_filename)){
                    $this->fileSave($article,$save_filename); //DBに画像と記事内容を保存
                    $this->imageResize($save_filename); //画像をリサイズして保存
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
    * 画像と記事内容をDBに追加
    * @param string $article  記事内容
    * @param string $save_filename 保存ファイル名
    * @return bool $result
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
        }catch(\PDOException $e){
            $dbh->rollBack();
            echo $e->getMessage();
        }
    }


    /**
     * 画像のバリデーション→一時保存ファイルから指定ファイルへ移動しDBに新規記事を追加する(画像有ver)
     * @param string $article 新規記事内容
     * @param string $image アップロードされた画像のパス
     */
    public function imageUpdate($article,$image){

        $filename = basename($image['name']); //パスからファイル名を取得
        $tmp_path = $image['tmp_name']; //一時保存先パス
        $file_err = $image['error']; //エラーコード
        $filesize = $image['size']; //ファイルのバイト数
        $upload_dir = '/home/xs115618/oiwa1105.com/public_html/post_travel/images/'; //ファイル保存先
        $save_filename = date('Ymdhis') . $filename; //保存ファイル名の頭に日付を入れる
        $err_msg = array(); //画像バリデーションでのエラーを入れる配列を用意
        $save_path = $upload_dir.$filename;

        //ファイルのバリデーション
        //ファイルサイズは1MB未満か確認
        if ($filesize > 1048576 || $file_err == 2) {
            array_push($err_msg, '投稿できるファイルサイズは1MB未満です。');
        }

        $allow_ext = array('jpg', 'jpeg'); //許可する拡張子を指定
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION);  //ファイルの拡張子を取得
        //許可された拡張子かチェックする
        if (!in_array(strtolower($file_ext), $allow_ext)) {
            array_push($err_msg, 'jpeg形式の画像ファイルを添付して下さい');
        }
        
        if (count($err_msg) === 0) {
            //ファイルはあるかどうか あれば一時ファイルから指定のディレクトリに移動
            //リサイズしたものも保存する
            if (is_uploaded_file($tmp_path)) {
                if(move_uploaded_file($tmp_path,$upload_dir.$save_filename)){
                    $this->fileUpdate($article,$save_filename); //DBに画像と記事内容を更新
                    $this->imageResize($save_filename); //画像をリサイズして保存
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
    * 画像と記事を内容をDBに更新
    * @param $filename
    * @return bool $result
    */
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
            header('Location:../mypage.php');
        }catch(\PDOException $e){
            $dbh->rollBack();
            echo $e->getMessage();
        }
    }


        /**
         * 画像を300×300に縮小、リサイズして保存する
         * @param $save_filename 保存ファイル名
         * @return bool $result
         */ 
    function imageResize($save_filename){

        $path = '/home/xs115618/oiwa1105.com/public_html/post_travel/images/';
        $image_before =  $path.$save_filename;
        $new = 'new';
        
        // 元の画像名を指定してサイズを取得
        list($width, $height) = getimagesize($image_before);

        //最大幅に縮小拡大
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

        //幅の小さい方を300まで拡大し、大きい方の300からはみ出た部分をカットする。
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

