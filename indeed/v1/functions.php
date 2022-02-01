<?php
function get_string_between($string, $start, $end)
{
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function get($q)
{
    return isset($_GET[$q]) ? htmlspecialchars($_GET[$q]) : null;
}

function get_cURL($url)
{
    return file_get_contents($url);
}

function response($url)
{
    $content = false;
    $file_url = './files/' . md5($url) . '.txt';
    if (file_exists($file_url)) {
        $create_time = filectime($file_url);
        if (time() - 600 < $create_time) {
            $content = file_get_contents($file_url);
        }
    }
    if (!$content) {
        $content = get_cURL($url);
        file_put_contents($file_url, $content);
    }
    return $content;
}