<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 21.04.17
 * Time: 17:26
 */

namespace Fg\Model;

use Fg\Frame\Model\Model;
use Fg\Frame\Exceptions\BadQueryException;

/**
 * Class ItemModel
 * @package Fg\Model
 */
class ItemModel extends Model
{
    protected $table = 'item';

    /**
     * EAV varTables of DB
     * @var array
     */
    protected $tables = ['item_val_int', 'item_val_varchar', 'item_val_double', 'item_val_date'];

    /**
     * @param $id
     * @return array
     */
    public function getVars(int $id): array
    {
        $result = [];
        for ($z = 0; $z < count($this->tables); $z++) {
            $arr = $this->getOneVar($this->tables[$z], $id);
            for ($i = 0; $i < count($arr); $i++) {
                $result[$arr[$i]['name']] = $arr[$i]['value'];
            }
        }
        return $result;
    }

    /**
     * get one type data from EAV DB model
     * @param string $table
     * @param int $id
     * @return mixed
     */
    public function getOneVar(string $table, int $id)
    {
        $this->setCase('select');
        $this->setColumns(['a.name', 'iv.value']);
        $this->table = 'item AS i, ' . $table . ' AS iv, attribute AS a ';
        $this->setWhere(['i.id = ' . $id, 'iv.item_id =' . $id, 'iv.attribute_id = a.id']);
        $this->setLimit(0);
        try {
            $stm = $this->db->prepare($this->build());
            $stm->execute();
            $this->checkErrors($stm);
        } catch (BadQueryException $e) {
            echo $e->getMessage();
        }
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * get category tree list
     *
     * @param null $id
     * @return mixed
     */
    public function getCategory(int $id = null)
    {
        $this->setCase('select');
        $this->setColumns(['id', 'parent_category_id', 'name', 'notice']);
        $this->table = 'category';

        if (is_null($id)) {
            $this->setWhere(['parent_category_id IS NULL']);
        } else {
            $this->setWhere(['parent_category_id = ' . $id]);
        }

        $this->setLimit(0);

        try {
            $stm = $this->db->prepare($this->build());
            $stm->execute();
            $this->checkErrors($stm);
        } catch (BadQueryException $e) {
            echo $e->getMessage();
        }
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * get item list
     *
     * @param $id
     * @return mixed
     */
    public function getItemList(int $id)
    {
        $this->setCase('select');
        $this->setColumns(['id', 'name', 'notice']);
        $this->table = 'item';
        $this->setWhere(['category_id = ' . $id]);
        $this->setLimit(0);

        try {
            $stm = $this->db->prepare($this->build());
            $stm->execute();
            $this->checkErrors($stm);
        } catch (BadQueryException $e) {
            echo $e->getMessage();
        }
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }
}