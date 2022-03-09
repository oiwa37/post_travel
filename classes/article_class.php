<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

require_once '/Applications/MAMP/htdocs/post_travel/config/dbconnect.php';

Class Article extends Dbc{
    //新規投稿をDBに追加
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
            return $result;
        }catch(PDOException $e){
            $dbh->rollBack();
            echo '接続失敗'.$e->getMessage();
}
    }

    //編集内容をDB更新
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
            echo '更新完了';
        }catch(PDOException $e){
            $dbh->rollBack();
            echo '接続失敗'.$e->getMessage();
        }
    }
    


    //記事内容のバリデーション
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





    //画像のバリデーション。ファイルを一時ファイルから指定ファイルへ移動しDBに記事保存
    public function imageValidate($article,$image){

        $res = false;

        $filename = basename($image['name']);
        $tmp_path = $image['tmp_name'];
        $file_err = $image['error'];
        $filesize = $image['size'];
        $upload_dir = '/Applications/MAMP/htdocs/post_travel/images/';
        $save_filename = date('Ymdhis') . $filename;
        $err_msg = array();
        $save_path = $upload_dir.$filename;

        //ファイルのバリデーション
        //ファイルサイズは1MB未満か確認
        if ($filesize > 1048576 || $file_err == 2) {
            array_push($err_msg, 'ファイルサイズを1MB未満にして下さい。');
        }
        //拡張は画像形式化
        //許可する拡張子を指定
        $allow_ext = array('jpg', 'jpeg');
        //ファイルの拡張子を取得
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
        //配列の中にあったらtrueを返すin_array  NGならメッセージを出したいので！in_array
        if (!in_array(strtolower($file_ext), $allow_ext)) {
            array_push($err_msg, 'jpeg形式の画像ファイルを添付して下さい');
        }
        
        if (count($err_msg) === 0) {
            //ファイルはあるかどうか あれば一時ファイルから指定のディレクトリに移動
            if (is_uploaded_file($tmp_path)) {
                if(move_uploaded_file($tmp_path,$upload_dir.$save_filename)){
                    $this->fileSave($article,$save_filename);
                    $this->imageResize2($save_filename,$file_ext);
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
   * 画像を記事内容をDBに保存
   * @param $filename
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
            // echo '投稿完了';
            return $result;
        }catch(PDOException $e){
            $dbh->rollBack();
            echo '接続失敗'.$e->getMessage();
        }
    }


    //画像のバリデーション。ファイルを一時ファイルから指定ファイルへ移動しDBに記事更新
    public function imageUpdate($article,$image){
        $res = false;

        $filename = basename($image['name']);
        $tmp_path = $image['tmp_name'];
        $file_err = $image['error'];
        $filesize = $image['size'];
        $upload_dir = '/Applications/MAMP/htdocs/post_travel/images/';
        $save_filename = date('Ymdhis') . $filename;
        $err_msg = array();
        $save_path = $upload_dir.$filename;

        //ファイルのバリデーション
        //ファイルサイズは1MB未満か
        if ($filesize > 1048576 || $file_err == 2) {
            array_push($err_msg, 'ファイルサイズを1MB未満にして下さい。');
        }
        //拡張は画像形式化
        //許可する拡張子を指定
        $allow_ext = array('jpg', 'jpeg');
        //ファイルの拡張子を取得
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
        //配列の中にあったらtrueを返すin_array  NGならメッセージを出したいので！in_array
        if (!in_array(strtolower($file_ext), $allow_ext)) {
            array_push($err_msg, 'jpeg形式の画像ファイルを添付して下さい');
        }
        
        if (count($err_msg) === 0) {
            //ファイルはあるかどうか あれば一時ファイルから指定のディレクトリに移動
            //リサイズしたものも保存する
            if (is_uploaded_file($tmp_path)) {
                if(move_uploaded_file($tmp_path,$upload_dir.$save_filename)){
                    $this->fileUpdate($article,$save_filename);
                    $this->imageResize2($save_filename,$file_ext);
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
                echo '更新完了';
            }catch(PDOException $e){
                $dbh->rollBack();
                echo '接続失敗'.$e->getMessage();
            }
        }

            /**
         * 画像をリサイズして保存する
         * @param $filename
         * @return bool $result
         */
        function imageResize($save_filename,$file_ext){
            $path = '/Applications/MAMP/htdocs/post_travel/images/';
            $image_before =  $path.$save_filename;
            $new = 'new';
            
            // 元の画像名を指定してサイズを取得
            list($width, $height) = getimagesize($image_before);

            $newwidth = 0; // 新しい横幅
            $newheight = 0; // 新しい縦幅
            $w = 300; // 最大横幅
            $h = 300; // 最大縦幅

            $zoom1 = $width / $w;
            $zoom2 = $height / $h;
            $zoom = ($zoom1 > $zoom2) ? $zoom1 : $zoom2;
            $newwidth  = floor($width  / $zoom);
            $newheight = floor($height / $zoom);

            // 元の画像から新しい画像を作る準備
            // if( $file_ext == IMAGETYPE_JPEG ) {
                $baseImage = imagecreatefromjpeg($image_before);
                // return $baseImage;
                // }
            // サイズを指定して新しい画像のキャンバスを作成
            $image = imagecreatetruecolor($newwidth, $newheight); 
            // 画像のコピーと伸縮
            imagecopyresampled($image, $baseImage, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            // コピーした画像を出力する
            imagejpeg($image,$new.$save_filename);
        }
    


    function imageResize2($save_filename,$file_ext){
        $path = '/Applications/MAMP/htdocs/post_travel/images/';
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
        // if( $file_ext == IMAGETYPE_JPEG ) {
            $baseImage= imagecreatefromjpeg($image_before);
            // return $baseImage;
            // }
        // 画像のコピーと伸縮
        imagecopyresampled($image, $baseImage, $cutwidth, $cutheight, 0, 0, $rewidth, $reheight, $width, $height);
        // コピーした画像を出力する
        imagejpeg($image,$new.$save_filename);
    }
}
        
//エラーでページを戻して反映させる仕様
// $err = [];

// if(!$title = filter_input(INPUT_POST,'title')){
//     $err[] = 'タイトルを入力して下さい。';
// }
// if(!$content = filter_input(INPUT_POST,'content')){
//     $err[] = '本文を入力して下さい。';
// }

// //エラーがなかったときの処理
// if(count($err) === 0){

// }
// //エラーがあった場合
// if(count($err) < 0){
//     header('Location:form.php');
//     return;
// }
