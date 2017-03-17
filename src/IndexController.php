<?php

namespace Fg;

use Fg\Frame\Controller\Controller;
use Fg\Frame\Validation\Validation;

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

        echo '<br><br><br><br><b>' . __METHOD__ . '</b><br>';

        $aaa = new Controller($this->configDir);
        $aaa->render(__DIR__ . '/../web/pages/index.html.twig');

        $test = 'wrf**#4k11111111';
        echo '<br>';
        echo (Validation::Check($test, 'min_max_length', ['min' => '2', 'max' => '10'])) ? $test : 'error';
        Validation::getError();

        $test2 = '1111ffff2';
        echo '<br>';
        echo (Validation::Check($test2, 'let_and_int_only')) ? $test2 : 'error';
        Validation::getError();

    }
}

?>
