<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 24.03.17
 * Time: 12:12
 */

namespace Fg;


use Fg\Frame\Controller\Controller;

/**
 * Class ApiController
 * @package Fg
 */
class ApiController extends MainController
{
    /**
     * errors
     */
    public function apiGetOneItem(array $params = [], array $enhanceParams = [])
    {
        $this->setViewFile(__DIR__ . '/../web/pages/test.json');

        $aaa = new Controller($this->configDir);
        $aaa->render($this->getViewFile(), $params, $enhanceParams);

    }
}