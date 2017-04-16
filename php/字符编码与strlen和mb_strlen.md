- 字符集unicode
```
# 官网 http://www.unicode.org/
# 中文对照表 http://www.chi2ko.com/tool/CJK.htm
# 中文与unicode码互查工具
# http://tool.chinaz.com/tools/unicode.aspx
# 中文在\u4e00-\u9fa5范围内
# a \u0061 b \u0062
# unicode使用4个字节表示一个字符 - 是一种多字节字符集
```

- 字符集ascii
```
# 是一种单字节字符集
# 仅仅使用单个字节来表示，所以最多表示256个字符
```

- 编码方式utf8
```
UTF-8（8-bit Unicode Transformation Format）是一种针对Unicode的可变长度字符编码。
# 对unicode字符集进行编码，注意变长
# 可能是一个字节，二个字节，三个字节，四个字节，中文可能是3个字节或者4个字节来表示
```

- strlen
```
# 计算字符串所占的字节数 - 计算单字节字符串
# 英文字母，往往一个字节
```

- mb_strlen
```
# 计算字符串的字符数 - 计算多字节字符串
mb_strlen($str, 'UTF-8');
# 支持的编码
# http://php.net/manual/zh/mbstring.supported-encodings.php
```


- utf8，3个字节表示中文
```
U+2E80 - U+2EF3 : 0xE2 0xBA 0x80 - 0xE2 0xBB 0xB3      共 115 个  
U+2F00 - U+2FD5 : 0xE2 0xBC 0x80 - 0xE2 0xBF 0x95      共 213 个  
U+3005 - U+3029 : 0xE3 0x80 0x85 - 0xE3 0x80 0xA9      共 36 个  
U+3038 - U+4DB5 : 0xE3 0x80 0xB8 - 0xE4 0xB6 0xB5      共 7549 个  
U+4E00 - U+FA6A : 0xE4 0xB8 0x80 - 0xEF 0xA9 0xAA      共 44138 个  
U+FA70 - U+FAD9 : 0xEF 0xA9 0xB0 - 0xEF 0xAB 0x99      共 105 个  
```

- utf-8，4个字节表示中文
```
U+20000 - U+2FA1D : 0xF0 0xA0 0x80 0x80 - 0xF0 0xAF 0xA8 0x9D      共 64029 个  
```

