<?php
namespace Model\Table;
use \Model\Core;
use \Model\Callback;
abstract class Support{
    protected $tableName = "";
    protected $select = array();
    protected $coulomn = array();
    protected $dataTable = null;
    protected function Config($tableName = "", $select = array(), $coulomn = array()){
        $this->tableName = $tableName;
        $this->select = $select;
        $this->coulomn = $coulomn;
        $this->dataTable = new \StdClass();
        $this->dataTable->search = array();
        $this->dataTable->order = array();
        $this->dataTable->order_default = new \StdClass();
        $this->dataTable->order_default->index = 0;
        $this->dataTable->order_default->as = "asc";
    }
    
    public function ById($id = null, $no_colomn = null, $support = false){
        if(is_null($id)) return array();
        if(is_null($no_colomn)) $no_colomn = 0;
        Core::DB()->select($this->select[0]);
        Core::DB()->from($this->tableName);
        if(array_key_exists($no_colomn,$this->coulomn)){
            Core::DB()->where(array(
                $this->coulomn[$no_colomn] => $id
            ));
        }
        
        $rest = Core::DB()->get()->result();
        if(empty($rest)) return array();
        $rest = $rest[0];
        if($support) $this->SupportContent($rest);
        return $rest;
    }
    //Deprecated - function -
    public function UpdateById($id = null, $data) {
        if(is_null($id)) return false;
        Core::DB()->where(array(
            $this->coulomn[0] => $id
        ));
        if(empty($data)) return false;
        if(is_object($data)) $data = (array)$data;
        if(!is_array($data)) return false;
        return Core::DB()->update($this->tableName, $data);
    }
    public function ArrayWhere($config){
        if(!is_array($config)) return array();
        $rest = array();
        foreach($config as $value){
            if(count($value) == 3){
                if(array_key_exists($value[0], $this->coulomn)){
                    $index = $this->coulomn[$value[0]];
                    if($value[1] > 0)
                    $index = $this->MD5Filter($index, $value[1]);
                    $rest[$index] = $value[2];
                }
            }
        }
        return $rest;
    }
    public function DeleteById($id = null, $support = false){
        if(is_null($id)) return false;
        Core::DB()->where(array(
            $this->coulomn[0] => $id
        ));
        $rest = Core::DB()->delete($this->tableName);
        if(empty($rest)) return false;

        if($support) $this->DeleteContent($rest);
        return $rest;
    }
    //Data Table
    public function DataTableSearch($config=array()){
        if(empty($config) && !is_array($config)){
            $temp = $this->dataTable->search;
            return $temp;
        }else{
            $this->dataTable->search = $config;
        }
    }
    public function DataTableOrder($config=array()){
        if(empty($config) && !is_array($config)){
            $temp = $this->dataTable->order;
            return $temp;
        }else{
            $this->dataTable->order = $config;
        }
    }
    protected function DataTablesQuery($config = array())
    {
        if(!is_object($config)) $config = (object)$config; //make config as object
        Core::DB()->from($this->tableName); //Set From
        $i = 0;
        //building block search from setting
        $tempSearch = $this->coulomn;
        if(!empty($this->dataTable->search) && is_array($this->dataTable->search)){
            $tempSearch = array();
            foreach($this->dataTable->search as $value){
                if(array_key_exists($value, $this->coulomn))
                    array_push($tempSearch, $this->coulomn[$value]);
            }
        }
        //building block order from setting
        $tempOrder = $this->coulomn;
        if(!empty($this->dataTable->order) && is_array($this->dataTable->order)){
            $tempOrder = array();
            //array_push($tempOrder, null); //add to stack order qualification
            foreach($this->dataTable->order as $value){
                if(array_key_exists($value, $this->coulomn))
                    array_push($tempOrder, $this->coulomn[$value]); //add to stack order qualification
            }
        }
        foreach ($tempSearch as $item) // loop column 
        {
            if(isset($config->value) && $config->value != "") // if datatable send POST for search $_POST['search']['value'] => $config->value
            {
                if($i===0) // first loop
                {
                    Core::DB()->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    Core::DB()->like($this->tableName.'.'.$item, $config->value);
                }
                else
                {
                    Core::DB()->or_like($this->tableName.'.'.$item, $config->value);
                }
    
                if(count($tempSearch) - 1 == $i){
                    if(isset($config->valueException)){
                        if(isset($config->valueException->tableName)){
                            if(isset($config->valueException->coulomn) && is_array($config->valueException->coulomn)){
                                foreach($config->valueException->coulomn as $valsEx){
                                    Core::DB()->or_like($config->valueException->tableName.'.'.$valsEx, $config->value);
                                }
                            }
                        }
                    }
                    Core::DB()->group_end(); 
                }
            }
            $i++;
        }
        if(isset($config->columns)){
            if(is_array($config->columns)){
                foreach($config->columns as $key => $value){
                    if($value != ""){
                        if(array_key_exists($key, $this->coulomn))
                            Core::DB()->like($this->tableName.'.'.$this->coulomn[$key], $value);
                    }
                }
            }    
        }
        if(isset($config->order)) // here order processing $_POST['order'] => $config->order
        {
            //$_POST['order']['0']['dir'] => $config->order->dir
            //$_POST['order']['0']['column'] => $config->order->column
            
            if(array_key_exists($config->order->column, $tempOrder))
                Core::DB()->order_by($tempOrder[$config->order->column], $config->order->dir);
            if(is_string($config->order->column)){
                Core::DB()->order_by($config->order->column, $config->order->dir);
            }
        } 
        else if(isset($this->dataTable->order))
        {
            
            //key($order) => $this->dataTable->order_default->index
            //$order[key($order)] => $this->dataTable->order_default->as
            foreach($this->dataTable->order as $key=>$value){
                if($value != ""){
                    if(array_key_exists($key, $this->coulomn))
                        Core::DB()->order_by($this->coulomn[$key], $value);
                }
            }
            //default
            //Core::DB()->order_by($this->dataTable->order_default->index, $this->dataTable->order_default->as);
        }
    }
    public function DataTables($config){
        if(isset($config->contextWhere)){
            if(is_object($config->contextWhere)) $config->contextWhere = (array)$config->contextWhere;
            else{
                if(!is_array($config->contextWhere) && !is_string($config->contextWhere)) unset($config->contextWhere);
            }
        }
        if(isset($config->contextOrder)){
            if(is_object($config->contextOrder)) $config->contextOrder = (array)$config->contextOrder;
            else{
                if(!is_array($config->contextOrder)) unset($config->contextOrder);
            }
        }
        if(isset($config->contextSelect)){
            if(is_object($config->contextSelect)) $config->contextSelect = (array)$config->contextSelect;
            else{
                if(!is_array($config->contextSelect) && !is_string($config->contextSelect)) unset($config->contextSelect);
            }
        }

        
        $tempJoinParam = new \StdClass();
        if(isset($config->joinParam)){
            $tempJoinParam = $config->joinParam;
        }
        if(isset($config->join)){
            $tempJoin = new \ReflectionFunction($config->join);
            if(!$tempJoin->isClosure())
            {
                unset($config->join);   
            }
        }










        $result = new \StdClass();
        if(isset($config->contextWhere)) $this->ContextWhere($config->contextWhere, null);//Core::DB()->where($config->contextWhere);
        if(isset($config->contextSelect)) $this->ContextSelect($config->contextSelect);
        if(isset($config->join)) {
            $closure = $config->join;
            $closure($tempJoinParam);
        }
        if(isset($config->contextOrder)) {
            foreach($config->contextOrder as $key=>$value){
                Core::DB()->order_by($key, $value);
            }
        }


        $this->DataTablesQuery($config);
        if($config->length != -1)
            Core::DB()->limit($config->length, $config->start);
        $query = Core::DB()->get();

        $result->table = $query->result();
        if(isset($config->contextWhere)) $this->ContextWhere($config->contextWhere, null);//Core::DB()->where($config->contextWhere);
        if(isset($config->contextSelect)) $this->ContextSelect($config->contextSelect);
        if(isset($config->join)) {
            $closure = $config->join;
            $closure($tempJoinParam);
        }
        $this->DataTablesQuery($config);
        //$query = Core::DB()->get();
        $result->filter = Core::DB()->count_all_results();

        if(isset($config->contextWhere)) $this->ContextWhere($config->contextWhere, null);//Core::DB()->where($config->contextWhere);
        if(isset($config->contextSelect)) $this->ContextSelect($config->contextSelect);
        if(isset($config->join)) {
            $closure = $config->join;
            $closure($tempJoinParam);
        }
        Core::DB()->from($this->tableName);
        $result->countAll = Core::DB()->count_all_results();
        
        return $result;

    }
    
    //Basic Operation
    public function Adding($data, $dataO=array()){
        if(empty($data)) return false;
        if(is_array($data)) $data = (object)$data;
        $rest = Core::DB()->insert($this->tableName, $data);
        if(!$rest) return $this->ReportToLog();
        //if(!isset(Core::DB()->insert_id())) return true;
        $data->insert_id = Core::DB()->insert_id();
        $this->InsertContent($data, $dataO);
        return $data->insert_id;
    }
    public function Update($where, $data, $dataO=array()){
        if(empty($data)) return false;
        if(is_object($data)) $data = (array)$data;
        if(is_object($where)) $where = (array)$where;
        Core::DB()->where($where);
        $rest = Core::DB()->update($this->tableName, $data);
        if(!$rest) return $this->ReportToLog();
        $this->UpdateContent($where, $dataO);
        return true;
    }
    public function All($temp=null){
        if(is_object($temp)) $temp = (array)$temp;
        if(is_array($temp)){
            if(array_key_exists("where", $temp)){
                $where = $temp['where'];
                $this->ContextWhere($where);
            }
            if(array_key_exists("select", $temp)){
                $select = $temp['select'];
                $this->ContextSelect($select);
            }else{
                Core::DB()->select($this->select[0]);
            }

            if(array_key_exists("like", $temp) || array_key_exists("like_or", $temp)){
                Core::DB()->group_start();
                if(array_key_exists("like", $temp)){
                    $like = $temp['like'];
                    if(!is_null($like) && is_array($like)) {
                        $this->ContextLike($like);
                    }
                }
                if(array_key_exists("like_or", $temp)){
                    $like = $temp['like_or'];
                    if(!is_null($like) && is_array($like)) {
                        $this->ContextLike($like, true);
                    }
                }
                Core::DB()->group_end();
            }
            
            



            if(array_key_exists("order", $temp)){
                $order = $temp['order'];
                if(!is_null($order) && is_array($order)) {
                    foreach($order as $key=> $value){
                        $value = strtolower($value);
                        if($value == "asc" || $value == "desc" ){
                            if(array_key_exists($key, $this->coulomn))
                                Core::DB()->order_by($this->coulomn[$key], $value);
                            else{
                                Core::DB()->order_by($key, $value);
                            }
                        }
                    }
                    
                }
            }
            if(array_key_exists("group_by", $temp)){
                Core::DB()->group_by($temp['group_by']);
            }
            if(array_key_exists("limit", $temp)){
                if(count($temp['limit']) == 1)
                    Core::DB()->limit($temp['limit'][0]);
                if(count($temp['limit']) == 2)
                    Core::DB()->limit($temp['limit'][0],$temp['limit'][1]);
            }
        }
        Core::DB()->from($this->tableName);
        
        $rest = Core::DB()->get()->result();
        if(empty($rest)) return array();
        if(is_array($temp)){
            if(array_key_exists("support", $temp)){
                if($temp['support']){
                    foreach($rest as $key=>$value){
                        $this->SupportContent($rest[$key]);
                    }
                }
            }
        }
        return $rest;
    }
    public function ExtractEnumData($colomn){
        if(!is_string($colomn)) return array();
        Core::DB()->select("COLUMN_TYPE as colomn");
        Core::DB()->from("INFORMATION_SCHEMA.COLUMNS");
        Core::DB()->where(array(
            "TABLE_NAME" => $this->tableName,
            "COLUMN_NAME" => $colomn
        ));
        $data = Core::DB()->get()->result();
        if(empty($data)) return array("");
        $data = $data[0]->colomn;

        $data = substr($data,0, strlen($data)-2);
        $data = substr($data,6, strlen($data)-6);
        $data = str_ireplace("','", "|", $data);
        $data = str_ireplace("''", "'", $data);
        $data = explode("|", $data);
        $rest = array("");
        foreach($data as $value){
            if($value != "" && $value != " ")
                array_push($rest, $value);
        }
        return $rest;
    }
    public function Delete($where = null, $like = null, $support=false){
        if(is_object($where)) $where = (array)$where;
        if(is_object($like)) $like = (array)$like;
        $error = 2;
        if(!is_null($where) && is_array($where)) {
            Core::DB()->where($where);
            $error--;
        }
        if(!is_null($like) && is_array($like)) {
            Core::DB()->like($like);
            $error--;
        }
        if($error == 0) return false;
        $rest = Core::DB()->delete($this->tableName);
        if(empty($rest)) $this->ReportToLog();
        if($support) $this->DeleteContent($rest);
        return $rest;
    }
    public function Order($data){
        if(is_array($data)){
            foreach($data as $key=>$value){
                Core::DB()->order_by($key, $value);
            }
        }
    }
    public function Join($Obj, $configuration, $conf=null){
        $tableName = $Obj->TableName();
        if(!is_string($tableName)) return false;
        if(!is_array($configuration)) return false;
        $tempConf = "";
        foreach($configuration as $value){
            if(count($value) >= 3){
                $str = $value[0]."".$value[1]."".$value[2];
                if($str!=""){
                    $temp = $this->TableName().".".$this->Coulomn($value[0])." ".$value[2]." ".$tableName.".".$Obj->Coulomn($value[1]);
                    if($tempConf != ""){
                        if(array_key_exists(3, $value)){
                            $tempConf .= " ".$value[3]." ".$temp;
                        }else
                            $tempConf .= " AND ".$temp;
                    }else{
                        $tempConf = $temp;
                    }
                }
            }else if(count($value) >= 1){
                if($value[0] != ""){
                    if($tempConf != ""){
                        if(array_key_exists(3, $value)){
                            $tempConf .= " ".$value[3]." ".$value[0];
                        }else
                            $tempConf .= " AND ".$value[0];
                    }else{
                        $tempConf = $value[0];
                    }
                }
            }
        }
        if($tempConf == "") return false;
        //exit($tempConf);
        //return;
    
        if(is_null($conf))
            Core::DB()->join($tableName, $tempConf);
        else
            Core::DB()->join($tableName, $tempConf, $conf);
        return true;
    }
    //Config Interface
    public function TableName(){
        $temp = $this->tableName;
        return $temp;
    }
    public function Coulomn($index){
        if(!is_numeric($index) && !is_string($index)) return false;
        $temp = null;
        if(array_key_exists($index, $this->coulomn))
            $temp = $this->coulomn[$index];
        return $temp;
    }
    //Context Feature
    public function ContextWhere($where = null, $coulomnIndex = 0){
        if(!is_null($where)){
            if(is_string($where)){
                if(!is_null($coulomnIndex) && array_key_exists($coulomnIndex, $this->coulomn)){
                    Core::DB()->where($this->TableName().".".$this->coulomn[$coulomnIndex], $where);
                }else{
                    Core::DB()->where($where);
                }
            }else{
                if(is_object($where)) $where = (array)$where;
                if(is_array($where)) {
                    Core::DB()->where($where);
                }
            }
        }
    }
    public function ContextSelect($select = null){
        if(is_object($select)) $select = (array)$select;
        if(!is_null($select) && is_array($select)) {
            foreach($select as $value){
                if(is_string($value))
                    Core::DB()->select($value);
            }
        }else{
            Core::DB()->select($this->select[0]);
        }
    }
    public function ContextLike($like = null, $is_or=false){
        if(is_object($like)) $like = (array)$like;
        if(!is_null($like) && is_array($like)) {
            $i=0;
            foreach($like as $value){
                if(is_array($value)){
                    if(count($value) == 2){
                        if($is_or){
                            if($i==0)
                                Core::DB()->like($value[0],$value[1]);
                            else
                                Core::DB()->or_like($value[0],$value[1]);
                            $i++;
                        }
                        else
                            Core::DB()->like($value[0],$value[1]);
                    }else if(count($value) == 3){
                        if($is_or){
                            if($i==0)
                                Core::DB()->like($value[0],$value[1],$value[2]);
                            else
                                Core::DB()->or_like($value[0],$value[1],$value[2]);
                            $i++;
                        }
                        else
                            Core::DB()->like($value[0],$value[1],$value[2]);
                    }
                }
            }
        }
    }
    public function ContextOrder($config = array()){
        if(is_array($config) && count($config) > 0)
            foreach($config as $key=>$value){
                $this->db->order_by($key, $value);
            }
    }
    //Logging
    protected function ReportToLog(){
        log_message('error', __CLASS__ . "::" . __FUNCTION__ . " >> " . Core::DB()->last_query());
        log_message('error', __CLASS__ . "::" . __FUNCTION__ . " >> " . Core::DB()->error()['message']);
        return FALSE;
    }
    //abstract
    abstract public function SupportContent(&$content);
    abstract public function DeleteContent($content);
    abstract public function InsertContent($id, $content=array());
    abstract public function UpdateContent($ref, $content=array());
}