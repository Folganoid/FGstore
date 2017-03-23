<?php

namespace Fg;

use Fg\Frame\Controller\Controller;

/**
 * Class IndexController
 * @package Fg
 */
class IndexController extends MainController
{
    /**
     * index
     */
    public function index()
    {

        $aaa = new Controller($this->configDir);
        $aaa->render(__DIR__ . '/../web/pages/index.html.twig');




    }
}

?>
