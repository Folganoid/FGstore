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

        echo '<br><br><br><br><b>' . __METHOD__ . '</b><br>';

        $bbb = new Controller($this->configDir);
        $bbb->render(__DIR__ . '/../web/pages/item_all.html.twig', $params, $enhanceParams);

    }

    /**
     * One item
     */

    public function getOneItem(array $params = [], array $enhanceParams = [])
    {

        echo '<br><br><br><br><b>' . __METHOD__ . '</b><br>';

        $ccc = new Controller($this->configDir);
        $ccc->render(__DIR__ . '/../web/pages/item_one.html.twig', $params, $enhanceParams);

    }

}