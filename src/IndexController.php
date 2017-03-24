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
        $this->setViewFile(__DIR__ . '/../web/pages/index.html.twig');

        $aaa = new Controller($this->configDir);
        $aaa->render($this->getViewFile());

    }
}

?>
