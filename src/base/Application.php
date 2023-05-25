<?php
/**
 * Created by PhpStorm.
 * User: chenxiansen <2545299401@qq.com>
 * Date: 2023/5/25
 * Time: 16:21
 */
namespace CPhp\Base;

use \Smater\ExtContainer\Container;

class Application extends Container
{

    protected $basePath;

    protected $appPath;

    protected $storagePath;

    protected $databasePath;

    public function __construct($basePath = null)
    {
        if ($basePath) {
            //设置基础路径
            $this->setBasePath($basePath);
        }

        //注册基础绑定
        $this->registerBaseBindings();


    }

    //基础绑定
    protected function registerBaseBindings()
    {
        //Container $instance 已经赋值
        static::setInstance($this);
        /*
         * protected 'instances' =>
              'app' =>
                &object(Illuminate\Foundation\Application)[3]
              'Illuminate\Container\Container' =>
                &object(Illuminate\Foundation\Application)[3]
         */
        $this->instance('app', $this);
        $this->instance(Container::class, $this);





    }


    public static function setInstance(ContainerContract $container = null)
    {
        return static::$instance = $container;

    }

    //设置基础路径
    protected function setBasePath($basePath)
    {
        /* $basePath = D:\phpstudy_pro\WWW\My_Extensions\CPhp\bootstrap
            rtrim去除字符串末尾空格和其他字符
         *  $str2 = "Hello, World!-";
            echo rtrim($str2, "-"); // 输出结果： "Hello, World!"
         */
        $this->basePath = rtrim($basePath,'\/');

        //绑定路径到容器
        $this->bindPathsInContainer();

        return $this;

    }

    //绑定路径到容器
    protected function bindPathsInContainer()
    {

        /*
         * protected 'instances' =>
            array (size=40)
              'path' => string 'D:\phpstudy_pro\WWW\My_Extensions\testlaravel\app' (length=49)
              'path.base' => string 'D:\phpstudy_pro\WWW\My_Extensions\testlaravel' (length=45)
              'path.config' => string 'D:\phpstudy_pro\WWW\My_Extensions\testlaravel\config' (length=52)
              'path.public' => string 'D:\phpstudy_pro\WWW\My_Extensions\testlaravel\public' (length=52)
              'path.storage' => string 'D:\phpstudy_pro\WWW\My_Extensions\testlaravel\storage' (length=53)
              'path.database' => string 'D:\phpstudy_pro\WWW\My_Extensions\testlaravel\database' (length=54)
              'path.resources' => string 'D:\phpstudy_pro\WWW\My_Extensions\testlaravel\resources' (length=55)
              'path.bootstrap' => string 'D:\phpstudy_pro\WWW\My_Extensions\testlaravel\bootstrap' (length=
        */
        $this->instance('path',$this->path());
        $this->instance('path.base', $this->basePath());
        $this->instance('path.config', $this->configPath());
        $this->instance('path.public', $this->publicPath());
        $this->instance('path.storage', $this->storagePath());
        $this->instance('path.database', $this->databasePath());
        $this->instance('path.resources', $this->resourcePath());
        $this->instance('path.bootstrap', $this->bootstrapPath());
        $this->instance('path.lang', $this->basePath('lang'));


    }

    //启动目录
    public function bootstrapPath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'bootstrap'.($path != '' ? DIRECTORY_SEPARATOR.$path : '');
    }

    //视图目录
    public function resourcePath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'resources'.($path != '' ? DIRECTORY_SEPARATOR.$path : '');
    }

    //数据库目录
    public function databasePath($path = '')
    {
        return ($this->databasePath ?: $this->basePath.DIRECTORY_SEPARATOR.'database').($path != '' ? DIRECTORY_SEPARATOR.$path : '');
    }

    //存储目录
    public function storagePath($path = '')
    {
        return ($this->storagePath ?: $this->basePath.DIRECTORY_SEPARATOR.'storage').($path != '' ? DIRECTORY_SEPARATOR.$path : '');
    }

    //pubic目录
    public function publicPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'public';
    }

    //绑定app目录路径
    public function path($path = '')
    {
        $appPath = $this->appPath ?: $this->basePath.DIRECTORY_SEPARATOR.'app';

        return $appPath.($path != '' ? DIRECTORY_SEPARATOR.$path : '');

    }

    //绑定项目根目录
    public function basePath($path = '')
    {
        return $this->basePath.($path != '' ? DIRECTORY_SEPARATOR.$path : '');

    }

    //配置文件目录
    public function configPath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'config'.($path != '' ? DIRECTORY_SEPARATOR.$path : '');
    }

}