<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class Catalogo extends PublicController {
    public function run() :void
    {
        $viewData = array();
        Renderer::render('mnt/catalogo', $viewData); //Redireccionamiento a la vista
    }
}
?>
