<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 02.05.17
 * Time: 12:58
 */

namespace Fg\Controller;

use Fg\Frame\Controller\Controller;
use Fg\Model\OrderModel;

/**
 * Class OrderController
 * @package Fg\Controller
 */
class OrderController extends Controller
{
    /**
     * get orders list
     *
     * @param array $params
     * @param array $enhanceParams
     */
    public function getAllOrders(array $params = [], array $enhanceParams = [])
    {
        $model = new OrderModel();
        $vars['orderArr'] = $model->getOrdersAll();
        $this->render($this->getViewFile(ROOTDIR . '/web/pages/orders.html.twig'), $vars);
    }
}