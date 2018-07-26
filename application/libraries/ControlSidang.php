<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
class ControlSidang extends LibrarySupport {
	private $functionOpen;
	private $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
		$this->gateControlModel = $tempGateControlModel;
	}
	//optimized
	//available on ea
	public function getAllData($tahunAk=null,$status="1", $dataprosesd = '2'){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Sidang');
		if(!is_null($tahunAk)){
			$tempObjectDB->setTahunAk($tahunAk,true);
			$tempObjectDB->setStatus($status,true);
			$tempObjectDB->setWhere(14);
			if(!is_null($dataprosesd)){
				$tempObjectDB->setDataProsesD($dataprosesd,true);
				$tempObjectDB->setWhere(2);
			}
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	//optimized
	//use - I
	//available on ea
	public function getAllDataWithMahasiswa($tahunAk=null,$status="1", $dataprosesd = '2',$registrasiEx=false){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Sidang');
		$tempRuang = $this->gateControlModel->loadObjectDB('Ruang');
		$tempStatus = $this->gateControlModel->loadObjectDB('Status');
		$tempMahasiswa = $this->gateControlModel->loadObjectDB('Murid');
		$tempMultiple = $this->gateControlModel->loadObjectDB('Multiple');
		if(!is_null($tahunAk)){
			$tempObjectDB->setTahunAk($tahunAk,true);
			$tempObjectDB->setStatus($status,true);
			$tempObjectDB->setWhere(21);
			if(!is_null($dataprosesd)){
				$tempObjectDB->setDataProsesD($dataprosesd,true);
				$tempObjectDB->setWhere(20);
			}
		}
		$tempObjectDB->setWhereMultiple(2);
		$tempMultiple->addTable($tempObjectDB);
		$tempMultiple->addTable($tempMahasiswa);
		$tempMultiple->addTable($tempRuang);
		$tempMultiple->addTable($tempStatus);
		if(!$registrasiEx)
			return $this->gateControlModel->executeObjectDB($tempMultiple)->takeData();
		//prepare for temporary registrasi model
		$tempRegistrasi = $this->gateControlModel->loadObjectDB('Registrasi');
		$tempRegistrasi->setTahunAk($tahunAk,true);
		$tempRegistrasi->setStatus(1,true);
		$tempRegistrasi->setDataProses(2,true);
		$tempRegistrasi->setWhere(11);
		//prepare for temporary dosbing relation model
		$tempDosbing = $this->gateControlModel->loadObjectDB('Dosbing');
		$tempDosbing->setStatus(1,true);
		$tempDosbing->setWhere(5);
		//prepare for temporary dosen model
		$tempGuru = $this->gateControlModel->loadObjectDB('Guru');
		$tempMultiple->addTable($tempRegistrasi);
		$tempMultiple->addTable($tempDosbing);
		$tempMultiple->addTable($tempGuru);
		$tempObjectDB->setWhereMultiple(3);
		//echo $tempMultiple->getTableName()." WHERE ".$tempMultiple->getWhere();
		//exit();
		return $this->gateControlModel->executeObjectDB($tempMultiple)->takeData();
	}
	//optimized
	//available on ea
	public function getAllDataHaveATime($tahunAk=null,$ruang=null,$status="1"){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Sidang');
		if(!is_null($tahunAk)){
			$tempObjectDB->setTahunAk($tahunAk,true);
			$tempObjectDB->setStatus($status,true);
			$tempObjectDB->setWhere(14);
			if(!is_null($ruang)){
				$tempObjectDB->setRuang($ruang,true);
				$tempObjectDB->setWhere(15);
			}
		}else if(!is_null($ruang)){
			$tempObjectDB->setRuang($ruang,true);
			$tempObjectDB->setStatus($status,true);
			$tempObjectDB->setWhere(16);
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	//optimized
	//available on ea
	public function getAllDataHaveATimeWithMahasiswa($tahunAk=null,$ruang=null,$status="1"){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Sidang');
		$tempMahasiswa = $this->gateControlModel->loadObjectDB('Murid');
		$tempMultiple = $this->gateControlModel->loadObjectDB('Multiple');
		if(!is_null($tahunAk)){
			$tempObjectDB->setTahunAk($tahunAk,true);
			$tempObjectDB->setStatus($status,true);
			$tempObjectDB->setWhere(17);
			if(!is_null($ruang)){
				$tempObjectDB->setRuang($ruang,true);
				$tempObjectDB->setWhere(18);
			}
		}else if(!is_null($ruang)){
			$tempObjectDB->setRuang($ruang,true);
			$tempObjectDB->setStatus($status,true);
			$tempObjectDB->setWhere(19);
		}
		$tempObjectDB->setWhereMultiple(1);
		$tempMultiple->addTable($tempObjectDB);
		$tempMultiple->addTable($tempMahasiswa);
		return $this->gateControlModel->executeObjectDB($tempMultiple)->takeData();
	}
	//optimized
	//available on ea
	public function getDataByMahasiswaFull($tahunAk=null,$mahasiswa=null,$status="1"){
		if(is_null($tahunAk)) return false;
		if(is_null($mahasiswa)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Sidang');
		$tempMahasiswa = $this->gateControlModel->loadObjectDB('Murid');
		$tempMultiple = $this->gateControlModel->loadObjectDB('Multiple');
		$tempObjectDB->setTahunAk($tahunAk,true);
		$tempObjectDB->setMahasiswa($mahasiswa,true);
		$tempObjectDB->setWhere(23);
		if(!is_null($status)){
			$tempObjectDB->setStatus($status,true);
			$tempObjectDB->setWhere(22);
		}
		$tempObjectDB->setWhereMultiple(1);
		$tempMultiple->addTable($tempObjectDB);
		$tempMultiple->addTable($tempMahasiswa);
		return $this->gateControlModel->executeObjectDB($tempMultiple)->takeData();
	}
	//optimized
	//available on ea
	public function isTesterOfMahasiswa($kode = null,$tahunAk=null,$dosen=null,$status="1",$mahasiswa = false){
		if(is_null($kode)) return false;
		if(is_null($tahunAk)) return false;
		if(is_null($dosen)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Sidang');
		$tempObjectDB->setTahunAk($tahunAk,true);
		$tempObjectDB->setStatus($status,true);
		switch($kode){
			case 1 :
			$tempObjectDB->setDosenS($dosen,true);
			$tempObjectDB->setWhere(9);
			break;
			case 2 :
			$tempObjectDB->setDosenD($dosen,true);
			$tempObjectDB->setWhere(10);
			break;
			case 3 :
			$tempObjectDB->setDosenT($dosen,true);
			$tempObjectDB->setWhere(11);
			break;
			default:
			return false;
		}
		if(!$mahasiswa)
			return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		$tempMahasiswa = $this->gateControlModel->loadObjectDB('Murid');
		$tempMultiple = $this->gateControlModel->loadObjectDB('Multiple');
		$tempObjectDB->setWhereMultiple(1);
		$tempMultiple->addTable($tempObjectDB);
		$tempMultiple->addTable($tempMahasiswa);
		return $this->gateControlModel->executeObjectDB($tempMultiple)->takeData();
	}
	//optimized
	//available on ea
	public function getDataByMahasiswa($tahunAk=null,$mahasiswa=null,$status="1"){
		if(is_null($tahunAk)) return false;
		if(is_null($mahasiswa)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Sidang');
		$tempObjectDB->setTahunAk($tahunAk,true);
		$tempObjectDB->setMahasiswa($mahasiswa,true);
		$tempObjectDB->setWhere(13);
		if(!is_null($status)){
			$tempObjectDB->setStatus($status,true);
			$tempObjectDB->setWhere(12);
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	//try optimized
	//available on ea
	public function logSidangActive($tahunAk=null, $identified = null){
		if(is_null($tahunAk)) return false;
		if(is_null($identified)) return false;
		$tempObjectDB = $this->getDataByMahasiswa($tahunAk,$identified);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) return false;
		$tempObjectDBD = $this->gateControlModel->loadObjectDB('Sidang');
		$tempObjectDBD->setTahunAk($tempObjectDB->getTahunAk(),true);
		$tempObjectDBD->setStatus($tempObjectDB->getStatus(),true);
		$tempObjectDBD->setMahasiswa($tempObjectDB->getMahasiswa(),true);
		//$tempObjectDBD->setDataStatus($tempObjectDB->getDataStatus(),true);
		//$tempObjectDBD->setWhere(11);
		$tempObjectDBD->setWhere(12);
		$tempObjectDB->setStatus(2);
		$tempObjectDB->setIdentified($this->generateIdentified("Z",1));
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData($tempObjectDBD);
	}
	//optimized
	//available on ea
	public function tryUpdate(ObjectDBModel $tempObjectDB){
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	//opimized
	//available on ea
	public function addNew(ObjectDBModel $tempObjectDB){
		$tempObjectDB->setIdentified($this->generateIdentified("Z",1));
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->addData();
	}
}
