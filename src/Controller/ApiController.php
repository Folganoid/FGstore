<?php

namespace Fg\Controller;

use Fg\Frame\Controller\Controller;
use Fg\Frame\Exceptions\DataErrorException;
use Fg\Model\ApiModel;

/**
 * Class ApiController
 * @package Fg
 */
class ApiController extends Controller
{
    /**
     * One item in JSON format
     */
    public function apiGetOneItem(array $params = [], array $enhanceParams = [])
    {

        $model = new ApiModel();
        $article = $model->getOne($params['id']);
        $vars = $model->getVars($params['id']);

        if (empty($article) || empty($vars)) {
            throw new DataErrorException(exit($params['id'] . ' : Data not find'));
        }

        $json = json_encode(array_merge($vars, $article));
        $this->render($this->getViewFile($json));
    }
}