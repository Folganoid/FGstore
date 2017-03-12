<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 11.03.17
 * Time: 17:10
 */

namespace Fg;


class ItemController
{

    /**
     * All items
     */
    public function getAllItems(){

        echo '<b>'. __METHOD__ . '</b><br>';

    }

    /**
     * One item
     */

    public function getOneItem($id, $var){

        echo '<b>' . __METHOD__ . '</b><br>';

        echo sprintf("Hi! You requested %s with %s var", $id, $var);
    }

}