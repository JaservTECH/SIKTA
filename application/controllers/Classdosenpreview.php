<?php
/*
This Class has been rebuild revision build v3.0 Gateinout.php
Author By : Jafar Abdurrahman Albasyir
Since : 17/5/2016
Work : Home on 08:05 PM
dependencie:
-ControlDosen
-ControlMahasiswa
*/
defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once(APPPATH.'controllers/CI_Controller_Modified.php');

class Classdosenpreview extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->dosen->initial($this->inputJaservFilter);
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->mahasiswa))
			exit("#<script>window.location = '".base_url()."Gateinout.jsp'</script>");
		//redirect(base_url()."Gateinout.jsp");
	}
	//fix
	public function getListDosenAktif(){
		echo "1";
		$this->load->view('Bodyright/Classroom/Lihatdosen');
	}
	private function getStateArgue($kode){
		$kode = intval($kode);
		if($kode == 1) return "Baru";
		if($kode == 2) return "Melanjutkan";
		if($kode == 3) return "Distribusi Ulang";
	}
	//fix
	public function getTableListDosen(){
		$kode = $this->isNullPost('kode');
		if($kode != 'JASERVTECH-KODE')
			exit("0anda melakukan debugging terhadap system");
		
		$i=1;
		$strings="";
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlMahasiswa');
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getDataByStatus();
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$dataMahasiswa = $controlMahasiswa->getAllData($this->loginFilter->getIdentifiedActive());
		$dataMahasiswa->getNextCursor();
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				$simbol = "";
				$simbolDetail = "";
				$myReview = false;
				
				if(
					$tempObjectDB->getIdentified() == $dataMahasiswa->getDosenResponS() ||
					$tempObjectDB->getIdentified() == $dataMahasiswa->getDosenResponD() ||
					$tempObjectDB->getIdentified() == $dataMahasiswa->getDosenResponT()
				) {
					$simbol = "(<span style='color : green;' class='icon-ok'></span>)";
					if($tempObjectDB->getIdentified() == $dataMahasiswa->getDosenResponS())
						$simbolDetail = " - ".$this->getStateArgue($dataMahasiswa->getKodeResponS());
					if($tempObjectDB->getIdentified() == $dataMahasiswa->getDosenResponD())
						$simbolDetail = " - ".$this->getStateArgue($dataMahasiswa->getKodeResponD());
					if($tempObjectDB->getIdentified() == $dataMahasiswa->getDosenResponT())
						$simbolDetail = " - ".$this->getStateArgue($dataMahasiswa->getKodeResponT());
				}
				if(
					$tempObjectDB->getIdentified() == $dataMahasiswa->getDosenS() ||
					$tempObjectDB->getIdentified() == $dataMahasiswa->getDosenD() ||
					$tempObjectDB->getIdentified() == $dataMahasiswa->getDosenT()
				) $myReview = true;
				
				$strings .= "<tr><td style='text-align : center;'>".$i."</td><td style='text-align : center;'>";
				$strings .= $tempObjectDB->getNip()."</td><td>" ;
				$strings .= $tempObjectDB->getNama().$simbol.$simbolDetail."</td>" ;
				$strings .= "
							<td style='text-align : center;'>
								<div style='text-align : center;'>
									<div class='col-md-6'>
										<button  class='btn btn-clean btn-info' onclick='seeThisGuys(".'"'.$tempObjectDB->getNip().'"'.");' title='Lihat Profil Dosen : ya'>
											<span class='icon-eye-open pointer'></span> lihat
										</button>
									</div>
									";
				if($myReview)
					$strings .=	"
									<div class='col-md-6'>
										<button  class='btn btn-clean btn-danger ' onclick='beNotMyFavorThisGuys(".'"'.$tempObjectDB->getNip().'"'.",2)' title='Dosen Favorit : ya'>
										<span class='icon-remove pointer'> batalkan</span>
										</button>
									</div>
									";
				else 

					$strings .=	"
									<div class='col-md-6'>
										<button  class='btn btn-clean btn-primary' onclick='beMyFavorThisGuys(".'"'.$tempObjectDB->getNip().'"'.",2)' title='Dosen Favorit : tidak'>
											<span class='icon-ok pointer'> ajukan</span>
										</button>
									</div>
									";
				$strings .= "
								</div>
							</td></tr>
						";
				$i++;
			}
			echo "1".$strings;
		}else{
			exit("0Data Kosong, dosen tidak ada yang aktif");
		}
	}
	//optimized - fix
	//show as detail and list that  i like
	public function getInfoDosenFull(){
		$nip = $this->isNullPost('nip');
		$temp = $this->isNullPost('kode');
		
		if($temp != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap system');
		if(!$this->dosen->getCheckNip($nip,1)[0])
			exit('0anda melakukan debugging terhadap system');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlMahasiswa');
		$controlDosen = new ControlDosen($this->gateControlModel);
		$tempObjectDB = $controlDosen->getDataByNip($nip);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit("0anda melakukan debugging terhadap system");
		}
		$intNo = 1;
		$yourTable = null;
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDBD = $controlMahasiswa->getAllData($this->loginFilter->getIdentifiedActive());
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()){
			exit("0anda melakukan debugging terhadap system");
		}
		if(strlen($tempObjectDBD->getDosenS()) == 40){
			$yourTable['nip_1'][0] = $intNo;
			$tempObjectDBT = $controlDosen->getAllData($tempObjectDBD->getDosenS());
			$tempObjectDBT->getNextCursor();
			$yourTable['nip_1'][1] = $tempObjectDBT->getNip();
			$yourTable['nip_1'][2] = $tempObjectDBT->getNama();
			$intNo++;
		}
		if(strlen($tempObjectDBD->getDosenD()) == 40){
			$yourTable['nip_2'][0] = $intNo;
			$tempObjectDBT = $controlDosen->getAllData($tempObjectDBD->getDosenD());
			$tempObjectDBT->getNextCursor();
			$yourTable['nip_2'][1] = $tempObjectDBT->getNip();
			$yourTable['nip_2'][2] = $tempObjectDBT->getNama();
			$intNo++;
		}
		if(strlen($tempObjectDBD->getDosenT()) == 40){
			$yourTable['nip_3'][0] = $intNo;
			$tempObjectDBT = $controlDosen->getAllData($tempObjectDBD->getDosenT());
			$tempObjectDBT->getNextCursor();
			$yourTable['nip_3'][1] = $tempObjectDBT->getNip();
			$yourTable['nip_3'][2] = $tempObjectDBT->getNama();
			$intNo++;
		}
		$data = array(
				'nip' => $tempObjectDB->getNip(),
				'nama' => $tempObjectDB->getNama(),
				'bidris' => $tempObjectDB->getBidangRiset(),
				'alamat' => $tempObjectDB->getAlamat(),
				'email' => $tempObjectDB->getEmail(),
				'notelp' => $tempObjectDB->getNoHp(),
				'mydosen' => $controlMahasiswa->isMyDosenReview($tempObjectDB->getIdentified(),$this->loginFilter->getIdentifiedActive()),
				'favorite' => $yourTable
		);
		echo "1";
		$this->load->view('Bodyright/Classroom/Infodosenview',$data);
	}
	//optimized
	//like dosen
	public function setLikeThisGuys(){ 
		
		$nip = $this->isNullPost('nip');
		$kode = $this->isNullPost('kode');
		if($kode != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap program');
		$temp = $this->dosen->getCheckNip($nip,1);
		if(!$temp[0])
			exit("0".$temp[1]);
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlMahasiswa');
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getDataByNip($nip);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit("0anda melakukan debugging terhadap system");
		}
		if((new ControlMahasiswa($this->gateControlModel))->setAddNewFavor($tempObjectDB->getIdentified(),$this->loginFilter->getIdentifiedActive())) exit('1Berhasil menambah dosen favorit');
		exit('0Gagal menambahkan dosen favorit');
	}
	//optimmized
	//unlike this guy - valid
	public function setNotLikeThisGuys(){
		$nip = $this->isNullPost('nip');
		$kode = $this->isNullPost('kode');
		if($kode != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap program');
		$temp = $this->dosen->getCheckNip($nip,1);
		if(!$temp[0])
			exit("0".$temp[1]);
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlMahasiswa');
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getDataByNip($nip);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit("0anda melakukan debugging terhadap system");
		}
		if((new ControlMahasiswa($this->gateControlModel))->setRemoveOldFavor($tempObjectDB->getIdentified(),$this->loginFilter->getIdentifiedActive())) exit('1Berhasil menambah dosen favorit');
		exit('0Gagal menambahkan dosen favorit');
	}
	//end session dosen review
	
}