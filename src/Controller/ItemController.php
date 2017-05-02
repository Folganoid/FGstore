<?php

namespace Fg\Controller;

use Fg\Frame\Controller\Controller;
use Fg\Frame\Exceptions\DataErrorException;
use Fg\Model\ItemModel;


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
    public function getCatItems(array $params = [], array $enhanceParams = []) {

        $model = new ItemModel();
        $categories['cats'] = $model->getCategory($params['id']);
        $categories['items'] = $model->getItemList($params['id']);
        $categories['parentName'] = $model->getCatName($params['id'])[0];

        if (empty($categories)) {
            throw new DataErrorException(exit($params['id'] . ' : Data not find'));
        }

        $this->render($this->getViewFile(ROOTDIR . '/web/pages/item_cat.html.twig'), $categories, $enhanceParams);

    }

}