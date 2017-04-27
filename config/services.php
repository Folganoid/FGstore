<?php
/**
 * contractors config
 * contractorName => [ClassName, singleton(Y/N)]
 */
return [
    'router' => Fg\Frame\Router\Router::class,
    'request' => Fg\Frame\Request\Request::class,
    'validation' => Fg\Frame\Validation\Validation::class,
    'database' => Fg\Frame\DataBase\DataBase::class,
    'middleware' => Fg\Frame\Middleware\Middleware::class,
    'session' => Fg\Frame\Session\Session::class,
];