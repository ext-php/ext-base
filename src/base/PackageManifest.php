<?php
/**
 * Created by PhpStorm.
 * User: chenxiansen <2545299401@qq.com>
 * Date: 2023/5/29
 * Time: 10:41
 */

namespace CPhp\Base;

//加载程序扩展包，并注册这些扩展包提供的服务提供者
use CPhp\Base\Filesystem\Filesystem;

class PackageManifest
{
    public $files;

    public $basePath;

    public $manifestPath;

    public $vendorPath;

    public function __construct(Filesystem $files, $basePath, $manifestPath)
    {
        $this->files = $files;
        $this->basePath = $basePath;
        $this->manifestPath = $manifestPath;
        //TODO
        $this->vendorPath = $basePath."/vendor";

    }

}