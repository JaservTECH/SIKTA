<?php
if(!defined('BASEPATH')) exit("You dont have permission");
require_once APPPATH.'controllers/CI_Controller_Modified.php';
/*
dependencies:
-ControlDosen
-ControlMahasiswa
-ControlRegistrasi
-ControlSeminar
-ControlSidang
-ControlTime
*/
class Kingbimbingan extends CI_Controller_Modified{
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->dosen))
			exit("#<script>window.location = '".base_url()."Gateinout.jsp'</script>");
		$this->mahasiswa->initial($this->inputJaservFilter);
		$this->loadLib('ControlTime');
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlSeminar');
		$this->loadLib('ControlSidang');
		$this->loadLib('ControlDosen');
		$this->controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$this->controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$this->controlSeminar = new ControlSeminar($this->gateControlModel);
		$this->controlSidang = new ControlSidang($this->gateControlModel);
		$this->controlDosen = new ControlDosen($this->gateControlModel);
		$this->tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
	}
	//fix
	public function getLayoutBimbingan(){
		echo '1';
		$this->load->view("Bodyright/Kingroom/Bimbingan.php");
	}
	//fixx
	//optimized
	public function getListNotifikasiCup(){
		$keyword = "*";
		if($this->input->post("keyword")!==NULL){
			$keyword = $this->input->post("keyword");
			if(!$this->mahasiswa->getCheckName($keyword,1)[0]){
				$keyword = "";
			}
		}else{
			$keyword = "";
		}
		$tempObjectDB = $this->controlMahasiswa->getDataByNama($keyword,1,$this->loginFilter->getIdentifiedActive());
		$tempObjectDBD = $this->controlDosen->getAllData($this->loginFilter->getIdentifiedActive());
		$string = "";
		$kode = 1;
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				if(
					$tempObjectDB->getDosenResponS() != $this->loginFilter->getIdentifiedActive() &&
					$tempObjectDB->getDosenResponD() != $this->loginFilter->getIdentifiedActive() &&
					$tempObjectDB->getDosenResponT() != $this->loginFilter->getIdentifiedActive()
				){
					$this->loadLib('ControlRegistrasi');					
					$this->loadLib("ControlTime");
					$controlTime = new ControlTime($this->gateControlModel);
					$tahunAk = $controlTime->getYearNow();
					
					$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
					$ARRAY_CODE = $controlRegistrasi->getCodeRegLastTA($tempObjectDB,$tahunAk);
					//var_dump( $ARRAY_CODE);
					$dataMahasiswa = "Bukan";
					if($ARRAY_CODE[0]){
						if($ARRAY_CODE[1] == $tahunAk){
							$tempObjectDBD = $controlRegistrasi->getAllDataWithDosbing($tahunAk,$tempObjectDB->getIdentified(),1,null);
							$tempObjectDBD->getNextCursor();
							$tempRegistrasi = $tempObjectDBD->getTableStack(1);
							$tempGuru = $tempObjectDBD->getTableStack(2);
							if($tempRegistrasi->getKategori() != 1){
								if($tempGuru->getIdentified() == $this->loginFilter->getIdentifiedActive())
									$dataMahasiswa = "Ya";
							}else{
								if($tempGuru->getIdentified() == $this->loginFilter->getIdentifiedActive())
									$dataMahasiswa = "Ya";
							}
						}else{
							$tempObjectDBD = $controlRegistrasi->getAllDataWithDosbing($ARRAY_CODE[1],$tempObjectDB->getIdentified(),1,null);
							$tempObjectDBD->getNextCursor();
							$tempRegistrasi = $tempObjectDBD->getTableStack(1);
							$tempGuru = $tempObjectDBD->getTableStack(2);
							if($tempRegistrasi->getKategori() != 1){
								if($tempGuru->getIdentified() == $this->loginFilter->getIdentifiedActive())
									$dataMahasiswa = "Ya";
							}else{
								if($tempGuru->getIdentified() == $this->loginFilter->getIdentifiedActive())
									$dataMahasiswa = "Ya";
							}
						}
					}
					$string .=
					"<tr>
						<td style='text-align : center;'>".$tempObjectDB->getNim()."</td>
						<td style='text-align : center;'>".$tempObjectDB->getNama()."</td>
						<td style='text-align : center;'>".$dataMahasiswa."</td>
						<td style='text-align : center;'>
							<li class='btn-group'>  
								<button style='cursor :pointer;' class='dropdown-toggle tip btn btn-clean btn-info' title='Kelola semua data registrasi' data-toggle='dropdown' data-original-title='Dropdown'><span class='icon-ellipsis-horizontal'> Operasi</span></button>
								<ul class='dropdown-menu pull-right' role='menu'>
									<li data-toggle='dropdown' onclick='cupThisGuys(".'"'.$tempObjectDB->getNim().'"'.",1)'><a style='cursor : pointer;'><span class='icon-info'> Baru</span></a></li>
									<li data-toggle='dropdown' onclick='cupThisGuys(".'"'.$tempObjectDB->getNim().'"'.",2)'><a style='cursor : pointer;'><span class='icon-info'> Melanjutkan</span></a></li>
									<li data-toggle='dropdown' onclick='cupThisGuys(".'"'.$tempObjectDB->getNim().'"'.",3)'><a style='cursor : pointer;'><span class='icon-info'> Distribusi Ulang</span></a></li>
								</ul>                                                                            
							</li>
						</td>
					</tr>
					";
					
				}
			}
		}
		if($string == ""){
			$string .=
			"<tr>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
			</tr>
			";
		}
		echo $kode."".$string;
	}
	private function getStateArgue($kode){
		$kode = intval($kode);
		if($kode == 1) return "Baru";
		if($kode == 2) return "Melanjutkan";
		if($kode == 3) return "Distribusi Ulang";
	}
	//optimized
	public function getListProsesCup(){
		$keyword = "*";
		if($this->input->post("keyword")!==NULL){
			$keyword = $this->input->post("keyword");
			if(!$this->mahasiswa->getCheckName($keyword,1)[0]){
				$keyword = "";
			}
		}else{
			$keyword = "";
		}
		$tempObjectDB = $this->controlMahasiswa->getDataByNama($keyword,1,$this->loginFilter->getIdentifiedActive());
		$string = "";
		$kode = 1;
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				if(
					$tempObjectDB->getDosenResponS() == $this->loginFilter->getIdentifiedActive() ||
					$tempObjectDB->getDosenResponD() == $this->loginFilter->getIdentifiedActive() ||
					$tempObjectDB->getDosenResponT() == $this->loginFilter->getIdentifiedActive()
				){
					$kodeSState = null;
					if($tempObjectDB->getDosenResponS() == $this->loginFilter->getIdentifiedActive())
						$kodeSState = $this->getStateArgue($tempObjectDB->getKodeResponS());
					if($tempObjectDB->getDosenResponD() == $this->loginFilter->getIdentifiedActive())
						$kodeSState = $this->getStateArgue($tempObjectDB->getKodeResponD());
					if($tempObjectDB->getDosenResponT() == $this->loginFilter->getIdentifiedActive())
						$kodeSState = $this->getStateArgue($tempObjectDB->getKodeResponT());
					$this->loadLib('ControlRegistrasi');					
					$this->loadLib("ControlTime");
					$controlTime = new ControlTime($this->gateControlModel);
					$tahunAk = $controlTime->getYearNow();
					
					$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
					$ARRAY_CODE = $controlRegistrasi->getCodeRegLastTA($tempObjectDB,$tahunAk);
					//var_dump( $ARRAY_CODE);
					$dataMahasiswa = "Bukan";
					if($ARRAY_CODE[0]){
						if($ARRAY_CODE[1] == $tahunAk){
							$tempObjectDBD = $controlRegistrasi->getAllDataWithDosbing($tahunAk,$tempObjectDB->getIdentified(),1,null);
							$tempObjectDBD->getNextCursor();
							$tempRegistrasi = $tempObjectDBD->getTableStack(1);
							$tempGuru = $tempObjectDBD->getTableStack(2);
							if($tempRegistrasi->getKategori() != 1){
								if($tempGuru->getIdentified() == $this->loginFilter->getIdentifiedActive())
									$dataMahasiswa = "Ya";
							}else{
								if($tempGuru->getIdentified() == $this->loginFilter->getIdentifiedActive())
									$dataMahasiswa = "Ya";
							}
						}else{
							$tempObjectDBD = $controlRegistrasi->getAllDataWithDosbing($ARRAY_CODE[1],$tempObjectDB->getIdentified(),1,null);
							$tempObjectDBD->getNextCursor();
							$tempRegistrasi = $tempObjectDBD->getTableStack(1);
							$tempGuru = $tempObjectDBD->getTableStack(2);
							if($tempRegistrasi->getKategori() != 1){
								if($tempGuru->getIdentified() == $this->loginFilter->getIdentifiedActive())
									$dataMahasiswa = "Ya";
							}else{
								if($tempGuru->getIdentified() == $this->loginFilter->getIdentifiedActive())
									$dataMahasiswa = "Ya";
							}
						}
					}
					$string .=
					"<tr>
						<td style='text-align : center;'>".$tempObjectDB->getNim()."</td>
						<td>".$tempObjectDB->getNama()."</td>
						<td style='text-align : center;'>".$dataMahasiswa."</td>
						<td style='text-align : center;'>".$kodeSState."</td>
						<td style='text-align : center;'>
							<li class='btn-group'>  
								<button style='cursor :pointer;' class='dropdown-toggle tip btn btn-clean btn-info' title='Kelola semua data registrasi' data-toggle='dropdown' data-original-title='Dropdown'><span class='icon-ellipsis-horizontal'> Operasi</span></button>
								<ul class='dropdown-menu pull-right' role='menu'>
									<li data-toggle='dropdown' onclick='unCupThisGuys(".'"'.$tempObjectDB->getNim().'"'.")'><a style='cursor : pointer;'><span class='icon-info'> batalkan</span></a></li>
								</ul>                                                                            
							</li>
						</td>
					</tr>
					";
					
				}
			}
		}
		if($string == ""){
			$string .=
			"<tr>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
			</tr>
			";
		}
		echo $kode."".$string;
	}
	//fix
	public function getTableInfoPublicRegistrasi(){
		$keyword = "*";
		
		if($this->input->post("keyword")!==NULL){
			$keyword = $this->input->post("keyword");
			if(!$this->mahasiswa->getCheckName($keyword,1)[0]){
				$keyword = "*";
			}
		}
		$kode = 1;
		$string = "";
		
		$bool = false;
		$tempObjectDBs = $this->controlRegistrasi->getAllDataByDosen($this->tahunAk,$this->loginFilter->getIdentifiedActive(),1,true);
		if($tempObjectDBs){
			while($tempObjectDBs->getNextCursor()){
				$tempObjectDBD = $tempObjectDBs->getTableStack(2);
				$tempObjectDB = $tempObjectDBs->getTableStack(1);
				if($keyword == "*" || !is_bool(strpos(strtolower($tempObjectDBD->getNama()),strtolower($keyword)))){
					$error = 0;
					$tempObjectDBT = $this->controlSeminar->getDataByMahasiswa($this->tahunAk,$tempObjectDBD->getIdentified());
					if($tempObjectDBT->getNextCursor()){
						$error += 1;
						$TA1 = "disabled";
					}else{
						$TA1 = "onclick='recomTA1ThisGuys(".'"'.$tempObjectDBD->getNim().'"'.")'";	
					}
					$tempObjectDBT = $this->controlSidang->getDataByMahasiswa($this->tahunAk,$tempObjectDBD->getIdentified());
					if($tempObjectDBT->getNextCursor()){
						$error += 1;
						$TA2 = "disabled";
					}else{
						$TA2 = "onclick='recomTA2ThisGuys(".'"'.$tempObjectDBD->getNim().'"'.")'";	
					}
					if($error > 0){
						$tolak = "disabled";
					}else{
						$tolak = "onclick='bannishThisGuys(".'"'.$tempObjectDBD->getNim().'"'.")'";
					}
					$color = "blue";
					$message = "seeThisGuysFullOfIt(".$tempObjectDBD->getNim().',"sudah memasuki sesi seminar, dalam sistem tidak dapat melakukan penolakan"'.")";
					$tempObjectDBT = $this->controlDetail->getDetail('kategori',$tempObjectDB->getKategori());
					$tempObjectDBT->getNextCursor();
					$string .=
					"<tr>
						<td style='text-align : center;'>".$tempObjectDBD->getNim()."</td>
						<td>".$tempObjectDBD->getNama()."</td>
						<td>".$tempObjectDB->getJudulTA()."</td>
						<td style='text-align : center;'>".$tempObjectDBT->getDetail()."</td>
						<td style='width : 100px;'>
						
							
							<li class='btn-group'>  
								<button style='cursor :pointer;' class='dropdown-toggle tip btn btn-clean btn-info' title='Kelola semua data registrasi' data-toggle='dropdown' data-original-title='Dropdown'><span class='icon-ellipsis-horizontal'> Operasi</span></button>
								<ul class='dropdown-menu pull-right' role='menu'>
									<li data-toggle='dropdown' onclick='".$message."'><a style='cursor : pointer;'><span class='icon-info'> mahasiswa pilihan</span></a></li>
									<li data-toggle='dropdown' ".$tolak."><a style='cursor : pointer;'><span class='icon-remove'> batalkan</span></a></li>
									<li data-toggle='dropdown' ".$TA1."><a style='cursor : pointer;'><span class='icon-group'> seminarkan</span></a></li>
									<li data-toggle='dropdown' ".$TA2."><a style='cursor : pointer;'><span class='icon-group'> sidangkan</span></a></li>
								</ul>                                                                            
							</li>
						</td>
					</tr>
					";
					/* 

							<span><i onclick='".$message."' class='icon-info-sign' style='font-size : 17px; color : ".$color.";'></i></span>
							<span><i title='Tolak menjadi mahasiswa bimbingan saya' ".$tolak." type='button' class='icon-remove'></i></span>
							<span><i title='Rekomendasikan seminar TA 1' ".$TA1." type='button' class='icon-tag'></i></span>
							<span><i title='Rekomendasikan seminar TA 2' ".$TA2." type='button' class='icon-tag'></i></span>
					*/
				}
			}
		}
		if($string == ""){
			$string .=
			"<tr>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
			</tr>
			";
		}
		echo $kode."".$string;
	}
	//optimized - fix
	//menolak sebagai mahasiswa bimbingannya
	public function bannishThisGuysFromMe(){
		$nim = $this->isNullPost("Nim");
		if(!$this->mahasiswa->getCheckNim($nim,1)[0])
			exit("0nim tidak sesuai, anda melakukan debugging");
		$tempObjectDB = $this->controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit("0anda melakukan debugging terhadap system");
		}
		$tempObjectDBD = $this->controlRegistrasi->getAllData($this->tahunAk,$tempObjectDB->getIdentified(),1,null);
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor())
			exit("0anda melakukan debugging terhadap system");
		$tempDosbing = $this->controlRegistrasi->getDosenPembimbing($tempObjectDBD->getIdentified());
		if(!$tempDosbing || !$tempDosbing->getNextCursor())
			exit("0anda melakukan debugging terhadap system");
		if($tempDosbing->getDosen() != $this->loginFilter->getIdentifiedActive()) exit("0anda melakukan debugging terhadap system");
		$tempObjectDBS = $this->controlDosen->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDBS->getNextCursor();
		if($this->controlRegistrasi->setDospemForTA($tempObjectDB->getIdentified(),"0",$this->tahunAk,$tempObjectDBS->getNama())[0]) 
			exit('1berhasil merubah data');
		else exit("0gagal melakukan perubahan data");
	}
	//fix
	public function recomendationTA(){
		$TA = $this->isNullPost('TA');
		$nim = $this->isNullPost('Nim');
		if(!$this->mahasiswa->getCheckNim($nim,1)[0]){
			exit("nim tidak valid");
		}
		$tempObjectDB = $this->controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit("0anda melakukan debugging terhadap system");
		}
		$tempObjectDBD = $this->controlRegistrasi->getAllData($this->tahunAk,$tempObjectDB->getIdentified(),1,null);
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor())
			exit("0anda melakukan debugging terhadap system");
		$tempDosbing = $this->controlRegistrasi->getDosenPembimbing($tempObjectDBD->getIdentified());
		if(!$tempDosbing || !$tempDosbing->getNextCursor())
			exit("0anda melakukan debugging terhadap system");
		if($tempDosbing->getDosen() != $this->loginFilter->getIdentifiedActive()) exit("0anda melakukan debugging terhadap system");
		
		if(intval($tempObjectDBD->getDataProses()) != 2){
			exit("0mahasiswa ini belum disetujui oleh koordinator ta");
		}
		$TA = intval($TA);
		if($TA<1 || $TA>2)
			exit("0Kode TA anda tidak valid");
		$error = 0;
		if($TA == 1){
			$tempObjectDBT = $this->controlSeminar->getDataByMahasiswa($this->tahunAk,$tempObjectDB->getIdentified());
			if($tempObjectDBT && $tempObjectDBT->getNextCursor()){
				exit('0mahasiswa ini sudah mendaftar seminar TA 1');
			}
			$tempObjectDBT->setTahunAk($this->tahunAk);
			$tempObjectDBT->setMahasiswa($tempObjectDB->getIdentified());
			$tempObjectDBT->setStatus(1);
			$tempObjectDBT->setRekomendasi(1);
			$tempObjectDBT->setWaktu("1000-01-01 00:00:00");
			$tempResult = $this->controlSeminar->addNew($tempObjectDBT);
		}else{
			$tempObjectDBT = $this->controlSidang->getDataByMahasiswa($this->tahunAk,$tempObjectDB->getIdentified());
			if($tempObjectDBT && $tempObjectDBT->getNextCursor()){
				exit('0mahasiswa ini sudah mendaftar seminar TA 1');
			}
			$tempObjectDBT->setTahunAk($this->tahunAk);
			$tempObjectDBT->setMahasiswa($tempObjectDB->getIdentified());
			$tempObjectDBT->setStatus(1);
			$tempObjectDBT->setRekomendasi(1);
			$tempObjectDBT->setWaktu("1000-01-01 00:00:00");
			$tempResult = $this->controlSidang->addNew($tempObjectDBT);
		}
		if($tempResult) exit("1Berhasil merujuk dosen rekomendasi mahasiswa ini");
		else exit("0Gagal melakukan perubahan");
	}
	//fix
	public function getInfoMahasiswaFull(){
		$temp = $this->isNullPost('kode');
		$nim = $this->isNullPost('nim');
		$mess = $this->isNullPost('message');
		if($temp != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap system');
		if(!$this->mahasiswa->getCheckNim($nim,1)[0])
			exit('0anda melakukan debugging terhadap system');
		$tempObjectDB = $this->controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit("0anda melakukan debugging terhadap system");
		}
		$tempObjectDBD = $this->controlRegistrasi->getAllData($this->tahunAk,$tempObjectDB->getIdentified(),1,null);
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor())
			exit("0anda melakukan debugging terhadap system");
		$tempDosbing = $this->controlRegistrasi->getDosenPembimbing($tempObjectDBD->getIdentified());
		if(!$tempDosbing || !$tempDosbing->getNextCursor())
			exit("0anda melakukan debugging terhadap system");
		if($tempDosbing->getDosen() != $this->loginFilter->getIdentifiedActive()) exit("0anda melakukan debugging terhadap system");
		$tempObjectDBT = $this->controlDetail->getDetail("kategori",$tempObjectDBD->getKategori());
		$tempObjectDBT->getNextCursor();
		$tempObjectDBE = $this->controlDetail->getDetail("minat",$tempObjectDB->getMinat());
		$tempObjectDBE->getNextCursor();
		$data = array(
				'nim' => $tempObjectDB->getNim(),
				'nama' => $tempObjectDB->getNama(),
				'minat' => $tempObjectDBE->getDetail(),
				'foto' => $tempObjectDB->getNamaFoto(),
				'email' => $tempObjectDB->getEmail(),
				'notelp' => $tempObjectDB->getNoHp(),
				'judulTA' => $tempObjectDBD->getJudulTA(),
				'statusTA' => $tempObjectDBT->getDetail(),
				'urltranskrip' => base_url()."Filesupport/getTranskrip/".$tempObjectDB->getNim().".jsp",
				'urlkrs' => base_url()."Filesupport/getKrs/".$tempObjectDB->getNim().".jsp",
				'message' => $mess
		);
		echo "1";
		$this->load->view('Bodyright/Kingroom/Infomahasiswaview',$data);
	}
	
	public function setThisMyCup(){
		$nim = $this->isNullPost('nim');
		$kode = intval($this->isNullPost('kode'));
		if($kode < 1 || $kode >3) exit("0Anda meakukan debugging");
		if(!$this->mahasiswa->getCheckNim($nim,1)[0]){
			exit('0Anda melakukan debugging');
		}
		if($this->setThisMyCupProcess($nim,$kode)) exit('1Berhasil merubah data');
		else exit('0Gagal merubah data');
	}
	public function setThisUnMyCup(){
		$nim = $this->isNullPost('nim');
		if(!$this->mahasiswa->getCheckNim($nim,1)[0]){
			exit('0Anda melakukan debugging');
		}
		if($this->setThisUnMyCupProcess($nim)) exit('1Berhasil merubah data');
		else exit('0Gagal merubah data');
	}
	protected function setThisMyCupProcess($nim=null,$kode=1){
		if($nim == null) return false;
		$tempObjectDB = $this->controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) return false;
		//if(strlen($tempObjectDB->getDosenRespon()) == 40) return false;	
		$exit = true;
		if($tempObjectDB->getDosenS() == $this->loginFilter->getIdentifiedActive()) $exit = false;
		if($tempObjectDB->getDosenD() == $this->loginFilter->getIdentifiedActive()) $exit = false;
		if($tempObjectDB->getDosenT() == $this->loginFilter->getIdentifiedActive()) $exit = false;
		if($exit) return false;
		$try = true;
		if($tempObjectDB->getDosenResponS() == $tempObjectDB->getDosenS() && strlen($tempObjectDB->getDosenS()) > 7) $try = false;
		if($tempObjectDB->getDosenResponS() == $tempObjectDB->getDosenD() && strlen($tempObjectDB->getDosenD()) > 7) $try = false;
		if($tempObjectDB->getDosenResponS() == $tempObjectDB->getDosenT() && strlen($tempObjectDB->getDosenT()) > 7) $try = false;
		if($try){
			$tempObjectDB->setDosenResponS($this->loginFilter->getIdentifiedActive());
			$tempObjectDB->setKodeResponS($kode);
		}else{
			$try = true;
			if($tempObjectDB->getDosenResponD() == $tempObjectDB->getDosenS() && strlen($tempObjectDB->getDosenS()) > 7) $try = false;
			if($tempObjectDB->getDosenResponD() == $tempObjectDB->getDosenD() && strlen($tempObjectDB->getDosenD()) > 7) $try = false;
			if($tempObjectDB->getDosenResponD() == $tempObjectDB->getDosenT() && strlen($tempObjectDB->getDosenT()) > 7) $try = false;
			if($try){
				$tempObjectDB->setDosenResponD($this->loginFilter->getIdentifiedActive());
				$tempObjectDB->setKodeResponD($kode);
			}else{
				$try = true;
				if($tempObjectDB->getDosenResponT() == $tempObjectDB->getDosenS() && strlen($tempObjectDB->getDosenS()) > 7) $try = false;
				if($tempObjectDB->getDosenResponT() == $tempObjectDB->getDosenD() && strlen($tempObjectDB->getDosenD()) > 7) $try = false;
				if($tempObjectDB->getDosenResponT() == $tempObjectDB->getDosenT() && strlen($tempObjectDB->getDosenT()) > 7) $try = false;
				if($try){
					$tempObjectDB->setDosenResponT($this->loginFilter->getIdentifiedActive());
					$tempObjectDB->setKodeResponT($kode);
				}else{
					return false;
				}
			}
		}
		
		
		
		return $this->controlMahasiswa->tryUpdate($tempObjectDB);
	}
	protected function setThisUnMyCupProcess($nim=null){
		if($nim == null) return false;
		$tempObjectDB = $this->controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) return false;
		if($tempObjectDB->getDosenResponS() == $this->loginFilter->getIdentifiedActive()){
			$tempObjectDB->setDosenResponS("");
			$tempObjectDB->setKodeResponS("");
		}else if($tempObjectDB->getDosenResponD() == $this->loginFilter->getIdentifiedActive()){
			$tempObjectDB->setDosenResponD(" ");
			$tempObjectDB->setKodeResponD("");
		}else if($tempObjectDB->getDosenResponT() == $this->loginFilter->getIdentifiedActive()){
			$tempObjectDB->setDosenResponT(" ");
			$tempObjectDB->setKodeResponT("");
		}else
			return false;
		return $this->controlMahasiswa->tryUpdate($tempObjectDB);
	} 
	
}