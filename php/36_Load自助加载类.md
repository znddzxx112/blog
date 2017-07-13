> 全局加载类

```

class Public_Loader
{
    protected static $_instance = array();
    
    public static function load($class)
    {
        if (!isset(self::$_instance[$class])) {
            self::$_instance[$class] = self::get($class);
        }
        return self::$_instance[$class];
    }
    
    public static function get($class)
    {
        if (class_exists($class)) {
            return new $class();
        }
        return null;
    }
}

```
