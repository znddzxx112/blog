<?php 
namespace Znddzxx112\Designpatten;

trait Singleton {
    private static $instance = null;

    final public static function get_instance(){
        if(static::$instance == null){
            static::$instance = new static();
        }
        return static::$instance;
    }

    final public static function set_instance($newInstance){
        static::$instance = $newInstance;
    }
}

// 使用构件，节省代码
class redisHandle {

  use Singleton;

}
