<?php

namespace Fg;

use Fg\Frame\Controller\Controller;

/**
 * Class IndexController
 * @package Fg
 */
class IndexController extends Controller
{
    /**
     * index
     */
    public function index()
    {
        $this->setViewFile(__DIR__ . '/../web/pages/index.html.twig');
        $this->render($this->getViewFile());

    }
}

?>
