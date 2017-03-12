<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 11.03.17
 * Time: 17:10
 */

namespace Fg;


use Fg\Frame\Controller\Controller;

class ItemController
{

    /**
     * All items
     */
    public function getAllItems( $params = [], $enhanceParams = [] ){

        echo '<br><br><br><br><b>'. __METHOD__ . '</b><br>';

        $bbb = new Controller();
        $bbb->render(__DIR__ . '/../web/pages/item_all.html.php', $params, $enhanceParams);

    }

    /**
     * One item
     */

    public function getOneItem($params = [], $enhanceParams = [] ){

        echo '<br><br><br><br><b>' . __METHOD__ . '</b><br>';

        $ccc = new Controller();
        $ccc->render(__DIR__ . '/../web/pages/item_one.html.php', $params, $enhanceParams);

    }

}