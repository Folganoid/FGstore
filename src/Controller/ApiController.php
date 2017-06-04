<?php

namespace Fg\Controller;

use Fg\Frame\Controller\Controller;
use Fg\Frame\Exceptions\DataErrorException;
use Fg\Model\ApiModel;
use Fg\Model\BasketModel;
use Fg\Frame\DI\DIInjector;
use Fg\Frame\Exceptions\AccessDeniedException;

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
        $model->setOrderBy(['name']);
        $item = $model->getOne($params['id']);
        $vars = $model->getVars($params['id']);

        if (empty($item) || empty($vars)) {
            throw new DataErrorException(exit($params['id'] . ' : Data not find'));
        }

        $json = json_encode(array_merge($vars, $item));
        $this->render($this->getViewFile($json));
    }

    /**
     * get bascet list count
     *
     * @param array $params
     * @param array $enhanceParams
     */
    public function apiGetBasketCount(array $params = [], array $enhanceParams = [])
    {
        $model = new BasketModel();
        $cnt = count($model->getBasketList($params['id']));
        if ($cnt > 0) {
            echo '<b>(' . $cnt . ')</b>';
        } else {
            echo '';
        }
    }

    /**
     * get basket list by user id
     *
     * @param array $params
     * @param array $enhanceParams
     * @throws AccessDeniedException
     */
    public function apiGetBasketList(array $params = [], array $enhanceParams = [])
    {
        $secure = DIInjector::get('secure');
        $secure->checkOwner($params['id']);
            $model = new BasketModel();
            echo json_encode($model->getBasketList($params['id']));
    }
}