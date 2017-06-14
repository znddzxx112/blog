> 数据直接过滤

```
public function filterContents($content, $striptags = false)
    {   
        if (is_array($content)) {
            foreach ($content as $key => $value) {
                $content[$key] = self::filterContents($value, $striptags);
            }   
            return $content;
        } else if (is_int($content)) {
            return $content;
        }   

        $content    = trim($content);
        if ($striptags) {
            return strip_tags($content);
        }   
        //$content    = stripslashes($content);
        $patterns = array(
            //'/&#[xX\d]/i',
            '/<script.*\/script>/is',
            '/\bon[a-z]+\s*=\s*("[^"]+"|\'[^\']+\'|[^\s]+)/i',
            '/javascript:.+/i',
            '/vbscript:.+/i',
            '/:expression.+/i',
            '/@import.+/i',
            '/<meta\s+(.*?)>/is',
            '/<object\s+(.*?)>/is',
            '/<iframe\s+(.*?)>/is',
            '/\/\*/is',
            '/\*\//is',
        );  
        foreach ($patterns as $pattern) {
            $content = preg_replace($pattern, '', $content);
        }   
        return $content;
    }
```

> 判断时候有有害html

```
public static function checkContents($content)
    {
        if(empty($content)) return TRUE;
        if (is_array($content)) {
            foreach ($content as $value) {
                if (!self::checkContents($value))
                    return FALSE;
            }
            return TRUE;
        } else if (is_int($content)) {
            return TRUE;
        }
        $content    = trim($content);
        //$content    = stripslashes($content);
        $patterns = array(
            //'/&#[xX\d]/i',
            '/<script.*\/script>/is',
            '/\bon[a-z]+\s*=\s*("[^"]+"|\'[^\']+\'|[^\s]+)/i',
            '/javascript:.+/i',
            '/vbscript:.+/i',
            '/:expression.+/i',
            '/@import.+/i',
            '/<meta\s+(.*?)>/is',
            '/<object\s+(.*?)>/is',
            '/<iframe\s+(.*?)>/is',
            '/\/\*/is',
            '/\*\//is',
        );
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return FALSE;
            }
        }
        return TRUE;
    }
```
