<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 02.05.17
 * Time: 14:13
 */

namespace Fg\Model;

use Fg\Frame\Model\Model;

/**
 * Class ClientModel
 * @package Fg\Model
 */
class ClientModel extends Model
{
    protected $table = 'client';

    /**
     * get order list by client_id
     *
     * @param int $id
     * @return mixed
     */
    public function getOrdersAll(int $id)
    {
        $this->setCase('select');
        $this->setColumns(["o.id", "i.name AS item_name", "i.id AS item_id", "os.status", "os.date_send", "os.date_receive", "o.sum", "ivd.value"]);
        $this->table = 'orders AS o, item AS i, orders_status AS os, client AS c, item_val_double AS ivd';
        $this->setWhere(['o.item_id = i.id', 'o.order_status_id = os.id', 'o.client_id = c.id', 'ivd.attribute_id = 1', 'ivd.item_id = i.id', 'o.client_id=' . $id]);
        $this->setLimit(0);

        return $this->executeQuery(true, true);

    }


}

