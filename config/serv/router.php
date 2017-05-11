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
        "item_buy" => [
            "pattern" => "/item_buy",
            "method" => "POST",
            "controller" => "Fg\\Controller\\ItemController",
            "action" => "itemBuy"
        ],
        "orders_all" =>
            [
                "pattern" => "/orders",
                "method" => "GET",
                "controller" => "Fg\\Controller\\OrderController",
                "action" => "getAllOrders"
            ],
        "order_edit" => [
            "pattern" => "/orders/edit/{id}",
            "method" => "GET",
            "variables" => [
                "id" => "\d+",
            ],
            "controller" => "Fg\\Controller\\OrderController",
            "action" => "orderEdit"
        ],
        "order_edit_exec" =>
            [
                "pattern" => "/order_edit_exec",
                "method" => "POST",
                "controller" => "Fg\\Controller\\OrderController",
                "action" => "orderEditExec"
            ],
        "client_one" => [
            "pattern" => "/client/{id}",
            "method" => "GET",
            "variables" => [
                "id" => "\d+",
            ],
            "controller" => "Fg\\Controller\\ClientController",
            "action" => "getOneClient"
        ],
        "basket" => [
            "pattern" => "/basket/{id}",
            "method" => "GET",
            "variables" => [
                "id" => "\d+",
            ],
            "controller" => "Fg\\Controller\\BasketController",
            "action" => "getBasketList"
        ],
        "basket_add" => [
            "pattern" => "/basket/add",
            "method" => "POST",
            "controller" => "Fg\\Controller\\BasketController",
            "action" => "basketAdd"
        ],
        "basket_del" => [
            "pattern" => "/basket/del",
            "method" => "POST",
            "controller" => "Fg\\Controller\\BasketController",
            "action" => "basketDel"
        ],
        "client_all" => [
            "pattern" => "/clients",
            "method" => "GET",
            "controller" => "Fg\\Controller\\ClientController",
            "action" => "getAllClients"
        ],
        "login" =>
            [
                "pattern" => "/login",
                "method" => "GET",
                "controller" => "Fg\\Controller\\LoginController",
                "action" => "login"
            ],
        "logout" =>
            [
                "pattern" => "/logout",
                "method" => "POST",
                "controller" => "Fg\\Controller\\LoginController",
                "action" => "logout"
            ],
        "auth" =>
            [
                "pattern" => "/auth",
                "method" => "POST",
                "controller" => "Fg\\Controller\\LoginController",
                "action" => "auth"
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
            ],
        "api_basket" =>
            [
                "pattern" => "/api/basket/{id}",
                "method" => "POST",
                "controller" => "Fg\\Controller\\ApiController",
                "variables" => [
                    "id" => "\d+",
                ],
                "action" => "apiGetBasketCount"
            ],
        "api_basket_list" =>
            [
                "pattern" => "/api/basket/list/{id}",
                "method" => "POST",
                "controller" => "Fg\\Controller\\ApiController",
                "variables" => [
                    "id" => "\d+",
                ],
                "action" => "apiGetBasketList"
            ]
    ]
];