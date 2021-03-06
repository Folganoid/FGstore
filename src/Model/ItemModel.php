<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 21.04.17
 * Time: 17:26
 */

namespace Fg\Model;

use Fg\Frame\Model\Model;

/**
 * Class ItemModel
 * @package Fg\Model
 */
class ItemModel extends Model
{
    protected $table = 'item';

    /**
     * get vars by ID-item from EAV DB model
     *
     * @param int $id
     * @return mixed
     */
    public function getVars(int $id)
    {
        $this->setCase('select');
        $this->setColumns(['a.name', 'a.unit', 'CONCAT(ivv.value, ivi.value, ivd.value, ivb.value) AS value']);
        $this->table = 'attribute AS a';
        $this->setLeftJoin([
            ['item_val_int AS ivi', 'ivi.attribute_id = a.id'],
            ['item_val_varchar AS ivv', 'ivv.attribute_id = a.id'],
            ['item_val_date AS ivd', 'ivd.attribute_id = a.id'],
            ['item_val_double AS ivb', 'ivb.attribute_id = a.id']
        ]);
        $this->setWhere([$id . ' IN (ivi.item_id, ivb.item_id, ivd.item_id, ivv.item_id)']);
        $this->setLimit(0);

        $arrDB = $this->executeQuery(true, true);
        $result = [];

        for ($i = 0; $i < count($arrDB); $i++) {
            $result[] = [$arrDB[$i]['name'], $arrDB[$i]['value'] . ' ' . $arrDB[$i]['unit']];
        }

        return $result;
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
        $this->setOrderBy(['name']);

        if (is_null($id)) {
            $this->setWhere(['parent_category_id IS NULL']);
        } else {
            $this->setWhere(['parent_category_id = ' . $id]);
        }

        $this->setLimit(0);
        return $this->executeQuery(true, true);
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

        return $this->executeQuery(true, true);
    }

    /**
     * get parent category name
     *
     * @param int $id
     * @return mixed
     */
    public function getCatName(int $id)
    {
        $this->setCase('select');
        $this->setColumns(['name', 'notice']);
        $this->table = 'category';
        $this->setWhere(['id = ' . $id]);
        $this->setLimit(1);

        return $this->executeQuery(true, true);
    }

    /**
     * add data in EAV paramtables
     *
     * @param array $arr
     * @param int $id_item
     * @param bool $isText
     */
    public function addVarsEAVTable(string $tableName, array $arr, int $id_item, bool $isText = false)
    {
        $this->setTable($tableName);

        for ($i = 0; $i < count($arr); $i++) {
            $this->setCase('update');
            $this->setColumns(['value']);

            $value = $arr[$i][1];
            if ($isText) $value = "'" . $value . "'";
            $this->setValues([$value]);
            $this->setWhere(['attribute_id = ' . $arr[$i][0], 'item_id =' . $id_item]);
            $this->setReturning('id');
            $return_id = $this->executeQuery(true);

            if (!$return_id) {
                $this->insert([$arr[$i][0], $id_item, $value], ['attribute_id', 'item_id', 'value']);
                $this->executeQuery();
            }
        }
    }

    /**
     * add data in EAV paramtables by create item
     *
     * @param string $tableName
     * @param array $arr
     * @param int $item_id
     * @param bool $isText
     */
    public function addVarsEAVTableByCreateItem(string $tableName, array $arr, int $item_id, bool $isText = false)
    {
        $this->setTable($tableName);

        for ($i = 0; $i < count($arr); $i++) {
            $value = $arr[$i][1];
            if ($isText) $value = "'" . $value . "'";
            $this->insert([$arr[$i][0], $item_id, $value], ['attribute_id', 'item_id', 'value']);
            $this->executeQuery();
        }
    }

}