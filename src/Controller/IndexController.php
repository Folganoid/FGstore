<?php

namespace Fg\Controller;

use Fg\Frame\Controller\Controller;
use Fg\Frame\DI\DIInjector;

/**
 * Class IndexController
 * @package Fg
 */
class IndexController extends Controller
{
    /**
     * index
     */
    public function index()
    {
        $this->render($this->getViewFile(ROOTDIR . '/web/pages/index.html.twig'));

        //$a = new Model();
        //$a->setTable('test');
        //var_dump($a->getOne(1));
        //var_dump($a->getAll());
        //$a->insert(['DEFAULT', "'test'", 222]);
        //$a->delete(27);
        //$a->update(37, ["'yyyy'", 1112], ['name', 'doc']);

        $sess = DIInjector::get('session');
        $sess->set('user', 'sdfsdf');
        echo $sess->get('user');
        $sess->clearOne('user');
        echo $sess->get('user');
    }
}

?>
