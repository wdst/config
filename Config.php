<?php

/*
 * @author wds
 */

namespace wdst\config;

class AEception extends \Exception{
    
};

class Config {

    private $filename;
    private $type;
    private $extList = [
            'ini' => ['ini', 'cfg'],
            'php' => ['php']
        ];

    public function __construct($filename, $type = null)
    {
        return $this->filename($filename, $type);
    }
    
    public function filename($filename, $type = null)
    {
        if (!file_exists($filename)) {
            throw new \Exception("Config file does not exist: " . $filename);
        }

        $type = ($type === null) ? $this->getExtension($filename) : $type;

        if(empty($type) || !in_array($type, array_keys($this->extList))){
            throw new \Exception("Wrong type: " . $type);
        }

        $this->filename = $filename;
        $this->type = $type;
        return $this;
    }

    public function addExtList($type, $ext)
    {
        if(empty($type) || !in_array($type, array_keys($this->extList))){
            throw new \Exception("Wrong type: " . $type);
        }

        if(empty($ext)){
            throw new \Exception("Wrong ext: " . $ext);
        }

        if (in_array($type, array_keys($this->extList))) {
            $this->extList[$type] = array_merge($this->extList[$type], (array)$ext);
        } else {
            $this->extList[$type] = (array)$ext;
        }
        return $this;
    }

    private function getExtension($filename)
    {
        $tmp = explode('.', $filename);
        return end($tmp);
    }

    public function get($section = null, $key = null, $default = null)
    {
        if (empty($this->filename)) {
            throw new \Exception("Config file does not exist!");
        }

        $method = 'get' . $this->type;
        
        
            if(method_exists($this, $method)) {
                return $this->$method($section, $key, $default);
            } else {
                throw new \Exception("Wrong type " . $this->type);
            }
        
        return false;
    }

    protected function getini($section = null, $key = null, $default = null)
    {
        $ini = @parse_ini_file($this->filename, TRUE);

        if(empty($ini)){
            throw new \Exception("Config file is empty!");
        }

        return $this->parse($ini, $section, $key, $default);
    }

    /**
     * Example file .php must containt array
     * <?php
     *   return [
     *      [section] => [
     *         [key] => value
     *      ]
     *   ];
     */
    protected function getphp($section = null, $key = null, $default = null)
    {
        $phpfile = require $this->filename;

        if(empty($phpfile) or !is_array($phpfile)){
            throw new \Exception("Config file is bad!");
        }

        return $this->parse($phpfile, $section, $key, $default);
    }

    protected function parse($data, $section = null, $key = null, $default = null)
    {       
        if(!empty($section)) {

            if(empty($data[$section]))
                throw new \Exception("Config file does not contain section: " . $section);
            
            $result = $data[$section];

            if(!empty($key)) {
                return !empty($result[$key]) ? $result[$key] : $default;
            }
            return $result;
        }

        return $data;
    }

}
