<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 11.03.17
 * Time: 12:54
 */

define('ROOTDIR', __DIR__ . '/..');

return [
    "routeConfig" => include('routing.php'),
    "layersDir" => include('lrsdir.php'),
    "validation" => include('validation.php')
];