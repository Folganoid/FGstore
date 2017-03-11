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
        "pattern" => "/item/{id}/color/{color}",
        "method" => "GET",
        "variables" => [
            "id" => "\d+",
        ],
        "controller" => "Fg\\ItemController",
        "action" => "getOneItem"

    ]
];