<?php

/* 
 * @Company    Expoon.com
 * @Author     Libra 
 * @Email      316942723@qq.com
 */
set_time_limit(0);
$url = "/usr/local/http2/htdocs/put.txt";
$content = $HTTP_RAW_POST_DATA;
file_put_contents($url, $content);
