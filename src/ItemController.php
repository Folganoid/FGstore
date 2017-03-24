<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 11.03.17
 * Time: 17:10
 */

namespace Fg;


use Fg\Frame\Controller\Controller;

/**
 * Class ItemController
 * @package Fg
 */
class ItemController extends MainController
{

    /**
     * All items
     */
    public function getAllItems(array $params = [], array $enhanceParams = [])
    {
        $this->setViewFile(__DIR__ . '/../web/pages/item_all.html.twig');

        $bbb = new Controller($this->configDir);
        $bbb->render($this->getViewFile(), $params, $enhanceParams);
    }

    /**
     * One item
     */

    public function getOneItem(array $params = [], array $enhanceParams = [])
    {
        $this->setViewFile(__DIR__ . '/../web/pages/item_one.html.twig');

        $bbb = new Controller($this->configDir);
        $bbb->render($this->getViewFile(), $params, $enhanceParams);
    }

}