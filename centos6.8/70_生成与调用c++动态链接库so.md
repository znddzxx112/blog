- 前言
```
不同组件之间，如何提供一个动态库给其他Team使用，这样使用者也不需要关心和维护你的代码。

Java中经常的做法就是打成Jar包，
c++动态链接库so和静态的链接库。

so = shared object
```

- 编写testso.h
```
#ifndef _TESTSO_H
#define _TESTSO_H              
extern "C" {
            int myadd(int a, int b);        
                typedef int myadd_t(int, int); // myadd function type
}
#endif // _TESTSO_H   
```

- 编写testso.cpp
```
#include "testso.h"

extern "C" 
int myadd(int a, int  b)  
{
            return a + b;
}
```

- 生成so动态库
```
g++  -shared  -fPIC  -o libtestso.so testso.cpp
```

- 编写main文件testsomain.cpp
```

#include "testso.h"
#include <iostream>

int main(int argc, char *argv[])
{
        int res = myadd(1, 2); 
        std::cout<< res << std::endl;
        return 0;
}
```

- 编译生成执行文件
```
g++ -o testsomain testsomain.cpp -ltestso -L/home/xxx/src/cpp
```

- 编写testso.ld
```
vim /etc/ld.so.conf.d/testso.conf 
/home/xxx/src/cpp
```

- ld.conf生效
```
执行$ ldconfig
```

- 执行可执行文件testsomain
```
chmod 744 testsomain
./testsomain
```
