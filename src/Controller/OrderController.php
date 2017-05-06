<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 02.05.17
 * Time: 12:58
 */

namespace Fg\Controller;

use Fg\Frame\Controller\Controller;
use Fg\Frame\DI\DIInjector;
use Fg\Frame\Exceptions\AccessDeniedException;
use Fg\Frame\Router\Router;
use Fg\Frame\Validation\Validation;
use Fg\Model\OrderModel;
use Fg\Frame\Response\RedirectResponse;


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

        $secure = DIInjector::get('secure');
        if ($secure->checkAllow('orders')) {
            $this->render($this->getViewFile(ROOTDIR . '/web/pages/orders.html.twig'), $vars);
        } else {
            throw new AccessDeniedException('Access denied');
        }
    }

    /**
     * @param array $params
     * @param array $enhanceParams
     */
    public function orderEdit(array $params = [], array $enhanceParams = [])
    {
        $secure = DIInjector::get('secure');
        if ($secure->checkAllow('orders')) {
            $model = new OrderModel();
            $model->setTable('orders_status');
            $order = $model->getOne($params['id']);

            $this->render($this->getViewFile(ROOTDIR . '/web/pages/order_edit.html.twig'), $params, $order);
        } else {
            throw new AccessDeniedException('Access denied');
        }
    }

    /**
     * order edit/delete execute
     *
     */
    public function orderEditExec()
    {
        $id = Validation::entrySecure($_POST['id']);
        $status = Validation::entrySecure($_POST['status']);
        $send = Validation::entrySecure($_POST['send']);
        $receive = Validation::entrySecure($_POST['receive']);

        if (!checkdate(substr($send, 5, 2), substr($send, 8, 2), substr($send, 0, 4))) {
            $send = 'NULL';
        } else $send = "'" . $send . "'";

        if (!checkdate(substr($receive, 5, 2), substr($receive, 8, 2), substr($receive, 0, 4))) {
            $receive = 'NULL';
        } else $receive = "'" . $receive . "'";

        if (isset($_POST['delete'])) {
            $model = new OrderModel();
            $model->setTable('orders_status');
            $model->delete($id);

            $model->setTable('orders');
            $model->setCase('delete');
            $model->setWhere(['order_status_id =' . $id]);
            $model->executeQuery();

            new RedirectResponse(Router::getLink('orders_all'));
        }
        if (isset($_POST['edit'])) {
            $model = new OrderModel();
            $model->setTable('orders_status');
            $model->update($id, ["'" . $status . "'", $receive, $send], ['status', 'date_receive', 'date_send']);

            new RedirectResponse(Router::getLink('orders_all'));
        }
    }
}