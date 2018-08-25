<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
class ControlJudulTA extends LibrarySupport {
	private $functionOpen;
	private $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
		$this->gateControlModel = $tempGateControlModel;
	}
	public function getObject(){
		return $this->gateControlModel->loadObjectDB('JudulTA');
	}
	//step 1 OK
	//getting all data judul ta by nip
	public function getAllData($nip = null, $flag = null){
		$tempObjectDB = $this->getObject();
		if(!is_null($flag)){
			$flag = intval($flag);
			$tempObjectDB->setFlag($flag, true);
			$tempObjectDB->setWhere(1);
			if(!is_null($nip)){
				$nip = md5($nip);
				$tempObjectDB->setDosen($nip, true);
				$tempObjectDB->setWhere(2);
			}
		}else{
			if(!is_null($nip)){
				$nip = md5($nip);
				$tempObjectDB->setDosen($nip, true);
				$tempObjectDB->setWhere(3);
			}
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function getData($tempData){
		if(!is_array($tempData)) return false;
		if(!isset($tempData['identified'])) return false;
		if(!isset($tempData['identifiedgu'])) return false;
		$tempObjectDB = $this->getObject();
		$tempObjectDB->setIdentified(md5($tempData['identified']),true);
		$tempObjectDB->setDosen($tempData['identifiedgu'],true);
		$tempObjectDB->setWhere(4);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}

	//step 1 OK
	//add new judul ta
	public function addJudul($tempData = null){
		if(!is_array($tempData)) return false;
		$tempObjectDB = $this->getObject();
		$tempObjectDB->setIdentified(md5(md5(date("Y-m-d H:is:").md5("ecode-judulta-jaservtech"))));
		$tempObjectDB->setDosen($tempData['identifiedgu']);
		$tempObjectDB->setJudulTA($tempData['judulta']);
		$tempObjectDB->setDeskripsi($tempData['deskripsi']);
		$tempObjectDB->setFlag(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->addData();
	}
	//step 1 OK
	//update judul ta that adding before
	public function updateJudul($tempData = null){
		if(!is_array($tempData)) return false;
		if(!isset($tempData['identified'])) return false;
		if(!isset($tempData['identifiedgu'])) return false;
		$tempObjectDB = $this->getObject();
		$tempObjectDBF = $this->getObject();
		$tempObjectDBF->setIdentified(md5($tempData['identified']),true);
		$tempObjectDBF->setDosen($tempData['identifiedgu'],true);

		if(isset($tempData['judulta'])) $tempObjectDB->setJudulTA($tempData['judulta']);
		if(isset($tempData['flag'])) $tempObjectDB->setFlag($tempData['flag']);
		if(isset($tempData['deskripsi'])) $tempObjectDB->setDeskripsi($tempData['deskripsi']);
		$tempObjectDBF->setWhere(4);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData($tempObjectDBF);
	}
	//step 1 OK
	//deleting judul ta from database
	public function deleteJudul($tempData=null){
		if(!is_array($tempData)) return false;
		if(!isset($tempData['identified'])) return false;
		if(!isset($tempData['identifiedgu'])) return false;
		$tempObjectDB = $this->getObject();
		$tempObjectDB->setIdentified(md5($tempData['identified']),true);
		$tempObjectDB->setDosen(md5($tempData['identifiedgu']),true);
		$tempObjectDB->setWhere(4);
		$hh = $tempObjectDB->getWhere();
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->deleteData();
	}
}