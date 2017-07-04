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
use Fg\Frame\Exceptions\IncorrectEntryDataException;
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
     * edit user account
     */
    public function authEdit(array $params = [], array $enhanceParams = [])
    {
        $valid = DIInjector::get('validation');
        $id = $params['id'];

        $secure = DIInjector::get('secure');
        $secure->checkOwner($id);

        $name = $valid::entrySecure($_POST['name']);
        $surname = $valid::entrySecure($_POST['surname']);
        $login = $valid::entrySecure($_POST['login']);
        $email = $valid::entrySecure($_POST['email']);
        $tel = $valid::entrySecure($_POST['tel']);
        $address = $valid::entrySecure($_POST['address']);

        if ($valid->check($login, 'let_and_int_only')
            && $valid->check($name, 'let_only')
            && $valid->check($surname, 'let_only')
            && $valid->check($tel, 'int_only')
            && $valid->check($email, 'email')
        ) {
            $model = new AuthModel();
            $model->update($id, ["'" . $name . "'", "'" . $surname . "'", "'" . $login . "'", "'" . $email . "'", $tel, "'" . $address . "'"],
                ['name', 'surname', 'login', 'email', 'telnumber', 'address']);

            $pass1 = $valid::entrySecure($_POST['pass1']);
            if ($pass1) {
                $model->update($id, ["'" . md5($pass1) . "'"], ['pass']);
            }

            if ($secure->isAdmin()) {
                $rank = $valid::entrySecure($_POST['rank']);
                $notice = $valid::entrySecure($_POST['notice']);

                $model->update($id, [$rank, "'" . $notice . "'"], ['rank', 'notice']);
            }
        } else {
            throw new IncorrectEntryDataException('The entered data is not correct');
        }
        new RedirectResponse(Router::getLink('client_one', ['id' => $id]));
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

    /**
     * user registration
     *
     * @throws IncorrectEntryDataException
     */
    public function reg()
    {
        $valid = DIInjector::get('validation');

        $name = $valid::entrySecure($_POST['name']);
        $surname = $valid::entrySecure($_POST['surname']);
        $login = $valid::entrySecure($_POST['login']);
        $pass1 = $valid::entrySecure($_POST['pass']);
        $email = $valid::entrySecure($_POST['email']);
        $tel = $valid::entrySecure($_POST['tel']);
        $address = $valid::entrySecure($_POST['address']);

        if ($valid->check($login, 'let_and_int_only')
            && $valid->check($name, 'let_only')
            && $valid->check($surname, 'let_only')
            && $valid->check($tel, 'int_only')
            && $valid->check($email, 'email')
        ) {
            $model = new AuthModel();

            $model->setCase('select');
            $model->setWhere(["email = '" . $email . "' OR login = '" . $login . "' OR telnumber = '" . $tel . "' "]);
            $model->setLimit(1);

            if ($model->executeQuery(true)['id'] > 0) {
                throw new IncorrectLoginPassException('User with this login, telephone or email already exist');
            } else {
                $model->insert(["'" . $name . "'", "'" . $surname . "'", "'" . $email . "'", 3, "'" . $tel . "'", "'" . $address . "'", "'" . $login . "'", "'" . md5($pass1) . "'"],
                    ['name', 'surname', 'email', 'rank', 'telnumber', 'address', 'login', 'pass']);
                $model->executeQuery();

                new RedirectResponse(Router::getLink('index'));
            }
        } else {
            throw new IncorrectEntryDataException('The entered data is not correct');
        }

    }
}