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
     * get vars by ID-iteb from EAV DB model
     *
     * @param int $id
     * @return mixed
     */
    public function getVars(int $id)
    {
        $this->setCase('select');
        $this->setColumns(['a.name', 'CONCAT(ivv.value, ivi.value, ivd.value, ivb.value) AS value']);
        $this->table = 'attribute AS a 
            LEFT OUTER JOIN item_val_int AS ivi ON (ivi.attribute_id = a.id)
            LEFT OUTER JOIN item_val_varchar AS ivv ON (ivv.attribute_id = a.id)
            LEFT OUTER JOIN item_val_date AS ivd ON (ivd.attribute_id = a.id)
            LEFT OUTER JOIN item_val_double AS ivb ON (ivb.attribute_id = a.id)';
        $this->setWhere([$id . ' IN (ivi.item_id, ivb.item_id, ivd.item_id, ivv.item_id)']);
        $this->setLimit(0);

        try {
            $stm = $this->db->prepare($this->build());
            $stm->execute();
            $this->checkErrors($stm);
        } catch (BadQueryException $e) {
            echo $e->getMessage();
        }
        $arrDB = $stm->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        for($i=0 ; $i<count($arrDB); $i++) {
            $result[$arrDB[$i]['name']] = $arrDB[$i]['value'];
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

    public function getCatName(int $id){
        $this->setCase('select');
        $this->setColumns(['name', 'notice']);
        $this->table = 'category';
        $this->setWhere(['id = ' . $id]);
        $this->setLimit(1);

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