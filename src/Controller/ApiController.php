<?php

namespace Fg\Controller;

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
        $this->render($this->getViewFile(ROOTDIR . '/web/pages/test.json'), $params, $enhanceParams);
    }
}