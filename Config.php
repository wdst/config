<?php
/*
 * @author wds
 */

namespace wdst\config;

class Config{

    public static $file = null;

    public static function get($section = null, $key = null, $default = null)
    {
        $ini = null;
        if(file_exists(self::$file)){
            $ini = parse_ini_file(self::$file, TRUE);
        } else {
            print "File " . self::$file . " not found\n";
            error_log("File " . self::$file . " not found");
        }

        $result = !empty($section) && !empty($ini[$section]) ?
                    $ini[$section] : $ini;

        if(!empty($key)){
            $result = !empty($result[$key]) ? $result[$key] : $default;
        }

        return $result;
    }
}