<?php

namespace Fg\Controller;

use Fg\Frame\Controller\Controller;
use Fg\Frame\Exceptions\DataErrorException;
use Fg\Frame\Response\RedirectResponse;
use Fg\Frame\Router\Router;
use Fg\Frame\Validation\Validation;
use Fg\Model\ItemModel;
use Fg\Frame\DI\DIInjector;
use Fg\Frame\Exceptions\AccessDeniedException;


/**
 * Class ItemController
 * @package Fg
 */
class ItemController extends Controller
{
    /**
     * all categories
     *
     * @param array $params
     * @param array $enhanceParams
     */
    public function getAllItems(array $params = [], array $enhanceParams = [])
    {
        $model = new ItemModel();
        $categories['cats'] = $model->getCategory();
        $this->render($this->getViewFile(ROOTDIR . '/web/pages/item_all.html.twig'), $categories, $enhanceParams);
    }

    /**
     * one item
     *
     * @param array $params
     * @param array $enhanceParams
     * @throws DataErrorException
     */
    public function getOneItem(array $params = [], array $enhanceParams = [])
    {
        $model = new ItemModel();
        $article = $model->getOne($params['id']);
        $vars = $model->getVars($params['id']);

        if (empty($article) || empty($vars)) {
            throw new DataErrorException(exit($params['id'] . ' : Data not find'));
        }

        $this->render($this->getViewFile(ROOTDIR . '/web/pages/item_one.html.twig'), $article, $vars);
    }

    /**
     * item category
     *
     * @param array $params
     * @param array $enhanceParams
     * @throws DataErrorException
     */
    public function getCatItems(array $params = [], array $enhanceParams = [])
    {

        $model = new ItemModel();
        $categories['cats'] = $model->getCategory($params['id']);
        $categories['items'] = $model->getItemList($params['id']);
        $categories['parentName'] = $model->getCatName($params['id'])[0];

        if (empty($categories)) {
            throw new DataErrorException(exit($params['id'] . ' : Data not find'));
        }
        $this->render($this->getViewFile(ROOTDIR . '/web/pages/item_cat.html.twig'), $categories, $enhanceParams);
    }

    /**
     * add item in orders & orders_status table
     *
     */
    public function itemBuy()
    {
        $user = Validation::entrySecure($_POST['user_id']);

        if (!$user) {
            throw new \Exception(exit('Invalid entry DATA.'));
        }

        $secure = DIInjector::get('secure');
        if ($secure->checkAllow('client_private') || $secure->checkOwner($user)) {

        $model = new ItemModel();
        $model->setTable('basket');
        $model->setCase('select');
        $model->setWhere(['client_id = '.$user]);

        $basket = $model->getAll();

        for ($i=0; $i<count($basket); $i++ ) {
            $model->setTable('orders_status');
            $model->insert(["'Обрабатывается'", "NOW()"], ['status', 'date_order']);
            $model->setReturning('id');
            $order_status_id = $model->executeQuery(true)['id'];
            $model->setTable('orders');
            $model->insert([$basket[$i]['item_id'], $order_status_id, $user], ['item_id', 'order_status_id', 'client_id']);
            $model->executeQuery();
        }

        $model->setTable('basket');
        $model->setCase('delete');
        $model->setWhere(['client_id ='.$user]);
        $model->executeQuery();

        new RedirectResponse(Router::getLink('client_one', ['id' => $user]));
        } else {
            throw new AccessDeniedException('Access denied');
        }
    }

}