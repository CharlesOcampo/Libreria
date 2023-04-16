<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class Carts extends PublicController {
    public function run() :void
    {
        $viewData = array(
            "edit_enabled"=>true,
            "delete_enabled"=>true,
            "new_enabled"=>true
        );
        $viewData["carts"] = \Dao\Mnt\Carts::findAll();
        Renderer::render('mnt/carts', $viewData);
    }
}
?>