<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

require_once '/home/xs115618/oiwa1105.com/public_html/post_travel/config/dbconnect.php';



Class Prefecture extends Dbc{


    /**
   * 県別テーブルに色を保存
   * @param $filename
   * @return bool $result
   */
    public function prefColor($id_member,$pref_name,$pref_color){
        $sql = "UPDATE prefecture 
                    SET $pref_name = :pref_color
                    WHERE id_member = :id_member";
        $dbh = $this->dbconnect();
        $dbh->beginTransaction();
        try{
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id_member',$id_member,PDO::PARAM_INT);
            $stmt->bindValue(':pref_color',$pref_color,PDO::PARAM_STR);
            $stmt->execute();
            $dbh->commit();
            header('Location:./prefpage.php');
        }catch(PDOException $e){
            $dbh->rollBack();
            echo '接続失敗'.$e->getMessage();
        }
    }
    
    //DBに保存されている色をCSSに反映される

    public function getPrefColor($id_member){
        try{
            $dbh = $this->dbconnect();
            $sql = 'SELECT hokkaido,aomori,iwate,akita,miyagi,yamagata,fukushima,niigata,ibaraki,tochigi,gunma,chiba,saitama,tokyo,kanagawa,yamanashi,nagano,toyama,ishikawa,shizuoka,aichi,gifu,fukui,shiga,mie,wakayama,nara,
            kyoto,osaka,hyogo, okayama,hiroshima,yamaguchi,tottori,shimane,kagawa,tokushima,ehime,kochi,fukuoka,oita,miyazaki,kagoshima,kumamoto,saga,nagasaki,okinawa                    
            FROM prefecture WHERE id_member = :id_member';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id_member',(int)$id_member,PDO::PARAM_INT);
            $stmt->execute(); 
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
            $dbh = null;
        }catch(\PDOException $e){
            echo $e->getMessage();
        return  false;   
        }
    }


    
}

