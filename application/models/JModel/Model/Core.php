<?php
namespace Model;
class Core Extends \CI_Model{
    private static $dbCache = array();
    public function __CONSTRUCT(){
        parent::__CONSTRUCT();
        //init default database
        if(!isset($this->db))
            $this->load->database();
        self::$dbCache['DB'] = $this->db;
    }
    public static function __callStatic($name, $argc){
        return self::$dbCache[$name];
    }
    private function __CLONE(){}
    private function __WAKEUP(){}
    private static $instance = null;
    public function GetDB(){
        return $this->db;
    }
    public static function Initialize(){
        if(self::$instance === null){
            self::$instance = new static();
        }
        return self::$instance;
    }
}