<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

require_once '/home/xs115618/oiwa1105.com/public_html/post_travel/config/dbconnect.php';

//新規登録・ログイン関連
Class LoginClass extends Dbc{
    
    /**
     * ユーザを登録する
     * @param array $userData
     * @return bool $result
     */
    public function createUser($userData){
        $result = false;
        $sql ="INSERT INTO 
                    member(name,email,password) 
                VALUE 
                    (?,?,?)"; 
        $arr = [];
        $arr[] = $userData['username'];
        $arr[] = $userData['email'];
        $arr[] = password_hash($userData['password'],PASSWORD_DEFAULT);

        try{
            $dbh = $this->dbconnect();
            $dbh->beginTransaction();
            $stmt = $dbh->prepare($sql);
            $result = $stmt->execute($arr);
            $dbh->commit();
            return $result;
        }catch(\PDOException $e){
            $dbh->rollBack();
            echo $e->getMessage();
        return  $result;
        }
    }


    /**
     * ユーザの県テーブル作成
     * @param array $id_member メンバーID
     * @return bool $result
     */
    public function createPref($id_member){
        $result = false;
        $sql ="INSERT INTO 
                    prefecture(id_member)
                VALUE 
                    (:id_member)"; 
        try{
            $dbh = $this->dbconnect();
            $dbh->beginTransaction();
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id_member',$id_member,PDO::PARAM_STR);
            $result = $stmt->execute();
            $dbh->commit();
            return $result;
        }catch(\PDOException $e){
            $dbh->rollBack();
            echo $e->getMessage();
        return  $result;
        }
    }


    /**
     * emailからユーザ情報取得
     * @param string $email 
     * @return array|bool $user|false
     */
    public function getUserByEmail($email){
        $sql ='SELECT *
                FROM member 
                WHERE email = ?'; 
        $arr = [];
        $arr[] = $email;
        try{
            $dbh = $this->dbconnect();
            $dbh->beginTransaction();
            $stmt = $dbh->prepare($sql);
            $dbh->commit();
            $stmt->execute($arr);
            $user = $stmt->fetch();
            return $user;
        }catch(\PDOException $e){
            $dbh->rollBack();
            echo $e->getMessage();
        return  false;
        }
    }


    /**
     * ログイン処理
     * @param string $email
     * @param string $password
     * @return bool $result 
     */
    public function login($email,$password){
        $result = false;
        $user = $this->getUserByEmail($email); //メールアドレスからユーザ情報を取得

         //emailがDBに保存されていない場合→エラーメッセージ
        if(!$user){
            $_SESSION['msg'] = 'emailが一致しません。';
            return $result;
        }
        //パスワード照会
        if(password_verify($password,$user['password'])){
            //ログイン成功→セッション再生成
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;
        }
            $_SESSION['msg'] = 'パスワードが一致しません。';
            return $result;
    } 


    /**
     * ログインチェック
     * @param  void
     * @return bool $result 
     */
    public function checkLogin(){
        $result = false;
        //セッションにログインユーザが入っていなければfalseを返す
        if(isset($_SESSION['login_user']) && $_SESSION['login_user']['id_member'] > 0){
            return $result = true;
        }
        return $result;
    }

    /**
     * ログアウト処理
     * @param void
     */
    public static function logout(){
        $_SESSION = array();
        session_destroy();
    }



}

