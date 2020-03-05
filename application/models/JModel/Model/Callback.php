<?php
namespace Model;
class Callback {
    public static function MD5Filter($str, $loop = 3, $type = true){
        $loop = intval($loop);
        while($loop != 0){
            if($type)
                $str = "md5(".$str.")";
            else
                $str = md5($str);
            $loop--;
        }
        return $str;
    }
}