- 思路：一天24小时可以通过0~23.5959来表示
- 如18:34 等同于 18.34
- 如06:32 等同于 6.32
- 使用date('G.i')
- 判断区间函数具体实现
```
function judgeSection($time)
{
    $sectionid = 0;
    $num = date('G.i', $time);
    if ($num > 0 && $num <= 7) {// 0:00~7:00范围内
        $sectionid = 1;
    } elseif ($num > 7 && $num <= 9) {
        $sectionid = 2;
    } elseif ($num > 9 && $num <= 11.30) {
        $sectionid = 3;
    } elseif ($num > 11.30 && $num <= 13) {
        $sectionid = 4;
    } elseif ($num > 13 && $num < 15) {
        $sectionid = 5;
    } else {
        $sectionid = 6;
    }
    return (int)$sectionid;
}
```
