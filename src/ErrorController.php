<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 24.03.17
 * Time: 10:49
 */

namespace Fg;

use Fg\Frame\Controller\Controller;

/**
 * Class IndexController
 * @package Fg
 */
class ErrorController extends MainController
{
    /**
     * errors
     */
    public function getError(array $params = [], array $enhanceParams = [])
    {
        $this->setViewFile($this->configDir['error']);

        $aaa = new Controller($this->configDir);
        $aaa->render($this->getViewFile(), $params, $enhanceParams);

    }
}
