<?php

/**
 * validation rules
 */

return [
    'rules' => [
        'int_only' => '[0-9]+',
        'let_only' => '[a-zA-Z]+',
        'let_and_int_only' => '[a-zA-Z0-9]+',
        'min_max_length' => '[\s\S]{@min@,@max@}', // You must add params in Validation::check() as ['min' => 2, 'max' => 4]
    ]
];