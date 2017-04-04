<?php

namespace Fg;

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
        $this->setViewFile($this->configDir['error']);
        $this->render($this->getViewFile(), $params, $enhanceParams);

    }
}
