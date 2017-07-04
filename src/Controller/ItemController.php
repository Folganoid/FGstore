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
     * @var array - config for EAV DB with item params
     */
    public $config;

    /**
     * ItemController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->config = [
            "int" => [
                "arr" => $item_val_int = [],
                "isText" => false,
                "table" => "item_val_int"
            ],
            "double" => [
                "arr" => $item_val_double = [],
                "isText" => false,
                "table" => "item_val_double"
            ],
            "varchar" => [
                "arr" => $item_val_varchar = [],
                "isText" => true,
                "table" => "item_val_varchar"
            ],
            "date" => [
                "arr" => $item_val_date = [],
                "isText" => true,
                "table" => "item_val_date"
            ]
        ];
    }

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

        /**
         * get path to image
         */
        if (file_exists(ROOTDIR . '/web/img/' . $item['path']) && ($item['path'])) {
            $item['path'] = '/img/' . $item['path'];
        } else {
            $item['path'] = '/img/none.jpg';
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
            throw new DataErrorException('Category ' . $params['id'] . ' is not find');
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
            $model->insert([$basket[$i]['item_id'], $order_status_id, $user, $basket[$i]['sum']], ['item_id', 'order_status_id', 'client_id', 'sum']);
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
     * attribute edit
     */
    public function attributeEdit()
    {
        DIInjector::get('secure')->checkAllow('edit_items');

        $model = new ItemModel();
        $model->setTable('attribute');
        $id = Validation::entrySecure($_POST['id']);
        $name = Validation::entrySecure($_POST['name']);
        $unit = Validation::entrySecure($_POST['unit']);

        $model->update($id, ["'" . $name . "'", "'" . $unit . "'"], ['name', 'unit']);

        new RedirectResponse(Router::getLink('item_control'));
    }

    /**
     * category edit
     */
    public function categoryEdit()
    {
        DIInjector::get('secure')->checkAllow('edit_items');

        $model = new ItemModel();
        $model->setTable('category');
        $id = Validation::entrySecure($_POST['cat_id']);
        $name = Validation::entrySecure($_POST['cat_name']);
        $parent = (Validation::entrySecure($_POST['cat_parent']) > 0) ? Validation::entrySecure($_POST['cat_parent']) : "NULL";
        $notice = Validation::entrySecure($_POST['cat_notice']);

        $model->update($id, ["'" . $name . "'", $parent, "'" . $notice . "'"], ['name', 'parent_category_id', 'notice']);

        new RedirectResponse(Router::getLink('item_control'));
    }

    /**
     * get item
     *
     * @param array $params
     * @param array $enhanceParams
     * @throws DataErrorException
     */
    public function itemEdit(array $params = [], array $enhanceParams = [])
    {
        DIInjector::get('secure')->checkAllow('edit_items');

        $model = new ItemModel();
        $model->setTable('attribute');
        $model->setOrderBy(['id']);
        $vars['attributes'] = $model->getAll();

        $model->setTable('item');
        $model->setOrderBy(['name']);
        $vars['item'] = $model->getOne($params['id']);
        $vars['params'] = $model->getVars($params['id']);

        if (empty($vars)) {
            throw new DataErrorException('Item ' . $params['id'] . ' is not find');
        }

        for ($i = 0; $i < count($vars['attributes']); $i++) {
            for ($z = 0; $z < count($vars['params']); $z++) {
                if ($vars['attributes'][$i]['name'] == $vars['params'][$z][0]) {
                    $vars['attributes'][$i]['value'] = str_replace(" " . $vars['attributes'][$i]['unit'], "", $vars['params'][$z][1]);
                }
            }
        }
        $this->render($this->getViewFile(ROOTDIR . '/web/pages/item_edit.html.twig'), $params, $vars);
    }

    /**
     * item edit execute
     *
     */
    public function itemEditExec()
    {
        DIInjector::get('secure')->checkAllow('edit_items');
        $item_id = Validation::entrySecure($_POST['id']);

        $config = $this->config;

        /**
         * edit item
         */
        if (isset($_POST['edit_item'])) {

            $path = 'NULL';
            if ($_POST['item_file']) {
                $path = "'". $_POST['item_file'] ."'";
            }
            else {
                $uploadfile = IMGDIR . basename($_FILES['file']['name']);
                if ($_FILES['file']['name']) {
                    $path = "'" . $_FILES['file']['name'] . "'";

                    if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                        throw new \Exception('ERROR. Can`t upload file');
                    }
                }
            }

            $model = new ItemModel();
            $model->update($item_id, ["'" . $_POST['item_name'] . "'", $_POST['item_parent_id'], "'" . $_POST['item_notice'] . "'", $path], ['name', 'category_id', 'notice', 'path']);

            $paramsArr = $this->createArrForItemParams($_POST, $config);

            foreach ($paramsArr as $k => $v) {
                $model->addVarsEAVTable($v['table'], $v['arr'], $item_id, $v['isText']);
            }
        }
        /**
         * delete item
         */
        if (isset($_POST['delete_item'])) {
            $model = new ItemModel();
            $model->setTable('item');
            $model->delete($item_id);

            $model->setCase('delete');
            $model->setWhere(['item_id =' . $item_id]);

            foreach ($config as $k => $v) {
                $model->setTable($v['table']);
                $model->executeQuery();
            }

            if (file_exists(IMGDIR . $_POST['item_file']) && $_POST['item_file']) {
                unlink(IMGDIR . $_POST['item_file']);
            }
        }
        new RedirectResponse(Router::getLink('item_one', ['id' => $item_id]));
    }

    /**
     * items- categories- attributes execute edit
     */
    public function itemCtrlAdmin()
    {
        DIInjector::get('secure')->checkAllow('edit_items');

// =========== Item

        if (isset($_POST['add_item'])) {

            $uploadfile = IMGDIR . basename($_FILES['item_file']['name']);

            $path = 'NULL';
            if($_FILES['item_file']['name']) {
                $path = "'".$_FILES['item_file']['name']."'";

                if (!move_uploaded_file($_FILES['item_file']['tmp_name'], $uploadfile)) {
                    throw new \Exception('ERROR. Can`t upload file');
                }
            }

            $model = new ItemModel();
            $model->insert(["'" . $_POST['item_name'] . "'", $_POST['item_parent_id'], "'" . $_POST['item_notice'] . "'", $path], ['name', 'category_id', 'notice', 'path']);
            $model->setReturning('id');
            $id_item_return = $model->executeQuery(true)['id'];

            $config = $this->config;

            $paramsArr = $this->createArrForItemParams($_POST, $config);

            foreach ($paramsArr as $k => $v) {
                $model->addVarsEAVTableByCreateItem($v['table'], $v['arr'], $id_item_return, $v['isText']);
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

    /**
     * create array for item params
     *
     * @param array $post
     * @return array
     */
    public function createArrForItemParams(array $post, array $cnf): array
    {
        $config = $cnf;

        foreach ($post as $k => $v) {
            if (strpos($k, '@') && !empty($v)) {
                $tmpArr = explode('@', $k);
                $id = $tmpArr[0];
                $type = $tmpArr[1];

                foreach ($config as $key => $val) {
                    if ($type == $key) {
                        array_push($config[$key]['arr'], [$id, $v]);
                    }
                }
            }
        }
        return $config;
    }

}