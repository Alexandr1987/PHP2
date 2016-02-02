<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 01.02.2016
 * Time: 15:32
 */

namespace App;


class Config


{

    public $data = [];

    protected static $instance;

    protected function __construct()
    {
        $this->data = require(__DIR__ . '/../config.php');
    }

    public static function instance()
    {
        if (null === static::$instance) {
            static::$instance = new static;
        }
        return static::$instance;
    }


}