> 通过require xx.php文件获取文件中的内容

> 有价值的获取数据方式

```

public function intoPhpFile($data, $file)
{
    $str = '<?php return ' .var_export($data, true). '?>';
    $fp = fopen($file, "w");
    flock($fp, LOCK_EX);
    fwrite($fp, $str);
    flock($fp, LOCK_UN);
    fclose($fp);
}

```
