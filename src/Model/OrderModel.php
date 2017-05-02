<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 02.05.17
 * Time: 13:04
 */

namespace Fg\Model;

use Fg\Frame\Model\Model;

/**
 * Class OrderModel
 * @package Fg\Model
 */
class OrderModel extends Model
{
    protected $table = 'orders AS o, item AS i, orders_status AS os, client AS c';

    /**
     * get order_list
     *
     * @return mixed
     */
    public function getOrdersAll()
    {
        $this->setCase('select');
        $this->setColumns(["o.id", "i.name AS item_name", "i.id AS item_id", "CONCAT(c.name, ' ', c.surname) AS client", "c.id AS client_id", "os.status", "os.date_send", "os.date_recieve"]);
        $this->setWhere(['o.item_id = i.id', 'o.order_status_id = os.id', 'o.client_id = c.id']);
        $this->setLimit(0);

        return $this->executeQuery(true, true);

    }
}