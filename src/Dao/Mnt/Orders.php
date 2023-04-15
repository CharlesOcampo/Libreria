<?php
namespace Dao\Mnt;  

use Dao\Table;

class Orders extends Table{

    public static function insert(
        int $user_id, 
        string $nameu, 
        string $cel, 
        string $email, 
        string $method, 
        string $addressu, 
        string $total_products, 
        int $total_price, 
        string $payment_status): int
    {
        $sqlstr = "INSERT INTO orders (user_id, nameu, cel, email, method, addressu, total_products, total_price, payment_status) 
        values(:user_id, :nameu, :cel, :email, :method, :addressu, :total_products, :total_price, :payment_status);";
        $rowsInserted = self::executeNonQuery(
            $sqlstr,
            array(
                "user_id" => $user_id, 
                "nameu"=>$nameu, 
                "cel"=>$cel, 
                "email"=>$email, 
                "method"=>$method, 
                "addressu"=>$addressu, 
                "total_products"=>$total_products, 
                "total_price"=>$total_price, 
                "payment_status"=>$payment_status)
        );
        return $rowsInserted;
    }
    public static function update(
        int $user_id,
        string $nameu, 
        string $cel, 
        string $email, 
        string $method, 
        string $addressu,
        string $total_products, 
        int $total_price, 
        string $payment_status,
        int $id
    ){
        $sqlstr = "UPDATE orders set 
            user_id = :user_id,
            nameu = :nameu, 
            cel = :cel, 
            email = :email,
            method = :method, 
            addressu = :addressu, 
            total_products = :total_products, 
            total_price = :total_price, 
            payment_status = :payment_status   where id=:id;";
        $rowsUpdated = self::executeNonQuery(
            $sqlstr,
            array(
                "user_id" => $user_id,
                "nameu" => $nameu,
                "cel" => $cel,
                "email" => $email,
                "method" => $method,
                "addressu" => $addressu,
                "total_products" => $total_products,
                "total_price" => $total_price,
                "payment_status" => $payment_status,
                "id" => $id,
            )
        );
        return $rowsUpdated;
    }
    public static function delete(int $id){
        $sqlstr = "DELETE from orders where id=:id;";
        $rowsDeleted = self::executeNonQuery(
            $sqlstr,
            array(
                "id" => $id
            )
        );
        return $rowsDeleted;
    }
    public static function findAll(){
        $sqlstr = "SELECT * from orders;";
        return self::obtenerRegistros($sqlstr, array());
    }
    public static function findByFilter(){

    }
    public static function findById(int $id){
        $sqlstr = "SELECT * from orders where id = :id;";
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