<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class Index extends PublicController {
    public function run() :void
    {
        $viewData = array();
        Renderer::render('mnt/index', $viewData); //Redireccionamiento a la vista
    }
}
?>
