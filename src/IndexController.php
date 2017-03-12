<?php

namespace Fg;

use Fg\Frame\Controller\Controller;

/**
 * Class IndexController
 * @package Fg
 */
class IndexController
{

    public function index(){

        echo '<br><br><br><br><b>' . __METHOD__ . '</b><br>';

        $aaa = new Controller();
        $aaa->render(__DIR__.'/../web/pages/index.html.php');

    }
}

?>
