<?php

namespace Fg;

use Fg\Frame\Controller\Controller;

/**
 * Class ItemController
 * @package Fg
 */
class ItemController extends Controller
{

    /**
     * All items
     */
    public function getAllItems(array $params = [], array $enhanceParams = [])
    {
        $this->setViewFile(__DIR__ . '/../web/pages/item_all.html.twig');
        $this->render($this->getViewFile(), $params, $enhanceParams);
    }

    /**
     * One item
     */

    public function getOneItem(array $params = [], array $enhanceParams = [])
    {
        $this->setViewFile(__DIR__ . '/../web/pages/item_one.html.twig');
        $this->render($this->getViewFile(), $params, $enhanceParams);
    }

}