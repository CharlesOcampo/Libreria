<?php 
namespace Dao\Mnt;

use Dao\Table;

class Products extends Table{

    public static function insert(
        string $namep, 
        int $price, 
        int $quantity,
        string $descriptionp , 
        string $imagep): int
    {
        $sqlstr = "INSERT INTO products (
            namep, 
            price, 
            descriptionp, 
            imagep) values
            (:namep, 
            :price, 
            :quantity,
            :descriptionp, 
            :imagep);";
        $rowsInserted = self::executeNonQuery(
            $sqlstr,
            array(
            "namep" => $namep,
            "price"=>$price, 
            "quantity"=>$quantity,
            "descriptionp"=>$descriptionp, 
            "imagep"=>$imagep)
        );
        return $rowsInserted;
    }
    public static function update(
        string $namep,
        int $price,
        int $quantity, 
        string $descriptionp, 
        string $imagep,
        int $id
    ){
        $sqlstr = "UPDATE products set 
            namep = :namep, 
            price = :price, 
            quantity = :quantity,
            descriptionp = :descriptionp, 
            imagep = :imagep where id=:id;";
        $rowsUpdated = self::executeNonQuery(
            $sqlstr,
            array(
                "namep" => $namep,
                "price" => $price,
                "quantity" => $quantity,
                "descriptionp" => $descriptionp,
                "imagep" => $imagep,
                "id" => $id,
            )
        );
        return $rowsUpdated;
    }
    public static function delete(int $id){
        $sqlstr = "DELETE from products where id=:id;";
        $rowsDeleted = self::executeNonQuery(
            $sqlstr,
            array(
                "id" => $id
            )
        );
        return $rowsDeleted;
    }
    public static function findAll(){
        $sqlstr = "SELECT * from products;";
        return self::obtenerRegistros($sqlstr, array());
    }
    public static function findByFilter(){

    }
    public static function findById(int $id){
        $sqlstr = "SELECT * from products where id = :id;";
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