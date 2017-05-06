<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 04.05.17
 * Time: 18:41
 */

namespace Fg\Model;

use Fg\Frame\Model\Model;

class AuthModel extends Model
{
    protected $table = 'client';

    public function getUser(string $login, string $pass)
    {
        $this->setCase('select');
        $this->setColumns(['id', 'login', 'rank']);
        $this->setWhere(["login = '" . $login ."'", "pass = '" . $pass . "'"]);
        $this->setLimit(1);

        return $this->executeQuery(true);
    }
}