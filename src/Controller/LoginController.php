<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 04.05.17
 * Time: 18:08
 */

namespace Fg\Controller;

use Fg\Frame\Controller\Controller;
use Fg\Frame\DI\DIInjector;
use Fg\Frame\Exceptions\IncorrectLoginPassException;
use Fg\Frame\Response\RedirectResponse;
use Fg\Frame\Router\Router;
use Fg\Frame\Validation\Validation;
use Fg\Model\AuthModel;

/**
 * Class LoginController
 * @package Fg\Controller
 */
class LoginController extends Controller
{
    public function login()
    {
        $this->render($this->getViewFile(ROOTDIR . '/web/pages/login.html.twig'));
        DIInjector::get('secure');
    }

    /**
     * check login & password
     */
    public function auth()
    {
        $login = Validation::entrySecure($_POST['login']);
        $pass = md5(Validation::entrySecure($_POST['pass']));

        $model = new AuthModel();
        $userArr = $model->getUser($login, $pass);

        if ($userArr) {
            DIInjector::get('secure')->getUser($userArr);
            new RedirectResponse(Router::getLink('index'));
        } else {
            throw new IncorrectLoginPassException('Incorrect login or password');
        }
    }

    /**
     * logout
     */
    public function logout()
    {
        if (isset($_POST['logout'])) {
            DIInjector::get('session')->clearAll();
            new RedirectResponse(Router::getLink('index'));
        }
    }
}