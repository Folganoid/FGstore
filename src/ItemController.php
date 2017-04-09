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
        $this->render($this->getViewFile(__DIR__ . '/../web/pages/item_all.html.twig'), $params, $enhanceParams);
    }

    /**
     * One item
     */

    public function getOneItem(array $params = [], array $enhanceParams = [])
    {
        $this->render($this->getViewFile(__DIR__ . '/../web/pages/item_all.html.twig'), $params, $enhanceParams);
    }

}