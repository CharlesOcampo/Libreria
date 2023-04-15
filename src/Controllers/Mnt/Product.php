<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Exception;
use Views\Renderer;

class Product extends PublicController{
    private $redirectTo = "index.php?page=Mnt-Products";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "id" => 0,
        "namep" => "",
        "price" => 0,
        "quantity" => "",
        "descriptionp" => "",
        "imagep" => "",
        "name_error"=> "",
        "general_errors"=> array(),
        "has_errors" =>false,
        "show_action" => true,
        "readonly" => false,
    );
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nuevo Producto",
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
            error_log(sprintf("Controller/Mnt/Product ERROR: %s", $error->getMessage()));
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
        if(isset($_POST["namep"])){
            if(\Utilities\Validators::IsEmpty($_POST["namep"])){
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
        if(isset($_POST["descriptionp"])){
            if(\Utilities\Validators::IsEmpty($_POST["descriptionp"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["name_error"] = "La descripción no puede ir vacía!";
            }
        } else {
            throw new Exception("Description not present in form");
        }
        if(isset($_POST["imagep"])){
            if(\Utilities\Validators::IsEmpty($_POST["imagep"])){
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
                throw new Exception("Ordersid is not Valid");
            }
            if($this->viewData["id"]!== intval($_POST["id"])){
                throw new Exception("Productid value is different from query");
            }
        }else {
            throw new Exception("Productid not present in form");
        }
        $this->viewData["namep"] = $_POST["namep"];
        $this->viewData["price"] = $_POST["price"];
        $this->viewData["quantity"] = $_POST["quantity"];
        $this->viewData["descriptionp"] = $_POST["descriptionp"];
        $this->viewData["imagep"] = $_POST["imagep"];
    }
    private function executeAction(){
        switch($this->viewData["mode"]){
            case "INS":
                $inserted = \Dao\Mnt\Products::insert(
                    $this->viewData["namep"],
                    $this->viewData["price"],
                    $this->viewData["quantity"],
                    $this->viewData["descriptionp"],
                    $this->viewData["imagep"]
                );
                if($inserted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Producto Agregado Exitosamente"
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Products::update(
                    $this->viewData["namep"],
                    $this->viewData["price"],
                    $this->viewData["quantity"],
                    $this->viewData["descriptionp"],
                    $this->viewData["imagep"],
                    $this->viewData["id"]
                );
                if($updated > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Producto Actualizado Exitosamente"
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
                        "Producto Eliminado Exitosamente"
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
                throw new Exception("Producto no existe en DB");
            }
           
           
            \Utilities\ArrUtils::mergeFullArrayTo($tmpProducts, $this->viewData);
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["namep"],
                $this->viewData["price"],
                $this->viewData["quantity"],
                $this->viewData["descriptionp"],
                $this->viewData["imagep"],
                $this->viewData["id"]
            );
            if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                $this->viewData["readonly"] = "readonly";
            }
            if($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/product", $this->viewData);
    }
}
?>