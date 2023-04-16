<?php
namespace Dao\Mnt;  

use Dao\Table;

class Carts extends Table{

    public static function insert(
        int $user_id, 
        string $namem, 
        string $price, 
        string $quantity, 
        string $imagene,):int 
       
    {
        $sqlstr = "INSERT INTO cart (user_id, namem, price, quantity, imagene,) 
        values(:user_id, :namem, :price, :quantity, :imagene);";
        $rowsInserted = self::executeNonQuery(
            $sqlstr,
            array(
                "user_id" => $user_id, 
                "nameu"=>$namem, 
                "price"=>$price, 
                "quantity"=>$quantity, 
                "imagene"=>$imagene,) 
        );
        return $rowsInserted;
    }
    public static function update(
        int $id,
        int $user_id, 
        string $namem, 
        string $price, 
        string $quantity, 
        string $imagene, 
        
    ){
        $sqlstr = "UPDATE cart set 
            user_id = :user_id,
            namem = :namem, 
            price = :price, 
            quantity = :quantity, 
            imagene = :imagene, where id=:id;";
        $rowsUpdated = self::executeNonQuery(
            $sqlstr,
            array(
                "user_id" => $user_id,
                "namem" => $namem,
                "price" => $price,
                "quantity" => $quantity,
                "imagene" => $imagene,
                "id" => $id,
            )
        );
        return $rowsUpdated;
    }
    public static function delete(int $id){
        $sqlstr = "DELETE from cart where id=:id;";
        $rowsDeleted = self::executeNonQuery(
            $sqlstr,
            array(
                "id" => $id
            )
        );
        return $rowsDeleted;
    }
    public static function findAll(){
        $sqlstr = "SELECT * from cart;";
        return self::obtenerRegistros($sqlstr, array());
    }
    public static function findByFilter(){

    }
    public static function findById(int $id){
        $sqlstr = "SELECT * from cart where id = :id;";
        $row = self::obtenerUnRegistro(
            $sqlstr,
            array(
                "id"=> $id
            )
        );
        return $row;
    }
}
?>