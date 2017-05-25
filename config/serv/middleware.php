<?php

return [
    'rules' => [
        'technical_works' => Fg\Frame\Middleware\TechWorks::class,
        'night_mode' => \Fg\Frame\Middleware\NightMode::class,
    ],
    'order' => ['night_mode', 'technical_works'],
    'params' => ['night_mode' => 0, 'technical_works' => 0]
];