<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class Messages extends PublicController {
    public function run() :void
    {
        $viewData = array(
            "edit_enabled"=>true,
            "delete_enabled"=>true,
            "new_enabled"=>true
        );
        $viewData["messages"] = \Dao\Mnt\Messages::findAll();
        Renderer::render('mnt/messages', $viewData);}
}
?>