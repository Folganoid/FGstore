<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 02.05.17
 * Time: 14:12
 */

namespace Fg\Controller;

use Fg\Frame\Controller\Controller;
use Fg\Model\ClientModel;
use Fg\Frame\Exceptions\DataErrorException;

/**
 * Class ClientController
 * @package Fg\Controller
 */
class ClientController extends Controller
{
    /**
     * get one client
     *
     * @param array $params
     * @param array $enhanceParams
     * @throws DataErrorException
     */
    public function getOneClient(array $params = [], array $enhanceParams = [])
    {
        $model = new ClientModel();
        $clientVars = $model->getOne($params['id']);
        if (empty($clientVars)) {
            throw new DataErrorException(exit($params['id'] . ' : Data not find'));
        }

        $clientVars['orders'] = $model->getOrdersAll($params['id']);

        $this->render($this->getViewFile(ROOTDIR . '/web/pages/client_one.html.twig'), $clientVars, $enhanceParams);
    }
}