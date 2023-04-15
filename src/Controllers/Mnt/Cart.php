<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Exception;
use Views\Renderer;

class cart extends PublicController{
    private $redirectTo = "index.php?page=Mnt-Cart";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "id" => 0,
        "user_id" => 0,
        "namem" => "",
        "price" => 0,
        "quantity" => "",
        "imagene" => "",
        "name_error"=> "",
        "general_errors"=> array(),
        "has_errors" =>false,
        "show_action" => true,
        "readonly" => false,
    );
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nueva Cart",
        "UPD" => "Editar %s (%s)",
        "DEL" => "Borrar %s (%s)"
    );
    public function run() :void
    {
        try {
            $this->page_loaded();
            if($this->isPostBack()){
                $this->validatePostData();
                if(!$this->viewData["has_errors"]){
                    $this->executeAction();
                }
            }
            $this->render();
        } catch (Exception $error) {
            error_log(sprintf("Controller/Mnt/Cart ERROR: %s", $error->getMessage()));
            \Utilities\Site::redirectToWithMsg(
                $this->redirectTo,
                "Algo Inesperado Sucedió. Intente de Nuevo."
            );
        }

    }

    private function page_loaded()
    {
        if(isset($_GET['mode'])){
            if(isset($this->modes[$_GET['mode']])){
                $this->viewData["mode"] = $_GET['mode'];
            } else {
                throw new Exception("Mode Not available");
            }
        } else {
            throw new Exception("Mode not defined on Query Params");
        }
        if($this->viewData["mode"] !== "INS") {
            if(isset($_GET['id'])){
                $this->viewData["id"] = intval($_GET["id"]);
            } else {
                throw new Exception("Id not found on Query Params");
            }
        }
    }


    private function validatePostData(){
        if(isset($_POST["user_id"])){
            if(\Utilities\Validators::IsEmpty($_POST["namem"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["name_error"] = "El Id de usuario no puede ir vacío!";
            }
        } else {
            throw new Exception("Id not present in form");
        }
        if(isset($_POST["namem"])){
            if(\Utilities\Validators::IsEmpty($_POST["namem"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["name_error"] = "El Nombre no puede ir vacío!";
            }
        } else {
            throw new Exception("Nombre not present in form");
        }
        if(isset($_POST["price"])){
            if(\Utilities\Validators::IsEmpty($_POST["price"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["name_error"] = "El precio no puede ir vacío!";
            }
        } else {
            throw new Exception("Precio not present in form");
        }
        if(isset($_POST["quantity"])){
            if(\Utilities\Validators::IsEmpty($_POST["qunatity"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["name_error"] = "La descripción no puede ir vacía!";
            }
        } else {
            throw new Exception("Description not present in form");
        }
        if(isset($_POST["imagene"])){
            if(\Utilities\Validators::IsEmpty($_POST["imagene"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["name_error"] = "La Url no puede ir vacía!";
            }
        } else {
            throw new Exception("Imagen not present in form");
        }
        if(isset($_POST["mode"])){
            if(!key_exists($_POST["mode"], $this->modes)){
                throw new Exception("mode has a bad value");
            }
            if($this->viewData["mode"]!== $_POST["mode"]){
                throw new Exception("mode value is different from query");
            }
        }else {
            throw new Exception("mode not present in form");
        }
        if(isset($_POST["id"])){
            if(($this->viewData["mode"] !== "INS" && intval($_POST["id"])<=0)){
                throw new Exception("Cartid is not Valid");
            }
            if($this->viewData["id"]!== intval($_POST["id"])){
                throw new Exception("Cartid value is different from query");
            }
        }else {
            throw new Exception("Cartid not present in form");
        }
        $this->viewData["user_id"] = $_POST["user_id"];
        $this->viewData["nameu"] = $_POST["namep"];
        $this->viewData["price"] = $_POST["price"];
        $this->viewData["quantity"] = $_POST["quantity"];
        $this->viewData["imagene"] = $_POST["imagene"];
    }
    private function executeAction(){
        switch($this->viewData["mode"]){
            case "INS":
                $inserted = \Dao\Mnt\Carts::insert(
                    $this->viewData["user_id"],
                    $this->viewData["namem"],
                    $this->viewData["price"],
                    $this->viewData["quantity"],
                    $this->viewData["imagene"]
                );
                if($inserted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Cart Agregado Exitosamente"
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Carts::update(
                    $this->viewData["user_id"],
                    $this->viewData["namem"],
                    $this->viewData["price"],
                    $this->viewData["quantity"],
                    $this->viewData["imagene"],
                    $this->viewData["id"]
                );
                if($updated > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Cart Actualizado Exitosamente"
                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Products::delete(
                    $this->viewData["id"]
                );
                if($deleted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Cart Eliminado Exitosamente"
                    );
                }
                break;
        }
    }
    private function render(){
        if($this->viewData["mode"] === "INS") {
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpProducts = \Dao\Mnt\Products::findById($this->viewData["id"]);
            if(!$tmpProducts){
                throw new Exception("Cart no existe en DB");
            }
           
           
            \Utilities\ArrUtils::mergeFullArrayTo($tmpProducts, $this->viewData);
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["user_id"],
                $this->viewData["namem"],
                $this->viewData["price"],
                $this->viewData["quantity"],
                $this->viewData["imagene"],
                $this->viewData["id"]
            );
            if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                $this->viewData["readonly"] = "readonly";
            }
            if($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/cart", $this->viewData);
    }
}
?>