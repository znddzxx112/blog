- php脚本执行过程
```
1. 词法，语法分析生成抽象语法树
2. 根据语法树生成opcodes -> opcodes 由一条条opcode,一条opcode对应一条操作执行handle
3. zend核心执行一条条的opcode
总结：一个php脚本作为zend核心的输入

```
