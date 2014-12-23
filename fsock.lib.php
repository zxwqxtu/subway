<?php
class Fsock
{
    const SOCK_EOL = "\r\n"; 

    private static $_port = 80;
    private static $_params = array();
    private static $_method = 'GET';
    private static $_timeOut = 30;
    private static $_content = '';
    private static $_head = '';
    private static $_body = '';
    private static $_requestHeader= array(); 
    

    public static function url($url, $method="GET", $param = array(), $requestHeaders=array(), $port=80) {
        self::$_method = strtoupper($method);
        self::$_params = $param;
        self::$_port = $port;
        self::_setUrl($url, $requestHeaders);   
        return self::$_content;
    }

    public static function getBody($url='',$method="GET", $param = array(), $requestHeaders=array(), $port=80) {
        if (!empty($url)) {
            self::$_content = self::url($url, $method, $param, $requestHeaders, $port);   
        } 
        $arr = explode(self::SOCK_EOL.self::SOCK_EOL, self::$_content);
        self::$_head = $arr[0];
        self::$_body = $arr[1];
        return self::$_body;
    }

    public static function getHead($url='',$method="GET", $param = array(), $requestHeaders=array(), $port=80) {
        if (!empty($url)) {
            self::$_content = self::url($url, $method, $param, $requestHeaders, $port);   
        }
        $arr = explode(self::SOCK_EOL.self::SOCK_EOL, self::$_content);
        self::$_head = $arr[0];
        self::$_body = $arr[1];
        return self::$_head;
    }

    public static function setHeader($headers) {
        return self::$_requestHeader = array_merge(self::$_requestHeader, $headers);
    }

    public static function getheader() {
        return  self::$_requestHeader;      
    }

    private static function _setUrl($url, $headers=array()) {
        $urlArr = parse_url($url);
        $host = $urlArr['host'];
        if ($urlArr['scheme'] == 'https') {
            self::$_port = 443;
            $host = 'ssl://'.$host;
        }
        $fp = fsockopen($host, self::$_port, $errno, $errstr, self::$_timeOut);
        if (!$fp) {
            throw new Exception($errstr);
        }
       
        if (!empty(self::$_params)) { 
            $queryStr = http_build_query(self::$_params); 
            switch (self::$_method) {
            case 'GET':
               $urlArr['query'] .= '&'.$queryStr; 
               break;
            case 'POST':
                self::setHeader(array('Content-Type'=>'application/x-www-form-urlencoded'));
            default:
                self::setHeader(array('Content-Length'=>strlen($queryStr)));
                break;
            }
        }

        $out = '';

        $query = !empty($urlArr['path'])?$urlArr['path']:'/';
        $query .= empty($urlArr['query'])?'':'?'.$urlArr['query'];
        $method = self::$_method;
        $out .= "{$method} {$query} HTTP/1.1".self::SOCK_EOL;
        $out .= "Host: {$urlArr['host']}".self::SOCK_EOL;

        self::setHeader(array('Connection'=>'Close'));
        self::setHeader($headers);

        foreach(self::$_requestHeader as $k=>$v) {
            $out .= $k.': '.$v.self::SOCK_EOL;
        }
        $out .= self::SOCK_EOL;
        if (self::$_method != 'GET' && !empty($queryStr)) {
            $out .= $queryStr;
        } 
        fwrite($fp, $out);
        self::$_head = self::$_body = self::$_content = '';
        while (!feof($fp)) {
            self::$_content .= fgets($fp);
        }
        fclose($fp);
    }
}
