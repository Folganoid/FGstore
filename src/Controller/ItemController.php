<?php

namespace Fg\Controller;

use Fg\Frame\Controller\Controller;
use Fg\Frame\Exceptions\DataErrorException;
use Fg\Frame\Response\RedirectResponse;
use Fg\Frame\Router\Router;
use Fg\Frame\Validation\Validation;
use Fg\Model\ItemModel;
use Fg\Frame\DI\DIInjector;

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
        $item = $model->getOne($params['id']);
        $vars['params'] = $model->getVars($params['id']);

        if (empty($item) || empty($vars)) {
            throw new DataErrorException('Item ' . $params['id'] . ' is not find');
        }

        /**
         * get price
         */
        for ($i = 0; $i < count($vars['params']); $i++) {
            if ($vars['params'][$i][0] == 'Price') {
                $item['Price'] = $vars['params'][$i][1];
                break;
            }
        }

        $this->render($this->getViewFile(ROOTDIR . '/web/pages/item_one.html.twig'), $item, $vars);
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

        if (empty($categories['parentName'])) {
            throw new DataErrorException('Category ' . $params['id'] . ' isx not find');
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
        $secure->checkOwner($user);

        $model = new ItemModel();
        $model->setTable('basket');
        $model->setCase('select');
        $model->setWhere(['client_id = ' . $user]);

        $basket = $model->getAll();

        for ($i = 0; $i < count($basket); $i++) {
            $model->setTable('orders_status');
            $model->insert(["'Processing'", "NOW()"], ['status', 'date_order']);
            $model->setReturning('id');
            $order_status_id = $model->executeQuery(true)['id'];
            $model->setTable('orders');
            $model->insert([$basket[$i]['item_id'], $order_status_id, $user], ['item_id', 'order_status_id', 'client_id']);
            $model->executeQuery();
        }

        $model->setTable('basket');
        $model->setCase('delete');
        $model->setWhere(['client_id =' . $user]);
        $model->executeQuery();

        new RedirectResponse(Router::getLink('client_one', ['id' => $user]));
    }

    /**
     * items- categories- attributes edit
     */
    public function itemCtrl()
    {
        DIInjector::get('secure')->checkAllow('edit_items');
        $model = new ItemModel();
        $model->setTable('category');
        $model->setOrderBy(['name']);
        $categories['cats'] = $model->getAll();

        $model->setTable('attribute');
        $model->setOrderBy(['id']);
        $categories['attributes'] = $model->getAll();

        $this->render($this->getViewFile(ROOTDIR . '/web/pages/item_ctrl.html.twig'), $categories);

    }

    /**
     * items- categories- attributes execute edit
     */
    public function itemCtrlAdmin()
    {

// =========== Item

        if (isset($_POST['add_item'])) {
            $model = new ItemModel();
            $model->insert(["'" . $_POST['item_name'] . "'", $_POST['item_parent_id'], "'" . $_POST['item_notice'] . "'"], ['name', 'category_id', 'notice']);
            $model->setReturning('id');
            $id_item_return = $model->executeQuery(true)['id'];

            $item_val_int = [];
            $item_val_double = [];
            $item_val_varchar = [];
            $item_val_date = [];

            foreach ($_POST as $k => $v) {
                if (strpos($k, '@') && !empty($v)) {
                    $tmpArr = explode('@', $k);
                    $id = $tmpArr[0];
                    $type = $tmpArr[1];

                    if ($type == 'int') {
                        $item_val_int[] = [$id, $v];
                    }
                    if ($type == 'double') {
                        $item_val_double[] = [$id, $v];
                    }
                    if ($type == 'varchar') {
                        $item_val_varchar[] = [$id, $v];
                    }
                    if ($type == 'date') {
                        $item_val_date[] = [$id, $v];
                    }
                }
            }

            $model->setTable('item_val_int');
            for ($i = 0; $i < count($item_val_int); $i++) {
                $model->insert([$item_val_int[$i][0], $id_item_return, $item_val_int[$i][1]], ['attribute_id', 'item_id', 'value']);
                $model->executeQuery();
            }

            $model->setTable('item_val_double');
            for ($i = 0; $i < count($item_val_double); $i++) {
                $model->insert([$item_val_double[$i][0], $id_item_return, $item_val_double[$i][1]], ['attribute_id', 'item_id', 'value']);
                $model->executeQuery();
            }
            $model->setTable('item_val_varchar');
            for ($i = 0; $i < count($item_val_varchar); $i++) {
                $model->insert([$item_val_varchar[$i][0], $id_item_return, "'" . $item_val_varchar[$i][1] . "'"], ['attribute_id', 'item_id', 'value']);
                $model->executeQuery();
            }
            $model->setTable('item_val_date');
            for ($i = 0; $i < count($item_val_date); $i++) {
                $model->insert([$item_val_date[$i][0], $id_item_return, "'" . $item_val_date[$i][1] . "'"], ['attribute_id', 'item_id', 'value']);
                $model->executeQuery();
            }

            new RedirectResponse(Router::getLink('item_one', ['id' => $id_item_return]));
        }

// =========== Attribute

        if (isset($_POST['add_attribute'])) {

            $unit = (!empty($_POST['unit'])) ? "'" . $_POST['unit'] . "'" : 'NULL';

            $model = new ItemModel();
            $model->setTable('attribute');
            $model->insert(["'" . $_POST['name'] . "'", $unit, "'" . $_POST['data_type'] . "'"], ['name', 'unit', 'data_type']);
            $model->executeQuery();

            new RedirectResponse(Router::getLink('item_control'));
        }

// =========== Category

        if (isset($_POST['add_category'])) {

            $notice = (!empty($_POST['notice'])) ? "'" . $_POST['notice'] . "'" : "NULL";
            $parent = (!empty($_POST['parent_id'])) ? $_POST['parent_id'] : "NULL";

            $model = new ItemModel();
            $model->setTable('category');
            $model->insert([$parent, "'" . $_POST['name'] . "'", $notice], ['parent_category_id', 'name', 'notice']);
            $model->executeQuery();

            if ($parent == "NULL") {
                new RedirectResponse(Router::getLink('item_all'));
            } else {
                new RedirectResponse(Router::getLink('item_category', ['id' => $_POST['parent_id']]));
            }

        }
    }

}