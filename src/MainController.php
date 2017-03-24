<?php

namespace Fg;

use Fg\Frame\Validation\Validation;

/**
 * Class MainController
 * @package Fg
 */
class MainController
{
    protected $configDir;

    private $viewFile;

    /**
     * MainController constructor.
     * @param array $configDir
     */
    public function __construct(array $configDir = [])
    {

        $this->configDir = Validation::checkConfigFile(ROOTDIR . '/config/lrsdir.php');
    }

    /**
     * set view template file
     * @param $path
     */
    public function setViewFile($path)
    {
            $this->viewFile = $path;
    }

    public function getViewFile(): string
    {
        return $this->viewFile;
    }

}