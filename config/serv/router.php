<?php

/**
 * routing rules
 */
return [
    "config" => [
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

        ],
        "error" => //system
            [
                "pattern" => "/error",
                "method" => "GET",
                "controller" => "Fg\\ErrorController",
                "action" => "getError"
            ],
        "api" =>
            [
                "pattern" => "/api/item/{id}",
                "method" => "GET",
                "controller" => "Fg\\ApiController",
                "variables" => [
                    "id" => "\d+",
                ],
                "action" => "apiGetOneItem"
            ]
    ]
];