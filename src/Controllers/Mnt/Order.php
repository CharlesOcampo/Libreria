<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Exception;
use Views\Renderer;

class Order extends PublicController{
    private $redirectTo = "index.php?page=Mnt-Orders";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "id" => 0,
        "user_id" => 0,
        "nameu" => "",
        "cel" => "",
        "email" => "",
        "method" => "",
        "addressu" => "",
        "total_products" => "",
        "total_price" => 0,
        "payment_status" => "Pendiente",
        "payment_status_Pendiente" => "selected",
        "payment_status_Completado" => "",
        "name_error"=> "",
        "general_errors"=> array(),
        "has_errors" =>false,
        "show_action" => true,
        "readonly" => false,
    );
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nueva Orden",
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
            error_log(sprintf("Controller/Mnt/Order ERROR: %s", $error->getMessage()));
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
            if(\Utilities\Validators::IsEmpty($_POST["user_id"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["name_error"] = "El id no puede ir vacío!";
            }
        } else {
            throw new Exception("Id not present in form");
        }
        if(isset($_POST["nameu"])){
            if(\Utilities\Validators::IsEmpty($_POST["nameu"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["name_error"] = "El Nombre no puede ir vacío!";
            }
        } else {
            throw new Exception("Nombre not present in form");
        }
        if(isset($_POST["cel"])){
            if(\Utilities\Validators::IsEmpty($_POST["cel"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["name_error"] = "El Telefono no puede ir vacío!";
            }
        } else {
            throw new Exception("Telefono not present in form");
        }
        if(isset($_POST["email"])){
            if(\Utilities\Validators::IsEmpty($_POST["email"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["name_error"] = "El Correo no puede ir vacío!";
            }
        } else {
            throw new Exception("Correo not present in form");
        }
        if(isset($_POST["method"])){
            if(\Utilities\Validators::IsEmpty($_POST["method"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["name_error"] = "El Metodo no puede ir vacío!";
            }
        } else {
            throw new Exception("Metodo not present in form");
        }
        if(isset($_POST["addressu"])){
            if(\Utilities\Validators::IsEmpty($_POST["addressu"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["name_error"] = "La dirección no puede ir vacío!";
            }
        } else {
            throw new Exception("Dirección not present in form");
        }
        if(isset($_POST["total_products"])){
            if(\Utilities\Validators::IsEmpty($_POST["total_products"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["name_error"] = "La cantidad de productos no puede ir vacío!";
            }
        } else {
            throw new Exception("Total Productos not present in form");
        }
        if(isset($_POST["total_price"])){
            if(\Utilities\Validators::IsEmpty($_POST["total_price"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["name_error"] = "El Precio Total no puede ir vacío!";
            }
        } else {
            throw new Exception("Precio not present in form");
        }
      
        if(isset($_POST["payment_status"])){
            if (!in_array( $_POST["payment_status"], array("Pendiente","Completo"))){
                throw new Exception("payment_status incorrect value");
            }
        }else {
            if($this->viewData["mode"]!=="DEL") {
                throw new Exception("Ordersstatus not present in form");
            }
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
                throw new Exception("Ordersid value is different from query");
            }
        }else {
            throw new Exception("Orderid not present in form");
        }
        $this->viewData["user_id"] = $_POST["user_id"];
        $this->viewData["nameu"] = $_POST["nameu"];
        $this->viewData["cel"] = $_POST["cel"];
        $this->viewData["email"] = $_POST["email"];
        $this->viewData["method"] = $_POST["method"];
        $this->viewData["addressu"] = $_POST["addressu"];
        $this->viewData["total_products"] = $_POST["total_products"];
        $this->viewData["total_price"] = $_POST["total_price"];
        if($this->viewData["mode"]!=="DEL"){
            $this->viewData["payment_status"] = $_POST["payment_status"];
        }
    }
    private function executeAction(){
        switch($this->viewData["mode"]){
            case "INS":
                $inserted = \Dao\Mnt\Orders::insert(
                    $this->viewData["user_id"],
                    $this->viewData["nameu"],
                    $this->viewData["cel"],
                    $this->viewData["email"],
                    $this->viewData["method"],
                    $this->viewData["addressu"],
                    $this->viewData["total_products"],
                    $this->viewData["total_price"],
                    $this->viewData["payment_status"]
                );
                if($inserted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Orden Creada Exitosamente"
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Orders::update(
                    $this->viewData["user_id"],
                    $this->viewData["nameu"],
                    $this->viewData["cel"],
                    $this->viewData["email"],
                    $this->viewData["method"],
                    $this->viewData["addressu"],
                    $this->viewData["total_products"],
                    $this->viewData["total_price"],
                    $this->viewData["payment_status"],
                    $this->viewData["id"]
                );
                if($updated > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Orden Actualizada Exitosamente"
                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Orders::delete(
                    $this->viewData["id"]
                );
                if($deleted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Orden Eliminada Exitosamente"
                    );
                }
                break;
        }
    }
    private function render(){
        if($this->viewData["mode"] === "INS") {
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpOrders = \Dao\Mnt\Orders::findById($this->viewData["id"]);
            if(!$tmpOrders){
                throw new Exception("Orden no existe en DB");
            }
           
            \Utilities\ArrUtils::mergeFullArrayTo($tmpOrders, $this->viewData);
            $this->viewData["payment_status_Pendiente"] = $this->viewData["payment_status"] === "Pendiente" ? "selected": "";
            $this->viewData["payment_status_Completado"] = $this->viewData["payment_status"] === "Completado" ? "selected": ""; 
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["user_id"],
                $this->viewData["nameu"],
                $this->viewData["cel"],
                $this->viewData["email"],
                $this->viewData["method"],
                $this->viewData["addressu"],
                $this->viewData["total_products"],
                $this->viewData["total_price"],
                $this->viewData["payment_status"],
                $this->viewData["id"]
            );
            if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                $this->viewData["readonly"] = "readonly";
            }
            if($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/order", $this->viewData);
    }
}
?>