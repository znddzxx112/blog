> 方式一
```
$filename = "resolved_" . date('YmdHis') . '.xls';
header("Content-type: application/x-xls");
header("Content-Disposition: attachment; filename={$filename}");
$outputBuffer = fopen("php://output", 'w');
fputcsv($outputBuffer, []);
fclose($outputBuffer);
```

> 方式二
```
$filecontent = file_get_content("$filename");
```
