<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 11.05.17
 * Time: 9:22
 */

namespace Fg\Model;

use Fg\Frame\Model\Model;

class BasketModel extends Model
{
    protected $table = 'basket';

    public function getBasketList(int $id)
    {
        $this->setCase('select');
        $this->setColumns(["b.id", "i.name", "b.item_id", "i.notice", "ivd.value AS price", "b.sum"]);
        $this->table = 'basket AS b, item AS i, item_val_double AS ivd';
        $this->setWhere(["b.client_id = " . $id, "b.item_id = i.id", "ivd.attribute_id = 1", "ivd.item_id = i.id"]);
        $this->setLimit(0);

        return $this->executeQuery(true, true);
    }

}