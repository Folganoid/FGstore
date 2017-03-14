<?php
/**
 * Created by PhpStorm.
 * User: fg
 * Date: 14.03.17
 * Time: 19:16
 */

namespace Fg;

/**
 * Class MainController
 * @package Fg
 */
class MainController
{
    protected $configDir;

    /**
     * MainController constructor.
     * @param array $configDir
     */
    public function __construct(array $configDir = [])
    {
        $this->configDir = include( __DIR__ . '/../config/lrsdir.php' );
    }
}