<?php

/**
 * validation rules
 */

return [
    'rules' => [
        'int_only' => '^[0-9]+$',
        'let_only' => '[A-za-zА-Яа-я]+',
        'let_and_int_only' => '[A-za-z0-9А-Яа-я]+',
        'min_max_length' => '^[\s\S]{@min@,@max@}$', // You must add params in Validation::check() as ['min' => 2, 'max' => 4]
        'email' => '[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})'
    ]
];