<?php

namespace Fg\Controller;

use Fg\Frame\Controller\Controller;

/**
 * Class ErrorController
 * @package Fg
 */
class ErrorController extends Controller
{
    /**
     * errors
     */
    public function getError(array $params = [], array $enhanceParams = [])
    {
        $this->render($this->getViewFile($this->configDir['error']), $params, $enhanceParams);
    }
}
