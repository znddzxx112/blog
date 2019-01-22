- 需求
> feed时间流中包含多个类型

> 多个类型既有共性和特性,共性：共有的要素，时间，用户等。特性：独特的要素，价格展示

> 需要扩展：内容类型将会不断增多

> 要求共有方法：每个内容增加/删除到Feed中

> 需要抽象性：feed时间流可以在多个地方使用


> feed中内容类型抽象基类

> feed中内容都需要继承此基类

```
abstract class Core_Feed_Content_Abstract
{
    // feed中id
    protect $_id = null;
    // 内容产生者
    protect $_userid = null;
    // 内容id
    protect $_pid = null;
    // 内容类型
    protect $_type = null;
    // 内容产生时间
    protect $_ctime = null;
    // 插入内容前置动作
    abstract public function checkPreAdd() : bool;
    // 内容插入数据
    abstract public function getInsertParams() : array;
    // 内容渲染工作
    abstract public function renderHtml($renderPath =  '') : string
}
```

> feed时间流统一的操作类
```
abstract class Core_Feed_Abstract
{
    // 加载feed内容实例
    abstract static public function load($contentType = '') : Core_Feed_Content_Abstract;
    // 将内容插入feed时间流中
    abstract static public function insert(Core_Feed_Content_Abstract $content) : bool;
    // 删除feed时间中内容
    abstract static public function delete(Core_Feed_Content_Abstract $content) : bool;
}
```
