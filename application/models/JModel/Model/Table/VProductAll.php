<?php
namespace Model\Table;
use \Model\Core;
class VProductAll extends Support{
    //make singleton
    //if PHP 5.4 > change to traits to efficiency of code
	private function __CONSTRUCT(){
        $this->Config(
            "vproduct_all",
            array(
                "*"
            ),
            array(
                "id", 
                "item_id",
                "satuan_id",
                "name",
                "description",
                "price", 
                "price_m", 
                "foto_name", 
                "foto_original",
                "unit",
                "available_count",
            )
        );
    }
    private function __CLONE(){}
    private function __WAKEUP(){}
    private static $instance = null;
    public static function Get(){if(self::$instance === null){self::$instance = new static();}return self::$instance;}
    
    public function UpdateContent($ref, $content=array()){
        
    }
    public function SupportContent(&$data){
        
    }
    public function InsertContent($id, $content=array()){
        
    }
    public function DeleteContent($data){
    }
}