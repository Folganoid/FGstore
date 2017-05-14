<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 11.05.17
 * Time: 9:20
 */

namespace Fg\Controller;

use Fg\Frame\Controller\Controller;
use Fg\Frame\DI\DIInjector;
use Fg\Frame\Exceptions\AccessDeniedException;
use Fg\Model\BasketModel;
use Fg\Frame\Exceptions\DataErrorException;
use Fg\Frame\Validation\Validation;
use Fg\Frame\Response\RedirectResponse;
use Fg\Frame\Router\Router;


/**
 * Class ClientController
 * @package Fg\Controller
 */
class BasketController extends Controller
{
    /**
     * get one client
     *
     * @param array $params
     * @param array $enhanceParams
     * @throws DataErrorException
     */
    public function getBasketList()
    {
        $this->render($this->getViewFile(ROOTDIR . '/web/pages/basket.html.twig'));
    }

    /**
     * add to basket
     * @throws \Exception
     */
    public function basketAdd()
    {
        $user = Validation::entrySecure($_POST['user_id']);
        $item = Validation::entrySecure($_POST['item_id']);

        if (!$user || !$item) {
            throw new \Exception(exit('Invalid entry DATA.'));
        }
        $model = new BasketModel;
        $model->insert([$item, $user], ['item_id', 'client_id']);
        $model->executeQuery();

        new RedirectResponse(Router::getLink('basket', ['id' => $user]));
    }

    public function basketDel()
    {
        $id = $_POST['id'];
        $model = new BasketModel;
        $model->delete($id);

    }


}