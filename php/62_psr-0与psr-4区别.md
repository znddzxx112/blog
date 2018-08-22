- 参考文章
```
https://laravel-china.org/articles/4681/analysis-of-the-principle-of-php-automatic-loading-function
```

- 结论
```
psr-0,psr-4 都是讲命令空间与文件目录的关系
psr-4相比psr-0，二者之间的关系更加简洁
psr-4 下划线没有特殊含义，不再对应目录
```

- PSR-0 风格
```
vendor/
    vendor_name/
        package_name/
            src/
                Vendor_Name/
                    Package_Name/
                        ClassName.php       # Vendor_Name\Package_Name\ClassName
            tests/
                Vendor_Name/
                    Package_Name/
                        ClassNameTest.php   # Vendor_Name\Package_Name\ClassName
```

- PSR-4 风格
```
顶级域名/包名 之后直接写类了
vendor/
    vendor_name/
        package_name/
            src/
                ClassName.php       # Vendor_Name\Package_Name\ClassName
            tests/
                ClassNameTest.php   # Vendor_Name\Package_Name\ClassNameTest
```
