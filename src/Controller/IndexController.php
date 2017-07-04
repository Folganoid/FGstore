<?php

namespace Fg\Controller;

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
        $this->render($this->getViewFile(ROOTDIR . '/web/pages/index.html.twig'));
    }
}

?>
