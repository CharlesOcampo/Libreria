<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class Products extends PublicController {
    public function run() :void
    {
        $viewData = array(
            "edit_enabled"=>true,
            "delete_enabled"=>true,
            "new_enabled"=>true
        );
        $viewData["products"] = \Dao\Mnt\Products::findAll();
        Renderer::render('mnt/products', $viewData);
    }
}
?>