<?php

return [
    'rules' => [
        'usermode' => Fg\Frame\Middleware\UserMode::class,
        'test1' => \Fg\Frame\Middleware\Test1::class,
        'test2' => \Fg\Frame\Middleware\Test2::class
    ],
    'order' => ['test1', 'usermode', 'test2'],
    'params' => ['test1' => 1, 'usermode' => 1, 'test2' => 1]
];