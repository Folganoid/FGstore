<?php

return [
    "index" => [
        "pattern" => "/",
        "method" => "GET",
        "controller" => "Fg\\IndexController",
        "action" => "index"
    ],
    "item_all" =>
        [
            "pattern" => "/item",
            "method" => "GET",
            "controller" => "Fg\\ItemController",
            "action" => "getAllItems"
        ],
    "item_one" => [
        "pattern" => "/item/{id}/var/{var}",
        "method" => "GET",
        "variables" => [
            "id" => "\d+",
            "var" => "[a-zA-Z0-9_]+"
        ],
        "controller" => "Fg\\ItemController",
        "action" => "getOneItem"

    ]
];