<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
require_once APPPATH."libraries/Datejaservfilter.php";
class ControlAdmin extends LibrarySupport {
	private $functionOpen;
	private $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
		$this->gateControlModel = $tempGateControlModel;
	}
	public function getDataByIdentified($identified=null){
		if(is_null($identified)) return false;
		if(!$this->filterIdentified($identified)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Admin');
		$tempObjectDB->setIdentified($identified,true);
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function updateInformasiAdmin($tempData){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Admin');

		$tempObjectDB->setIdentified($tempData['identified'],true);
		$tempObjectDB->setEmail($tempData['email']);
		$tempObjectDB->setNama($tempData['nama']);
		$tempObjectDB->setNoHp($tempData['nohp']);
		$tempObjectDB->setKajur($tempData['kajur']);
		$tempObjectDB->setWakil($tempData['wakil']);
		$tempObjectDB->setTaSDurasi($tempData['tasd']);
		$tempObjectDB->setTaDDurasi($tempData['tadd']);
		$tempObjectDB->setNip($tempData['nip']);
		$tempObjectDB->setAlamat($tempData['alamat']);

		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	public function getDataByStatus($status = 1){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Admin');
		$tempObjectDB->setStatus($status,true);
		$tempObjectDB->setWhere(2);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function getTADurasi($ta = 1,$status=1){
		if(is_null($ta)) return false;
		if(is_null($status)) return false;
		$tempObjectDB = $this->getDataByStatus($status);
		if($tempObjectDB->getNextCursor()){
			switch($ta){
				case 1 :
					return  $tempObjectDB->getTaSDurasi();
				break;
				case 2 :
					return  $tempObjectDB->getTaDDurasi();
				break;
			}
		}
		return false;
	}
	public function isAvailableroomOnThisSemester($mulai,$berakhir,$tahunak=null,$ruang=1,$cat=0,$returnID=false){
		$dateJaservFilter = new Datejaservfilter();
		//$this->loadLib('ControlMahasiswa');
		if($dateJaservFilter->nice_date($mulai,"Y-m-d H:i:s") == "Invalid Date"){
			return $this->setCategoryPrintMessage($cat,false,"Maaf, tanggal yang anda masukan tidak valid");
		}
		if($dateJaservFilter->nice_date($berakhir,"Y-m-d H:i:s") == "Invalid Date"){
			return $this->setCategoryPrintMessage($cat,false,"Maaf, tanggal yang anda masukan tidak valid");
		}
		if($dateJaservFilter->nice_date($mulai,"Y-m-d") != $dateJaservFilter->nice_date($berakhir,"Y-m-d")){
			return $this->setCategoryPrintMessage($cat,false,"Maaf, tanggal yang anda masukan lebih dari 1 hari");
		}
		if(!$dateJaservFilter->setDate($mulai,true)->isBefore($berakhir)){
			return $this->setCategoryPrintMessage($cat,false,"Maaf, waktu berakhir sesudah waktu mulai");
		}
		if($dateJaservFilter->setDate($mulai,true)->isBefore(date("Y-m-d H:i:s"))){
			return $this->setCategoryPrintMessage($cat,false,"Maaf, waktu Dimulai hari Ini");
		}
		
		$koordinator = $this->gateControlModel->loadObjectDB('Koordinator');
		$koordinator->setWhere(2);
		$koordinator = $this->gateControlModel->executeObjectDB($koordinator)->takeData();
		if(!$koordinator->getNextCursor()){
			$koordinator->setStartGanjil("7|7");
			$koordinator->setStartGenap("1|7");
		}
		$yearS = DATE("Y"); 
		$yearD = intval($yearS)-1;
		$month = DATE("m");
		$dateJaservFilter = new DateJaservFilter();
		$tempDataS = explode("|",$koordinator->getStartGanjil());
		$tempDataD = explode("|",$koordinator->getStartGenap());
		
		$tempDateGanjil = DATE("Y")."-".(intval($tempDataS[0])>9?$tempDataS[0]:"0".$tempDataS[0])."-".(intval($tempDataS[1])>9?$tempDataS[1]:"0".$tempDataS[1])." 00:00:00";
		$tempDateGenap = DATE("Y")."-".(intval($tempDataD[0])>9?$tempDataD[0]:"0".$tempDataD[0])."-".(intval($tempDataD[1])>9?$tempDataD[1]:"0".$tempDataD[1])." 00:00:00";
		$tempDateNow = DATE("Y-m-d H:i:s");
		
		$maxDate;
		$minDate;
		
		if($dateJaservFilter->setDate($tempDateGanjil,true)->isBefore($tempDateGenap)){
			if($dateJaservFilter->setDate($tempDateNow, true)->isBefore($tempDateGanjil)){
				$minDate = $yearD."-".(intval($tempDataD[0])>9?$tempDataD[0]:"0".$tempDataD[0])."-".(intval($tempDataD[1])>9?$tempDataD[1]:"0".$tempDataD[1])." 00:00:00";
				$maxDate = $tempDateGanjil;
				
			}else if($dateJaservFilter->setDate($tempDateNow, true)->isAfter($tempDateGenap)){
				$minDate = $tempDateGenap;
				$maxDate = (intval(DATE("Y"))+1)."-".(intval($tempDataS[0])>9?$tempDataS[0]:"0".$tempDataS[0])."-".(intval($tempDataS[1])>9?$tempDataS[1]:"0".$tempDataS[1])." 00:00:00";
				
			}else{
				$minDate = $tempDateGanjil;
				$maxDate = $tempDateGenap;
				
			}
		}else{
			if($dateJaservFilter->setDate($tempDateNow, true)->isBefore($tempDateGenap)){
				$minDate = $yearD."-".(intval($tempDataS[0])>9?$tempDataS[0]:"0".$tempDataS[0])."-".(intval($tempDataS[1])>9?$tempDataS[1]:"0".$tempDataS[1])." 00:00:00";
				$maxDate = $tempDateGenap;
				
			}else if($dateJaservFilter->setDate($tempDateNow, true)->isAfter($tempDateGanjil)){
				$minDate = $tempDateGanjil;
				$maxDate = (intval(date("Y"))+1)."-".(intval($tempDataD[0])>9?$tempDataD[0]:"0".$tempDataD[0])."-".(intval($tempDataD[1])>9?$tempDataD[1]:"0".$tempDataD[1])." 00:00:00";
				
			}else{
				$minDate = $tempDateGenap;
				$maxDate = $tempDateGanjil;
			}
		}
		if(!$dateJaservFilter->setDate($mulai,true)->isAfterAndNow($minDate,true)->isBefore($maxDate))
			return $this->setCategoryPrintMessage($cat,
				FALSE,
				"Maaf, waktu yang diisinkan ".
				$dateJaservFilter->setDate($minDate,true)->getDate("L WMM Y",false).
				" hingga ".
				$dateJaservFilter->setDate($maxDate,true)->getDate("L WMM Y",false)
				);
		if(!$dateJaservFilter->setDate($berakhir,true)->isAfterAndNow($minDate,true)->isBefore($maxDate))
			return $this->setCategoryPrintMessage($cat,
				FALSE,
				"Maaf, waktu yang diisinkan ".
				$dateJaservFilter->setDate($minDate,true)->getDate("L WMM Y",false).
				" hingga ".
				$dateJaservFilter->setDate($maxDate,true)->getDate("L WMM Y",false)
				);
		$id="";
		$error = 0;
		//if($tahunak == null)
			//return $this->setCategoryPrintMessage($cat,false,"tahun akademik tidak boleh kosong");
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Seminar');
		$tempObjectDB->setRuang($ruang,true);
		$tempObjectDB->setStatus(1,true);
		$tempObjectDB->setWaktu($dateJaservFilter->nice_date($mulai,"Y-m-d"),true);
		$tempObjectDB->setWhere(4);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		$states="TD";
		$statesD="2_";
		if($ruang == 1) {
			$states="TS";
			$statesD="1_";
		}
		if($tempObjectDB->getCountData() > 0){
			while($tempObjectDB->getNextCursor()){
				$tempMahasiswa = $this->gateControlModel->loadObjectDB('Murid');
				$tempMahasiswa->setCaseData(1);
				$tempMahasiswa->setIdentified($tempObjectDB->getMahasiswa(),true);
				$tempMahasiswa->setWhere(1);
				$tempMahasiswa = $this->gateControlModel->executeObjectDB($tempMahasiswa)->takeData();
				$tempMahasiswa->getNextCursor();
				$id = $states."".$tempObjectDB->getTahunAk()."_".str_ireplace(" ",".",$tempObjectDB->getWaktu()).$statesD.$tempMahasiswa->getNim();
				$tempStart = $dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->getDate("Y-m-d H:i:s");
				$tempEnd = $dateJaservFilter->setDate($tempObjectDB->getWaktuEnd(),true)->getDate("Y-m-d H:i:s");
				//$tempEnd = $dateJaservFilter->setPlusOrMinMinute($this->getTADurasi(1),true)->getDate("Y-m-d H:i:s");
				if($dateJaservFilter->setDate($mulai,true)->isAfterAndNow($tempStart,true)->isBeforeAndNow($tempEnd)){
					$error+=1;
					break;
				}
				if($dateJaservFilter->setDate($berakhir,true)->isAfterAndNow($tempStart,true)->isBeforeAndNow($tempEnd)){
					$error+=2;
					break;
				}
			}

		}

		if($error > 0){
			if($error == 1)
				if(!$returnID)
					return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, waktu anda tabrakan dengan seminar sebelum anda");
				else{
					return array(FALSE,"Maaf, waktu anda tabrakan dengan seminar sebelum anda",$id);
				}
			else
				if(!$returnID)
					return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, waktu anda tabrakan dengan seminar sesudah anda");
				else
					return array(FALSE,"Maaf, waktu anda tabrakan dengan seminar sesudah anda",$id);
		}
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Sidang');
		$tempObjectDB->setRuang($ruang,true);
		$tempObjectDB->setStatus(1,true);
		$tempObjectDB->setWaktu($dateJaservFilter->nice_date($mulai,"Y-m-d"),true);
		$tempObjectDB->setWhere(6);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		$error = 0;
		if($tempObjectDB->getCountData() > 0){
			while($tempObjectDB->getNextCursor()){
				$tempMahasiswa = $this->gateControlModel->loadObjectDB('Murid');
				$tempMahasiswa->setCaseData(1);
				$tempMahasiswa->setIdentified($tempObjectDB->getMahasiswa(),true);
				$tempMahasiswa->setWhere(1);
				$tempMahasiswa = $this->gateControlModel->executeObjectDB($tempMahasiswa)->takeData();
				$tempMahasiswa->getNextCursor();
				$id = $states."".$tempObjectDB->getTahunAk()."_".str_ireplace(" ",".",$tempObjectDB->getWaktu()).$statesD.$tempMahasiswa->getNim();
				$tempStart = $dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->getDate("Y-m-d H:i:s");
				$tempEnd = $dateJaservFilter->setDate($tempObjectDB->getWaktuEnd(),true)->getDate("Y-m-d H:i:s");
				//$tempEnd = $dateJaservFilter->setPlusOrMinMinute($this->getTADurasi(2),true)->getDate("Y-m-d H:i:s");
				if($dateJaservFilter->setDate($mulai,true)->isAfterAndNow($tempStart,true)->isBeforeAndNow($tempEnd)){
					$error+=1;
					break;
				}
				if($dateJaservFilter->setDate($berakhir,true)->isAfterAndNow($tempStart,true)->isBeforeAndNow($tempEnd)){
					$error+=2;
					break;
				}
			}

		}
		if($error > 0){
			if($error == 1)
				if(!$returnID)
					return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, waktu anda tabrakan dengan sidang sebelum anda");
				else{
					return array(FALSE,"Maaf, waktu anda tabrakan dengan sidang sebelum anda",$id);
				}
			else
				if(!$returnID)
					return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, waktu anda tabrakan dengan sidang sesudah anda");
				else
					return array(FALSE,"Maaf, waktu anda tabrakan dengan sidang sesudah anda",$id);
		}
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Acara');
		$tempObjectDB->setRuang($ruang,true);
		$tempObjectDB->setmulai($dateJaservFilter->nice_date($mulai,"Y-m-d"),true);
		$tempObjectDB->setWhere(4);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();



		if($tempObjectDB->getCountData() > 0){
			while($tempObjectDB->getNextCursor()){
				$id = "AC".$tempObjectDB->getTahunAk()."_".str_ireplace(" ",".",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
				$tempStart = $dateJaservFilter->setDate($tempObjectDB->getMulai(),true)->getDate("Y-m-d H:i:s");
				$tempEnd = $dateJaservFilter->setDate($tempObjectDB->getBerakhir(),true)->getDate("Y-m-d H:i:s");
				if($dateJaservFilter->setDate($mulai,true)->isAfterAndNow($tempStart,true)->isBeforeAndNow($tempEnd)){
					$error+=1;
					break;
				}
				if($dateJaservFilter->setDate($berakhir,true)->isAfterAndNow($tempStart,true)->isBeforeAndNow($tempEnd)){
					$error+=2;
					break;
				}
			}
		}
		if($error > 0){
			if($error == 1)
				if(!$returnID)
					return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, waktu anda tabrakan dengan Acara lain sebelum anda");
				else
					return array(FALSE,"Maaf, waktu anda tabrakan dengan Acara lain sebelum anda",$id);
			else
				if(!$returnID)
					return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, waktu anda tabrakan dengan Acara lain sesudah anda");
				else
					return array(FALSE,"Maaf, waktu anda tabrakan dengan Acara lain sesudah anda",$id);
		}
		$tempMorning = $dateJaservFilter->nice_date($mulai,"Y-m-d")." 06:00:00";
		$tempEvening = $dateJaservFilter->nice_date($mulai,"Y-m-d")." 16:00:00";
		if($dateJaservFilter->setDate($mulai,true)->isBefore($tempMorning)){
			$error+=1;
		}
		if($dateJaservFilter->setDate($mulai,true)->isAfter($tempEvening)){
			$error+=2;
		}
		if($error > 0){
			if($error == 1)
				return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, 06.00 adalah waktu paling pagi");
			else
				return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, 16.00 adalah waktu paling sore utuk TA 1");
		}
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Pinjam');
		$tempObjectDB->setRuang($ruang,true);
		$tempObjectDB->setmulai($dateJaservFilter->nice_date($mulai,"Y-m-d"),true);
		$tempObjectDB->setWhere(4);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();



		if($tempObjectDB->getCountData() > 0){
			while($tempObjectDB->getNextCursor()){
				$id = "AC".$tempObjectDB->getTahunAk()."_".str_ireplace(" ",".",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
				$tempStart = $dateJaservFilter->setDate($tempObjectDB->getMulai(),true)->getDate("Y-m-d H:i:s");
				$tempEnd = $dateJaservFilter->setDate($tempObjectDB->getBerakhir(),true)->getDate("Y-m-d H:i:s");
				if($dateJaservFilter->setDate($mulai,true)->isAfterAndNow($tempStart,true)->isBeforeAndNow($tempEnd)){
					$error+=1;
					break;
				}
				if($dateJaservFilter->setDate($berakhir,true)->isAfterAndNow($tempStart,true)->isBeforeAndNow($tempEnd)){
					$error+=2;
					break;
				}
			}
		}
		if($error > 0){
			if($error == 1)
				if(!$returnID)
					return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, waktu anda tabrakan dengan Acara lain sebelum anda");
				else
					return array(FALSE,"Maaf, waktu anda tabrakan dengan Acara lain sebelum anda",$id);
			else
				if(!$returnID)
					return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, waktu anda tabrakan dengan Acara lain sesudah anda");
				else
					return array(FALSE,"Maaf, waktu anda tabrakan dengan Acara lain sesudah anda",$id);
		}
		$tempMorning = $dateJaservFilter->nice_date($mulai,"Y-m-d")." 06:00:00";
		$tempEvening = $dateJaservFilter->nice_date($mulai,"Y-m-d")." 16:00:00";
		if($dateJaservFilter->setDate($mulai,true)->isBefore($tempMorning)){
			$error+=1;
		}
		if($dateJaservFilter->setDate($mulai,true)->isAfter($tempEvening)){
			$error+=2;
		}
		if($error > 0){
			if($error == 1)
				return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, 06.00 adalah waktu paling pagi");
			else
				return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, 16.00 adalah waktu paling sore utuk TA 1");
		}
		return $this->setCategoryPrintMessage($cat,true,"waktu di terima");
	}
}
