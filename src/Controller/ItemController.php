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
     * All items
     */
    public function getAllItems(array $params = [], array $enhanceParams = [])
    {
        $this->render($this->getViewFile(ROOTDIR . '/web/pages/item_all.html.twig'), $params, $enhanceParams);
    }

    /**
     * One item
     */
    public function getOneItem(array $params = [], array $enhanceParams = [])
    {
        $model = new ItemModel();
        $article = $model->getOne($params['id']);

        if (empty($article)) {
            throw new DataErrorException(exit($params['id'] . ' : Data not find'));
        }

        $this->render($this->getViewFile(ROOTDIR . '/web/pages/item_one.html.twig'), $article, $enhanceParams);
    }

}