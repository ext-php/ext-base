<?php
/**
 * Created by PhpStorm.
 * User: chenxiansen <2545299401@qq.com>
 * Date: 2023/5/29
 * Time: 11:15
 */

namespace CPhp\Base\Support;


use Dotenv\Repository\Adapter\PutenvAdapter;
use Dotenv\Repository\RepositoryBuilder;
use PhpOption\Option;

class Env
{

    protected static $repository;

    protected static $putenv = true;

    public static function enablePutenv()
    {
        static::$putenv = true;
        static::$repository = null;
    }

    public static function disablePutenv()
    {
        static::$putenv = false;
        static::$repository = null;
    }


    public static function get($key,$default = null)
    {
            Option::fromValue(static::getRepository()->get($key))->map(function ($value){
               switch (strtolower($value))
               {
                   case 'true':
                   case '(true)':
                       return true;
                   case 'false':
                   case '(false)':
                       return false;
                   case 'empty':
                   case '(empty)':
                       return '';
                   case 'null':
                   case '(null)':
                       return;

               }

                if (preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
                    return $matches[2];
                }

                return $value;
            })->getOrCall(fn () => value($default));

    }

    public static function getRepository()
    {
        if(static::$repository == null)
        {
            $builder = RepositoryBuilder::createWithDefaultAdapters();

            if(static::$putenv)
            {
                $builder = $builder->addAdapter(PutenvAdapter::create());
            }

            static::$repository = $builder->immutable()->make();
        }

        return static::$repository;

    }

}