<?php

namespace Fg;

use Fg\Frame\Controller\Controller;

/**
 * Class ApiController
 * @package Fg
 */
class ApiController extends Controller
{
    /**
     * errors
     */
    public function apiGetOneItem(array $params = [], array $enhanceParams = [])
    {
        $this->render($this->getViewFile(__DIR__ . '/../web/pages/test.json'), $params, $enhanceParams);
    }
}