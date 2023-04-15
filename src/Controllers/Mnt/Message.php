<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Exception;
use Views\Renderer;

class Message extends PublicController{
    private $redirectTo = "index.php?page=Mnt-Messages";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "id" => 0,
        "user_id" => 0,
        "namem" => "",
        "email" => "",
        "cel" => "",
        "messagem" => "",
        "namem_error"=> "",
        "user_id_error"=> "",
        "cel_error"=> "",
        "message_error"=> "",
        "email_error"=> "",
        "general_errors"=> array(),
        "has_errors" =>false,
        "show_action" => true,
        "readonly" => false,
    );
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nuevo Mensaje",
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
            unset($_SESSION["xssToken_Mnt_Message"]);
            error_log(sprintf("Controller/Mnt/Message ERROR: %s", $error->getMessage()));
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
        if(isset($_POST["xssToken"])){
            if(isset($_SESSION["xssToken_Mnt_Message"])){
                if($_POST["xssToken"] !== $_SESSION["xssToken_Mnt_Message"]){
                    throw new Exception("Invalid Xss Token no match");
                }
            }else{
                throw New Exception("INVALID XSS TOKEN on SESSION");
            }
        }else{
            throw New Exception("INVALID XSS TOKEN");
        }
        if(isset($_POST["user_id"])){
            if(\Utilities\Validators::IsEmpty($_POST["user_id"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["user_id_error"] = "El id no puede ir vacío!";
            }
        } else {
            throw new Exception("Id not present in form");
        }

        if(isset($_POST["namem"])){
            if(\Utilities\Validators::IsEmpty($_POST["namem"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["namem_error"] = "El Nombre no puede ir vacío!";
            }
        } else {
            throw new Exception("Nombre not present in form");
        }

        if(isset($_POST["email"])){
            if(\Utilities\Validators::IsEmpty($_POST["email"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["email_error"] = "El Correo no puede ir vacío!";
            }
        } else {
            throw new Exception("Correo not present in form");
        }

        if(isset($_POST["cel"])){
            if(\Utilities\Validators::IsEmpty($_POST["cel"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["cel_error"] = "El Telefono no puede ir vacío!";
            }
        } else {
            throw new Exception("Telefono not present in form");
        }

        if(isset($_POST["messagem"])){
            if(\Utilities\Validators::IsEmpty($_POST["messagem"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["messagem_error"] = "El mensaje no puede ir vacío!";
            }
        } else {
            throw new Exception("Message not present in form");
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
                throw new Exception("Message id is not Valid");
            }
            if($this->viewData["id"]!== intval($_POST["id"])){
                throw new Exception("Message id value is different from query");
            }
        }else {
            throw new Exception("Message id not present in form");
        }
        $this->viewData["user_id"] = $_POST["user_id"];
        $this->viewData["namem"] = $_POST["namem"];
        $this->viewData["email"] = $_POST["email"];
        $this->viewData["cel"] = $_POST["cel"];
        $this->viewData["messagem"] = $_POST["messagem"];
        
    }
    private function executeAction(){
        switch($this->viewData["mode"]){
            case "INS":
                $inserted = \Dao\Mnt\Messages::insert(
                    $this->viewData["user_id"],
                    $this->viewData["namem"],
                    $this->viewData["email"],
                    $this->viewData["cel"],
                    $this->viewData["messagem"],
                );
                if($inserted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Mensaje Creada Exitosamente"
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Messages::update(
                    $this->viewData["user_id"],
                    $this->viewData["namem"],
                    $this->viewData["email"],
                    $this->viewData["cel"],
                    $this->viewData["messagem"],
                    $this->viewData["id"]
                );
                if($updated > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Mensaje Actualizado Exitosamente"
                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Messages::delete(
                    $this->viewData["id"]
                );
                if($deleted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Mensaje Eliminado Exitosamente"
                    );
                }
                break;
        }
    }
    private function render(){
        $xssToken = md5("MESSAGE" . rand(0,4000) * rand(5000,9999));
        $this->viewData["xssToken"] = $xssToken;
        $_SESSION["xssToken_Mnt_Message"] = $xssToken;
        if($this->viewData["mode"] === "INS") {
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpMensajes = \Dao\Mnt\Messages::findById($this->viewData["id"]);
            if(!$tmpMensajes){
                throw new Exception("Mensaje no existe en DB");
            }
           
            \Utilities\ArrUtils::mergeFullArrayTo($tmpMensajes, $this->viewData);
             
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["user_id"],
                $this->viewData["namem"],
                $this->viewData["email"],
                $this->viewData["cel"],
                $this->viewData["messagem"],
                $this->viewData["id"]
            );
            if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                $this->viewData["readonly"] = "readonly";
            }
            if($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/message", $this->viewData);}
    }
?>