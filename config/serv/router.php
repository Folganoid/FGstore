<?php

/**
 * routing rules
 */
return [
    "config" => [

// ============== Item ===================

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
        "item_control" => [
            "pattern" => "/control",
            "method" => "GET",
            "controller" => "Fg\\Controller\\ItemController",
            "action" => "itemCtrl"
        ],
        "item_control_exec" => [
            "pattern" => "/control/exec",
            "method" => "POST",
            "controller" => "Fg\\Controller\\ItemController",
            "action" => "itemCtrlAdmin"
        ],
        "attribute_edit" => [
            "pattern" => "/control/attr_edit",
            "method" => "POST",
            "controller" => "Fg\\Controller\\ItemController",
            "action" => "attributeEdit"
        ],
        "category_edit" => [
            "pattern" => "/control/cat_edit",
            "method" => "POST",
            "controller" => "Fg\\Controller\\ItemController",
            "action" => "categoryEdit"
        ],
        "item_edit" => [
            "pattern" => "/item/edit/{id}",
            "method" => "GET",
            "variables" => [
                "id" => "\d+",
            ],
            "controller" => "Fg\\Controller\\ItemController",
            "action" => "itemEdit"
        ],
        "item_edit_exec" => [
            "pattern" => "/item/edit/exec",
            "method" => "POST",
            "controller" => "Fg\\Controller\\ItemController",
            "action" => "itemEditExec"
        ],


// ============== Order ===================

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

// ============== Basket ===================

        "basket" => [
            "pattern" => "/basket",
            "method" => "GET",
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

// ============== Client ===================

        "client_one" => [
            "pattern" => "/client/{id}",
            "method" => "GET",
            "variables" => [
                "id" => "\d+",
            ],
            "controller" => "Fg\\Controller\\ClientController",
            "action" => "getOneClient"
        ],
        "client_all" => [
            "pattern" => "/clients",
            "method" => "GET",
            "controller" => "Fg\\Controller\\ClientController",
            "action" => "getAllClients"
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
        "auth_edit" =>
            [
                "pattern" => "/auth_edit/{id}",
                "method" => "POST",
                "variables" => [
                    "id" => "\d+",
                ],
                "controller" => "Fg\\Controller\\LoginController",
                "action" => "authEdit"
            ],
        "reg" =>
            [
                "pattern" => "/reg",
                "method" => "POST",
                "controller" => "Fg\\Controller\\LoginController",
                "action" => "reg"
            ],

// ============== API ===================

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
            ],

// ============== System ===================

        "index" => [
            "pattern" => "/",
            "method" => "GET",
            "controller" => "Fg\\Controller\\IndexController",
            "action" => "index"
        ],
        "error" =>
            [
                "pattern" => "/error",
                "method" => "GET",
                "controller" => "Fg\\Controller\\ErrorController",
                "action" => "getError"
            ]
    ]
];