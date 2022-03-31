<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

require_once '/home/xs115618/oiwa1105.com/public_html/post_travel/config/dbconnect.php';

//県テーブル関連
Class Prefecture extends Dbc{


    /**
   * 県テーブルに色を保存する
   * @param int $id_member メンバーID
   * @param string  $pref_name 県名
   * @param string $pref_color 指定された色コード
   * @return void
   */
    public function prefColor($id_member,$pref_name,$pref_color){
        $sql = "UPDATE 
                    prefecture 
                SET
                    $pref_name = :pref_color
                WHERE
                    id_member = :id_member";
        $dbh = $this->dbconnect();
        $dbh->beginTransaction();
        try{
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id_member',$id_member,PDO::PARAM_INT);
            $stmt->bindValue(':pref_color',$pref_color,PDO::PARAM_STR);
            $stmt->execute();
            $dbh->commit();
            header('Location:./prefpage.php');
        }catch(\PDOException $e){
            $dbh->rollBack();
            echo $e->getMessage();
        }
    }
    

    /**
     * DBに保存されて色をCSSに反映させる
     * @param int $id_member メンバーID
     * @return bool $result
     */
    public function getPrefColor($id_member){
        try{
            $dbh = $this->dbconnect();
        $dbh->beginTransaction();
        $sql = 'SELECT 
                        hokkaido,aomori,iwate,akita,miyagi,yamagata,fukushima,niigata,ibaraki,tochigi,gunma,chiba,saitama,tokyo,kanagawa,yamanashi,nagano,toyama,ishikawa,shizuoka,aichi,gifu,fukui,shiga,mie,wakayama,nara,kyoto,osaka,hyogo, okayama,hiroshima,yamaguchi,tottori,shimane,kagawa,tokushima,ehime,kochi,fukuoka,oita,miyazaki,kagoshima,kumamoto,saga,nagasaki,okinawa                    
                    FROM 
                        prefecture 
                    WHERE
                        id_member = :id_member';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id_member',(int)$id_member,PDO::PARAM_INT);
            $stmt->execute(); 
            $dbh->commit();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }catch(\PDOException $e){
            $dbh->rollBack();
            echo $e->getMessage();
        return  false;   
        }
    }

 
    /**
     * DBから県カラムを取得、県ごとに投稿件数をカウント 
     * カウント数に応じて色を代入し、cssに反映させる
     * @param void
     * @return array|bool  $result | false
     */
    function getPref(){
        try{
            $art = new Article('article');
            $dbh = $art->dbconnect();
            $sql = 'SELECT prefecture FROM article';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            $dbh = null;
        }catch(\PDOException $e){
        echo $e->getMessage();
        return  false;   
        }
    }




}
