<?php

/**
 * routing rules
 */
return [
    "config" => [
        "index" => [
            "pattern" => "/",
            "method" => "GET",
            "controller" => "Fg\\Controller\\IndexController",
            "action" => "index"
        ],
        "item_all" =>
            [
                "pattern" => "/items",
                "method" => "GET",
                "controller" => "Fg\\Controller\\ItemController",
                "action" => "getAllItems"
            ],
        "item_category" =>
            [
                "pattern" => "/items/category/{id}",
                "method" => "GET",
                "variables" => [
                    "id" => "\d+",
                ],
                "controller" => "Fg\\Controller\\ItemController",
                "action" => "getCatItems"
            ],
        "item_one" => [
            "pattern" => "/item/{id}",
            "method" => "GET",
            "variables" => [
                "id" => "\d+",
            ],
            "controller" => "Fg\\Controller\\ItemController",
            "action" => "getOneItem"

        ],
        "error" => //system
            [
                "pattern" => "/error",
                "method" => "GET",
                "controller" => "Fg\\Controller\\ErrorController",
                "action" => "getError"
            ],
        "api" =>
            [
                "pattern" => "/api/item/{id}",
                "method" => "GET",
                "controller" => "Fg\\Controller\\ApiController",
                "variables" => [
                    "id" => "\d+",
                ],
                "action" => "apiGetOneItem"
            ]
    ]
];