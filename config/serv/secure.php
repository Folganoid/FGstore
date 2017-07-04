<?php

return [
//        10 - "Administrator",
//        8 - "Moderator",
//        3 - "User",
//        0 - "Guest",

    "mapping" => [
        "admin" => 10,          // admin rank (system)
        "orders" => 8,          // order list allow rank >= 8
        "edit_items" => 8,      // edit items allow rank >= 8
        "client_private" => 10  // client private data (admin only)
    ],
    /**
     * session variable names for secure
     */
    "variables" => [
        "rank" => "SESSION_rank",
        "id" => "SESSION_id",
        "login" => "SESSION_login"
    ]
]

?>