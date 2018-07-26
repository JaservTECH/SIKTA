<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
require_once APPPATH."libraries/Datejaservfilter.php";
class ControlTime extends LibrarySupport {
	private $functionOpen;
	private $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
		$this->gateControlModel = $tempGateControlModel;
	}
	public function isRegisterTime($time = null){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Kejadian');
		$tempObjectDB->setStatus(1,true);
		$tempObjectDB->setKode(1,true);
		$tempObjectDB->setWhere(5);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		$tempObjectDB->getNextCursor();
		$dateJaservFilter = new Datejaservfilter();
		if($time == null){
			$time = $dateJaservFilter->setDate(date("Y-m-d H:i:s"),true)->setPlusOrMinHour(6,true)->setPlusOrMinMinute(2,true)->getDate("Y-m-d H:i:s");
		}else{
			if($dateJaservFilter->nice_date($time,"Y-m-d") == "Invalid Date"){
				$time = $dateJaservFilter->setDate(date("Y-m-d H:i:s"),true)->setPlusOrMinHour(6,true)->setPlusOrMinMinute(2, true)->getDate("Y-m-d H:i:s");
			}else{
				$time = $dateJaservFilter->nice_date($time,"Y-m-d");
			}
		}
		
		$time = $dateJaservFilter->nice_date($time,"Y-m-d H:i:s");
		//echo " time ".$time." berakhir ".$dateJaservFilter->nice_date($tempObjectDB->getBerakhir()." 23:59:59","Y-m-d H:i:s")." mulai ".$tempObjectDB->getMulai();
		return $dateJaservFilter->setDate($time,true)->isBeforeAndNow($dateJaservFilter->nice_date($tempObjectDB->getBerakhir()." 23:59:59","Y-m-d H:i:s"),true)->isAfterAndNow($dateJaservFilter->nice_date($tempObjectDB->getMulai(),"Y-m-d H:i:s"));
	}
	/*
	added to sequence diagram
	*/
	//Use - I
	public function getYearNow(){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Koordinator');
		$tempObjectDB->setWhere(2);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		if(!$tempObjectDB->getNextCursor()){
			$tempObjectDB->setStartGanjil("7|7");
			$tempObjectDB->setStartGenap("1|7");
		}
		$yearS = DATE("Y"); 
		$yearD = intval($yearS)-1;
		$month = DATE("m");
		$dateJaservFilter = new DateJaservFilter();
		$tempDataS = explode("|",$tempObjectDB->getStartGanjil());
		$tempDataD = explode("|",$tempObjectDB->getStartGenap());
		
		$tempDateGanjil = DATE("Y")."-".(intval($tempDataS[0])>9?$tempDataS[0]:"0".$tempDataS[0])."-".(intval($tempDataS[1])>9?$tempDataS[1]:"0".$tempDataS[1])." 00:00:00";
		$tempDateGenap = DATE("Y")."-".(intval($tempDataD[0])>9?$tempDataD[0]:"0".$tempDataD[0])."-".(intval($tempDataD[1])>9?$tempDataD[1]:"0".$tempDataD[1])." 00:00:00";
		$tempDateNow = DATE("Y-m-d H:i:s");
		if($dateJaservFilter->setDate($tempDateGanjil,true)->isBefore($tempDateGenap)){
			if($dateJaservFilter->setDate($tempDateNow, true)->isBefore($tempDateGanjil)){
				return $yearD."2";
			}else if($dateJaservFilter->setDate($tempDateNow, true)->isAfter($tempDateGenap)){
				return $yearS."2";
			}else{
				return $yearS."1";
			}
		}else{
			if($dateJaservFilter->setDate($tempDateNow, true)->isBefore($tempDateGenap)){
				return $yearD."1";
			}else if($dateJaservFilter->setDate($tempDateNow, true)->isAfter($tempDateGanjil)){
				return $yearS."1";
			}else{
				return $yearD."2";
			}
		}
	}
}