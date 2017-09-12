```
function parseData($filename)
{
    $fp = fopen($filename, "r");
    $title = fgetcsv($fp);
    while(!feof($fp)) {
        $data[] = fgetcsv($fp);// 一行数据,分隔符,的数组
    }
    fclose($fp);
    return $data;
}
```
