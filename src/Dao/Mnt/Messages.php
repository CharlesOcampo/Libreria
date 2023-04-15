<?php
namespace Dao\Mnt;  

use Dao\Table;

class Messages extends Table{

    public static function insert(
        int $user_id, 
        string $namem, 
        string $email, 
        string $cel, 
        string $messagem) : int
    {
        $sqlstr = "INSERT INTO messagem (user_id, namem, email, cel , messagem) 
        values(:user_id, :namem, :email, :cel, :messagem);";
        $rowsInserted = self::executeNonQuery(
            $sqlstr,
            array(
                "user_id" => $user_id, 
                "namem"=>$namem, 
                "email"=>$email, 
                "cel"=>$cel, 
                "messagem"=>$messagem)
        );
        return $rowsInserted;
    }
    public static function update(
        int $user_id,
        string $namem, 
        string $email,
        string $cel,  
        string $messagem,
        int $id
    ){
        $sqlstr = "UPDATE messagem set 
            user_id = :user_id,
            namem = :namem,
            email = :email, 
            cel = :cel, 
            messagem = :messagem   where id=:id;";
        $rowsUpdated = self::executeNonQuery(
            $sqlstr,
            array(
                "user_id" => $user_id, 
                "namem"=>$namem, 
                "email"=>$email, 
                "cel"=>$cel, 
                "messagem"=>$messagem,
                "id" => $id
            )
        );
        return $rowsUpdated;
    }
    public static function delete(int $id){
        $sqlstr = "DELETE from messagem where id=:id;";
        $rowsDeleted = self::executeNonQuery(
            $sqlstr,
            array(
                "id" => $id
            )
        );
        return $rowsDeleted;
    }
    public static function findAll(){
        $sqlstr = "SELECT * from messagem;";
        return self::obtenerRegistros($sqlstr, array());
    }
    public static function findByFilter(){

    }
    public static function findById(int $id){
        $sqlstr = "SELECT * from messagem where id = :id;";
        $row = self::obtenerUnRegistro(
            $sqlstr,
            array(
                "id"=> $id
            )
        );
        return $row;
    }
}
?>x