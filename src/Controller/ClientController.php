<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 02.05.17
 * Time: 14:12
 */

namespace Fg\Controller;

use Fg\Frame\Controller\Controller;
use Fg\Frame\DI\DIInjector;
use Fg\Frame\Exceptions\AccessDeniedException;
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
        $secure = DIInjector::get('secure');
        $secure->checkOwner($params['id']);
        $model = new ClientModel();
        $clientVars = $model->getOne($params['id']);
        if (empty($clientVars)) {
            throw new DataErrorException(exit($params['id'] . ' : Data not find'));
        }
        $clientVars['orders'] = $model->getOrdersAll($params['id']);
        $this->render($this->getViewFile(ROOTDIR . '/web/pages/client_one.html.twig'), $clientVars, $enhanceParams);

    }

    /**
     * get all client data
     *
     * @param array $params
     * @param array $enhanceParams
     */
    public function getAllClients(array $params = [], array $enhanceParams = [])
    {
        DIInjector::get('secure')->checkAllow('client_private');
        $model = new ClientModel();
        $clients['clients'] = $model->getAll();
        $this->render($this->getViewFile(ROOTDIR . '/web/pages/client_all.html.twig'), $clients, $enhanceParams);
    }
}