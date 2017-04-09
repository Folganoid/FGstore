<?php

namespace Fg;

use Fg\Frame\Controller\Controller;
use Fg\Frame\DI\Service;
use Fg\Frame\Validation\Validation;

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
        $this->render($this->getViewFile(__DIR__ . '/../web/pages/index.html.twig'));
    }
}

?>
