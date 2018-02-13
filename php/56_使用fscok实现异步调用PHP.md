- 参考文章：http://www.laruence.com/2008/04/16/98.html
```
function triggerRequest($url, $post_data = array(), $cookie = array())…{
        $method = "GET";  //可以通过POST或者GET传递一些参数给要触发的脚本
        $url_array = parse_url($url); //获取URL信息，以便平凑HTTP HEADER
        $port = isset($url_array['port'])? $url_array['port'] : 80; 
      
        $fp = fsockopen($url_array['host'], $port, $errno, $errstr, 30); 
        if (!$fp) …{
                return FALSE;
        }
        $getPath = $url_array['path'] ."?". $url_array['query'];
        if(!empty($post_data))…{
                $method = "POST";
        }
        $header = $method . " " . $getPath;
        $header .= " HTTP/1.1\r\n";
        $header .= "Host: ". $url_array['host'] . "\r\n "; //HTTP 1.1 Host域不能省略
        /**//*以下头信息域可以省略
        $header .= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13 \r\n";
        $header .= "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,q=0.5 \r\n";
        $header .= "Accept-Language: en-us,en;q=0.5 ";
        $header .= "Accept-Encoding: gzip,deflate\r\n";
         */

        $header .= "Connection:Close\r\n";
        if(!empty($cookie))…{
                $_cookie = strval(NULL);
                foreach($cookie as $k => $v)…{
                        $_cookie .= $k."=".$v."; ";
                }
                $cookie_str =  "Cookie: " . base64_encode($_cookie) ." \r\n";//传递Cookie
                $header .= $cookie_str;
        }
        if(!empty($post_data))…{
                $_post = strval(NULL);
                foreach($post_data as $k => $v)…{
                        $_post .= $k."=".$v."&";
                }
                $post_str  = "Content-Type: application/x-www-form-urlencoded\r\n";//POST数据
                $post_str .= "Content-Length: ". strlen($_post) ." \r\n";//POST数据的长度
                $post_str .= $_post."\r\n\r\n "; //传递POST数据
                $header .= $post_str;
        }
        fwrite($fp, $header);
        //echo fread($fp, 1024); //我们不关心服务器返回
        fclose($fp);
        return true;
}
```
