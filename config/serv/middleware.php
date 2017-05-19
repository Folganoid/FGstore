<?php

return [
    'rules' => [
        'technical_works' => Fg\Frame\Middleware\TechWorks::class,
        'night_mode' => \Fg\Frame\Middleware\NightMode::class,
        'test2' => \Fg\Frame\Middleware\Test2::class
    ],
    'order' => ['night_mode', 'technical_works', 'test2'],
    'params' => ['night_mode' => 0, 'technical_works' => 0, 'test2' => 1]
];