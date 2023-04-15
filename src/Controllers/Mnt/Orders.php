<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class Orders extends PublicController {
    public function run() :void
    {
        $viewData = array(
            "edit_enabled"=>true,
            "delete_enabled"=>true,
            "new_enabled"=>true
        );
        $viewData["orders"] = \Dao\Mnt\Orders::findAll();
        Renderer::render('mnt/orders', $viewData);
    }
}
?>