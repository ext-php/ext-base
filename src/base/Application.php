<?php
/**
 * Created by PhpStorm.
 * User: chenxiansen <2545299401@qq.com>
 * Date: 2023/5/25
 * Time: 16:21
 */

use \Smater\ExtContainer\Container;

class Application extends Container
{

    protected $basePath;


    public function __construct($basePath = null)
    {
        if($basePath)
        {
            //设置基础路径
            $this->setBasePath($basePath);
        }

    }

    //设置基础路径
    protected function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath,'\/');

        var_dump($this->basePath);exit;
        


    }

}