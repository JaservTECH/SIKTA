<?php
/*
dependencies:
-Dosen
-Koordinator
-Mahasiswa
-ControlDetail
-ControlDosen
-ControlMahasiswa
-ControlRegistrasi
-ControlSeminar
-ControlSidang
-ControlTime
*/
if(!defined('BASEPATH'))
	exit("Sorry");
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Controlresultregistrasi extends CI_Controller_Modified {
	private $chaceUs = array();
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->koordinator->initial($this->inputJaservFilter);
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->koordinator))
			exit("#<script>window.location = '".base_url()."Gateinout.jsp'</script>");
	}
	//optimized - fix
	//get layout registrasi for coordinator
	public function getLayoutRegistrasi(){
		$this->loadLib('ControlTime');
		$this->loadLib('ControlDosen');
		echo "1";
		$srt = (new ControlTime($this->gateControlModel))->getYearNow();
		$smt2=true;
		$smt1=false;
		if(intval($srt[4]) == 1){
			$smt1=true;
			$smt2=false;
		}
		$year = intval(substr($srt,0,4));
		$tempObjectDBT = (new ControlDosen($this->gateControlModel))->getAllData(null,1);
		$tempSelectTwo = "
		<select id='filter-row' onchange='filterRow(this)' title='filter row berdasarkan tab distribusi'>
			<option value='all' selected>Pilih Semua</option>
			<option value='0'>Belum Dipilih</option>";
		while($tempObjectDBT->getNextCursor()){
			$tempSelectTwo .= "<option value='".$tempObjectDBT->getNip()."'>".$tempObjectDBT->getNama()."</option>";
		}
		$tempSelectTwo.="</select>";
		$this->load->view("Bodyright/Controlroom/Registrasi.php",array("datafilter"=>$tempSelectTwo,"smts"=>$smt1, "smtd"=>$smt2, "year"=>$year));
	}
	//optimized - fix
	//get data for chart on registrasi page on coordinator
	public function getJsonTableNow(){
		$tahun = $this->input->post('tahun');
		if($this->input->post('tahun') === null){
			$tahun = null;
		}else {
			if(intval($tahun) < 2004 || intval($tahun) > intval(date("Y"))){
				echo "0Tahun ajaran tidak valid";
				return;
			}
			$tahun = intval($tahun)."";
		}
		//semester
		$semester = $this->input->post('semester');
		if($this->input->post('semester') === null){
			$semester = null;
		}else{
			if(intval($semester) < 1 || intval($semester) > 2){
				echo "0Semester tidak di ketahui";
				return;
			}
			$semester = intval($semester)."";
		}
		$this->loadLib('ControlTime');
		if($semester == null || $tahun == null){
			$srt = (new ControlTime($this->gateControlModel))->getYearNow();
		}else{
			$srt = "".$tahun."".$semester."";
		}
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$controlRegistrasi = new Controlregistrasi($this->gateControlModel);
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getAllData(null,1);
		$temp1 = "";
		$temp2 = "";
		$temp3 = "";
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				$temp1 .= '"'.$tempObjectDB->getNama().'",';
				$temp3 .= '"'.$tempObjectDB->getNip().'",';
				$tempObjectDBD = $controlRegistrasi->getAllDataByDosen($srt,$tempObjectDB->getIdentified());
				$negatif = 0;
				if($tempObjectDBD){
					while($tempObjectDBD->getNextCursor()){
						if(intval($tempObjectDBD->getTableStack(1)->getDataProses()) == 3)
							$negatif++;
					}
				}
				$temp2 .= ($tempObjectDBD->getCountData()-$negatif).",";
			}
		}
		if($temp1 != ""){
			$temp1 = substr($temp1, 0,strlen($temp1)-1);
			$temp2 = substr($temp2, 0,strlen($temp2)-1);
			$temp3 = substr($temp3, 0,strlen($temp3)-1);
		}
		$json = '{"data": [[';
		$json .= $temp1;
		$json .= "],[";
		$json .= $temp2;
		$json .= "],[";
		$json .= $temp3;
		$json .= "]]}";
		echo "1".$json;
	}
	//optimized - fix
	//get table list any mahasiswa that has been registered on this system.
	public function getPemerataanListMahasiswa(){

		
		//filter tahun
		$tahun = $this->input->post('tahun');
		if($this->input->post('tahun') === null){ $tahun = null;
		}else {
			if(intval($tahun) < 2004 || intval($tahun) > intval(date("Y"))){ echo "0Tahun ajaran tidak valid"; return; }
			$tahun = intval($tahun)."";
		}
		//semester
		$semester = $this->input->post('semester');
		if($this->input->post('semester') === null){ $semester = null;
		}else{
			if(intval($semester) < 1 || intval($semester) > 2){ echo "0Semester tidak di ketahui"; return; }
			$semester = intval($semester)."";
		}
		$this->loadLib('ControlTime');
		$controlTime = new ControlTime($this->gateControlModel);
		if($semester == null || $tahun == null){ $srt = $controlTime->getYearNow();
		}else{ $srt = "".$tahun."".$semester.""; }
		$changeAvaila = true;
		if(intval($srt) != intval($controlTime->getYearNow()))
			$changeAvaila = false;
		//key
		$key = null;
		if($this->input->post('key') === NULL)
			$key = "*";
		else if($this->isNullPost('key') == "" || $this->isNullPost('key') == " "){
			$key = "*";
		}else{
			if(!$this->inputJaservFilter->nameLevelFiltering($this->isNullPost('key'))[0]){ echo "0Kata kunci harus berupa bagian nama dari seseorang"; return;
			}else $key = $this->isNullPost('key');
		}
		$page = 1;
		if($this->input->post("page")!==NULL){ $page = intval($this->input->post("page")); if($page < 0) $page = 1; }
		$s=true;
		$string = "<h4>Informasi Acara</h4><div class='well'>Data Tidak ditemukan</div>";
		$n = 1;	$z = 1;
		$koko = 0; $trueCon = false;
		$tempTotal = 0;	$tempListNim = "";
		$this->loadLib("ControlRegistrasi");
		$this->loadLib("ControlMahasiswa");
		$this->loadLib("ControlDosen");
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$controlDosen = new ControlDosen($this->gateControlModel);
		//$tempObjectDB = $controlRegistrasi->getAllData($srt,null,1,null);
		$tempObjectDBs = $controlRegistrasi->getAllDataWithMahasiswa($srt);
		//$multiple = $controlRegistrasi->getAllDataWithDosbing($srt,null,1,null, true);
		$tempObjectDBT = $controlDosen->getAllData(null,1);
		$dataTemp = "";
		echo 1;
		$i=0;
		$ihi=0;




		//exit("="."=".$tempObjectDBs->getCountData());




		if($tempObjectDBs){
			$no = 1;
			while($tempObjectDBs->getNextCursor()){
				$tempObjectDB = $tempObjectDBs->getTableStack(0);
				//$tempObjectDBD = $controlMahasiswa->getAllData($tempObjectDB->getMahasiswa());
				$tempObjectDBD = $tempObjectDBs->getTableStack(1);
				if($tempObjectDBD){
					if($key == "*" || !is_bool(strpos(strtolower($tempObjectDBD->getNama()),strtolower($key)))){
						$tempssN=0;	$tempTotal = $i+1;
						$dataTemp .= "
						<tr class='all-row'>
							<td>".$no."</td>
							<td>
								".$tempObjectDBD->getNama()."
							</td>
							<td class='tab-registrasi'>";
						if(intval($tempObjectDB->getKategori())==1) $dataTemp .= "Baru";
						else $dataTemp .= "Melanjutkan";
						$dataTemp .= "
							</td>
							<td>
								<div style=''>
									<div class='col-md-12'>";
						//
						$tempListNim .= $tempObjectDBD->getNim().",";
						$tempSelectTwo="";
						$tempSelectTwoID="";
						
						if($changeAvaila){
							if(intval($tempObjectDB->getDataProses()) == 3) $dataTemp .= "<select class='data-distribusi' disabled>";
							else {
								$dataTemp .= "<select class='data-distribusi allow-change-nip active-show'  idmhs='".$tempObjectDBD->getNim()."'  id='select-satu-".($i+1)."' onfocus='this.oldvalue = this.value' onchange=".'"'."changeDospem('".$tempObjectDBD->getNim()."',this,document.getElementById('select-dua-".($i+1)."'));".'"'." >";
								$tempSelectTwoID = " id='select-dua-".($i+1)."' ";
							}
						}
						else
							$dataTemp .= "<select class='data-distribusi'  idmhs='".$tempObjectDBD->getNim()."'  disabled id='select-satu-".($i+1)."'>";
						$dataTemp .= "<option value='0'>Belum ada</option>";
						$tempSelectTwo .= "<option value='-'></option><option value='0'></option>";
						$tempDosbing = $controlRegistrasi->getDosenPembimbing($tempObjectDB->getIdentified());
						$tempDosbing->getNextCursor();
						$nipreview=array();
						$tempObjectDBT->resetSendRequest();
						while($tempObjectDBT->getNextCursor()){

							$dataTemp .= "<option value='".$tempObjectDBT->getNip()."'";
							if($tempObjectDBT->getIdentified() == $tempDosbing->getDosen())
								$dataTemp .= " selected ";
							$dataTemp .= ">".$tempObjectDBT->getNama()."</option>";
							$tempSelectTwo = $tempSelectTwo."<option value='".$tempObjectDBT->getNip()."'>".$tempObjectDBT->getNama()."</option>";
							if($tempObjectDBT->getIdentified() == $tempObjectDBD->getDosenS()){
								if(
									$tempObjectDBD->getDosenS() == $tempObjectDBD->getDosenResponS() ||
									$tempObjectDBD->getDosenS() == $tempObjectDBD->getDosenResponD() ||
									$tempObjectDBD->getDosenS() == $tempObjectDBD->getDosenResponT()
								){
									$dataStateArgue = "";
									if($tempObjectDBD->getDosenS() == $tempObjectDBD->getDosenResponS())
										$dataStateArgue = " - ".$this->getStateArgue($tempObjectDBD->getKodeResponS());
									if($tempObjectDBD->getDosenS() == $tempObjectDBD->getDosenResponD())
										$dataStateArgue = " - ".$this->getStateArgue($tempObjectDBD->getKodeResponD());
									if($tempObjectDBD->getDosenS() == $tempObjectDBD->getDosenResponT())
										$dataStateArgue = " - ".$this->getStateArgue($tempObjectDBD->getKodeResponT());
									$nipreview[1]="<li style='list-style-type : decimal;'>".$tempObjectDBT->getNama()." <span style='font-size : 16px; color : green;'> (<i class='icon-ok'>)</i></span>".$dataStateArgue."</li>";
								}else
									$nipreview[1]="<li style='list-style-type : decimal;'>".$tempObjectDBT->getNama()."</li>";
								$tempssN++;
							}else if($tempObjectDBT->getIdentified() == $tempObjectDBD->getDosenD()){
								if(
									$tempObjectDBD->getDosenD() == $tempObjectDBD->getDosenResponS() ||
									$tempObjectDBD->getDosenD() == $tempObjectDBD->getDosenResponD() ||
									$tempObjectDBD->getDosenD() == $tempObjectDBD->getDosenResponT()
								){
									$dataStateArgue = "";
									if($tempObjectDBD->getDosenD() == $tempObjectDBD->getDosenResponS())
										$dataStateArgue = " - ".$this->getStateArgue($tempObjectDBD->getKodeResponS());
									if($tempObjectDBD->getDosenD() == $tempObjectDBD->getDosenResponD())
										$dataStateArgue = " - ".$this->getStateArgue($tempObjectDBD->getKodeResponD());
									if($tempObjectDBD->getDosenD() == $tempObjectDBD->getDosenResponT())
										$dataStateArgue = " - ".$this->getStateArgue($tempObjectDBD->getKodeResponT());
									$nipreview[2]="<li style='list-style-type : decimal;'>".$tempObjectDBT->getNama()." <span style='font-size : 16px; color : green;'> (<i class='icon-ok'>)</i></span>".$dataStateArgue."</li>";
								}else
									$nipreview[2]="<li style='list-style-type : decimal;'>".$tempObjectDBT->getNama()."</li>";
								$tempssN++;
							}else if($tempObjectDBT->getIdentified() == $tempObjectDBD->getDosenT()){
								if(
									$tempObjectDBD->getDosenT() == $tempObjectDBD->getDosenResponS() ||
									$tempObjectDBD->getDosenT() == $tempObjectDBD->getDosenResponD() ||
									$tempObjectDBD->getDosenT() == $tempObjectDBD->getDosenResponT()
								){
									$dataStateArgue = "";
									if($tempObjectDBD->getDosenT() == $tempObjectDBD->getDosenResponS())
										$dataStateArgue = " - ".$this->getStateArgue($tempObjectDBD->getKodeResponS());
									if($tempObjectDBD->getDosenT() == $tempObjectDBD->getDosenResponD())
										$dataStateArgue = " - ".$this->getStateArgue($tempObjectDBD->getKodeResponD());
									if($tempObjectDBD->getDosenT() == $tempObjectDBD->getDosenResponT())
										$dataStateArgue = " - ".$this->getStateArgue($tempObjectDBD->getKodeResponT());
									$nipreview[3]="<li style='list-style-type : decimal;'>".$tempObjectDBT->getNama()." <span style='font-size : 16px; color : green;'> (<i class='icon-ok'>)</i></span>".$dataStateArgue."</li>";
								}else
									$nipreview[3]="<li style='list-style-type : decimal;'>".$tempObjectDBT->getNama()."</li>";
								$tempssN++;
							}

						}

						$dataTemp .= "
										</select>
									</div>
								</div>
							</td>
							<td>
								<div style=''>
									<select".$tempSelectTwoID." disabled>".$tempSelectTwo."</select>
								</div>
							</td>";
						$scope = 1;
						$same = 1;
						$tempos = "";
						$tempObjectDBE = $controlRegistrasi->getListAllDosenBimbinganLog($tempObjectDBD->getIdentified());
						if($tempObjectDBE){
							while($tempObjectDBE->getNextCursor()){
								$tempDosen = $tempObjectDBE->getTableStack(0)->getDosen();
								if($scope > 3)
									break;
								$allow = true;
								if($same == 1 ){
									$same = 2;
									if($tempDosen == $tempDosbing->getDosen()){
										$allow = false;
									}
								}
								if($allow){
									$tempObjectDBL = $controlDosen->getAllData($tempDosen);
									$tempObjectDBL->getNextCursor();
									//$tempos .= $scope .".".$tempObjectDBL->getNama()."<br>";
									$tempos .= "<li style='list-style-type : decimal;'>".$tempObjectDBL->getNama()."</li>";
									$scope ++;
								}
							}
						}
						$tempss="<ul style='padding : 0;'>";
						if($tempos == "")
							$tempss.="<li style='list-style-type : decimal;'>-</li>";
						else{
							//$tempss.="<li style='list-style-type : none;'>".substr($tempos, 0,strlen($tempos)-4)."</li>";
							$tempss.=$tempos;
						}
						$tempss.="</ul>";
						$dataTemp .= "
							<td>
								<div style=''>".$tempss."
								</div>
							</td>
							<td>
								<div style=''>";//width : 130px;

						if(count($nipreview) == 0)
							$dataTemp .= "<ul style='padding : 0;'><li  style='list-style-type : decimal;'>-</li></ul>";
						else{
							$resultNipreview = "";
							foreach($nipreview as $gKLO){
								$resultNipreview .= $gKLO;
							}
							/* for($inip=1;$inip<=count($nipreview);$inip++){
								if($nipreview[$inip])
									$resultNipreview .= $nipreview[$inip];
							} */
							$dataTemp .= "<ul style='padding : 0;'>".$resultNipreview."</ul>";
						}
						$dataTemp .= "</div>
							</td>
							<td class='tab-status'>
								<div style=''>";
						
						if($changeAvaila)
							$dataTemp .= "<select style='min-width : 70px;' id='".$tempObjectDBD->getNim()."-status' onchange=".'"'."changeDataProses('".$tempObjectDBD->getNim()."',this.value);".'"'." >";
						else
							$dataTemp .= "<select style='min-width : 70px;' id='".$tempObjectDBD->getNim()."-status' disabled>";

						if(intval($tempObjectDB->getDataProses()) == 1) $dataTemp .= '<option selected value="1">Menunggu</option>';
						else $dataTemp .= '<option value="1">Menunggu</option>';
						if(intval($tempObjectDB->getDataProses()) == 2) $dataTemp .= '<option selected value="2">Disetujui</option>';
						else $dataTemp .= '<option value="2">Disetujui</option>';
						if(intval($tempObjectDB->getDataProses()) == 3) $dataTemp .= '<option selected value="3">Ditolak</option>';
						else $dataTemp .= '<option value="3">Ditolak</option>';
						$dataTemp .= "
									</select>
								</div>
							</td>";
						$dataTemp .= "
							<td class='tab-operasi'>
								<li class='btn-group'>                           
									<button style=' cursor :pointer;' class='dropdown-toggle tip btn btn-clean btn-info' title='' data-toggle='dropdown' data-original-title='Dropdown'><span class='icon-ellipsis-horizontal'> Operasi</span></button>
									<ul class='pull-right dropdown-menu' role='menu'>
										<li data-toggle='dropdown' idnip='select-satu-".($i+1)."' onclick='".'detailThisGuys('.'"'.$tempObjectDBD->getNim().'"'.")"."'><a style='cursor : pointer;'><span class='icon-info'> mahasiswa pilihan</span></a></li>
										<li data-toggle='dropdown' onclick='"."detailThisDospem(".'"'.$tempObjectDBD->getNim().'"'.",".($i+1).")"."'><a style='cursor : pointer;'><span class='icon-info'> dosen pilihan</span></a></li>
										<li data-toggle='dropdown' onclick='"."detailCompareThisGuysWithDospem(".'"'.$tempObjectDBD->getNim().'"'.",".($i+1).")"."'><a style='cursor : pointer;'><span class='icon-info'> kedua pilihan</span></a></li>
										<li data-pesan='".$tempDosbing->getPesan()."' data-toggle='dropdown' onclick='showPesan(this)'><a style='cursor : pointer;'><span class='icon-info'> Pesan perubahan</span></a></li>
									</ul>                                                                            
								</li>
								
							</td>
						</tr>";
						
						
						$koko++;
						$n++;
						$i++;
						
						$no++;
					}
				}
			$ihi++;
			}
		}
		if($dataTemp == ""){
			echo "<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>";
		}
		else echo $dataTemp;
		echo "|";
		
		echo "|".$tempTotal."|";
		if($tempTotal > 0){
			$tempListNim = substr($tempListNim,0,strlen($tempListNim)-1);
			echo $tempListNim;
		}
	}
	private function getStateArgue($kode){
		$kode = intval($kode);
		if($kode == 1) return "Baru";
		if($kode == 2) return "Melanjutkan";
		if($kode == 3) return "Distribusi Ulang";
	}
	//fix
	//fungsi yang menghandle permintaan penyimpanan perubahan dosen pembimbing
	public function setDospem(){
		$this->loadLib('ControlTime');
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		//$tahunAk = "20171";
		//beta
		//$_POST['nim'] = "24010314120028,24010314120010,24010314120017,24010314120023,24010314120056,24010314120013,24010314120004,24010313130078,24010313140083,24010312140087,24010312140096,24010313140114,24010313130079,24010313120038";
		//$_POST['nip'] = "197308291998022001,197308291998022001,197308291998022001,197308291998022001,197308291998022001,197308291998022001,197308291998022001,197308291998022001,197308291998022001,197308291998022001,197308291998022001,197308291998022001,197308291998022001,197308291998022001";
		//$_POST['nim'] = "24010312130081,24010314140112,24010314120032,24010313130087,24010311120009,24010312140036,24010313140122,24010312140045,24010311140104,24010312140125,24010313120010,24010311140079,24010314120044,24010314120061,24010314120049,24010314130075,24010314120065,24010314140123,24010314140129,24010312130071,24010313140096,24010313120009,24010311130057,24010313120045,24010313140106,24010313130112,24010313120036,24010314130078,24010314120009,24010314130101,24010314130098,24010314130083,24010313130084,24010313140099,24010312130042,24010313130071,24010313120039,24010312120017,24010311130026,24010312130101,24010312130107,24010314140072,24010314130079,24010314130086,24010313120044,24010314120030,24010314130109,24010313130108,24010314120037,24010313120055,24010313140093,24010312140092,24010312130110,24010313130069,24010314120007,24010314130106,24010312140132,24010312140063,24010312120009,24010312140102,24010313120046,24010311120006,24010312110078,24010311140095,24010311140080,24010311130074,24010312140082,24010314140120,24010314120018,24010313120020,24010313140109,24010313130068,24010313120049,24010313120059,24010313120040,24010312130077,24010312130100,24010313140116,24010313120006,24010311140099,24010314120015,24010314130097,24010314140076,24010312140040,24010311130059,24010313120043,24010313120001,24010313120026,24010313130081,24010313120007,24010313120037,24010312130122,24010313140113,24010313130097,24010314130080,24010314130114,24010314120043,24010314140117,24010313130121,24010312120006,24010312140043,24010313120053,24010312130113,24010313120042,24010311130068,24010313120050,24010311130070,24010312140086,24010314130081,24010314140077,24010314130088,24010314120058,24010312130111,24010311130053,24010311120011,24010312140074,24010313130064,24010313140077,24010313140105,24010312140064,24010313120051,24010314130095,24010314120036,24010314120045,24010314170001,24010314140096,24010313130125,24010311130044,24010311130051,24010313130067,24010312140073,24010311130058,24010312140130,24010313130120,24010313130072,24010313120057,24010313120021,24010312140109,24010313120015,24010312140031,24010313120004,24010313130104,24010313120019,24010313140062,24010313120032,24010313140070,24010311140096,24010311120020,24010313120054,24010313140124,24010313120008,24010313130060,24010313120029,24010313130101,24010313140095,24010312140030,24010312140029,24010312120027,24010311140101,24010313120005,24010312140117,24010313120033,24010314130100,24010314140089,24010314120054,24010313130117,24010313120028,24010313120027,24010313140082,24010313130098,24010313120052,24010311130076,24010311140098,24010312140079,24010311140107,24010314120014,24010314130107,24010313120034,24010313130085,24010313130119,24010313120058,24010313140065,24010313120018,24010313130115,24010313130103,24010312130090,24010312140121,24010312130044,24010312130049,24010313120047,24010314140094,24010314120012,24010314120063,24010314140125,24010314120060,24010313120024,24010312130084,24010312130060,24010313120013,24010313120031,24010312130123,24010312140099,24010313120012";
		//$_POST['nip'] = "197404011999031002,197404011999031002,197404011999031002,197404011999031002,197404011999031002,197404011999031002,197404011999031002,197404011999031002,197404011999031002,197404011999031002,197404011999031002,197404011999031002,197404011999031002,197404011999031002,198203092006041002,198203092006041002,198203092006041002,198203092006041002,198203092006041002,198203092006041002,198203092006041002,198203092006041002,198203092006041002,198203092006041002,198203092006041002,198203092006041002,198203092006041002,198104202005012001,198104202005012001,198104202005012001,198104202005012001,198104202005012001,198104202005012001,198104202005012001,198104202005012001,198104202005012001,198104202005012001,198104202005012001,198104202005012001,198104202005012001,198104202005012001,195412191980031003,195412191980031003,195412191980031003,195412191980031003,195412191980031003,195412191980031003,195412191980031003,195412191980031003,195412191980031003,195412191980031003,195412191980031003,195412191980031003,195412191980031003,196511071992031003,196511071992031003,196511071992031003,196511071992031003,196511071992031003,196511071992031003,196511071992031003,196511071992031003,196511071992031003,196511071992031003,196511071992031003,196511071992031003,196511071992031003,195504071983031003,195504071983031003,195504071983031003,195504071983031003,195504071983031003,195504071983031003,195504071983031003,195504071983031003,195504071983031003,195504071983031003,195504071983031003,195504071983031003,195504071983031003,197805162003121001,197805162003121001,197805162003121001,197805162003121001,197805162003121001,197805162003121001,197805162003121001,197805162003121001,197805162003121001,197805162003121001,197805162003121001,197805162003121001,197805162003121001,197805162003121001,197902122008121002,197902122008121002,197902122008121002,197902122008121002,197902122008121002,197902122008121002,197902122008121002,197902122008121002,197902122008121002,197902122008121002,197902122008121002,197902122008121002,197902122008121002,197902122008121002,197907202003121002,197907202003121002,197907202003121002,197907202003121002,197907202003121002,197907202003121002,197907202003121002,197907202003121002,197907202003121002,197907202003121002,197907202003121002,197907202003121002,197907202003121002,198104212008121002,198104212008121002,198104212008121002,198104212008121002,198104212008121002,198104212008121002,198104212008121002,198104212008121002,198104212008121002,198104212008121002,198104212008121002,198104212008121002,198104212008121002,197007051997021001,197007051997021001,197007051997021001,197007051997021001,197007051997021001,197007051997021001,197007051997021001,197007051997021001,197007051997021001,197007051997021001,197007051997021001,197007051997021001,197007051997021001,198010212005011003,198010212005011003,198010212005011003,198010212005011003,198010212005011003,198010212005011003,198010212005011003,198010212005011003,198010212005011003,198010212005011003,198010212005011003,198010212005011003,198010212005011003,198010212005011003,198302032006041002,198302032006041002,198302032006041002,198302032006041002,198302032006041002,198302032006041002,198302032006041002,198302032006041002,198302032006041002,198302032006041002,198302032006041002,198302032006041002,198302032006041002,198302032006041002,197805022005012002,197805022005012002,197805022005012002,197805022005012002,197805022005012002,197805022005012002,197805022005012002,197805022005012002,197805022005012002,197805022005012002,197805022005012002,197805022005012002,197805022005012002,197805022005012002,197905242009121003,197905242009121003,197905242009121003,197905242009121003,197905242009121003,197905242009121003,197905242009121003,197905242009121003,197905242009121003,197905242009121003,197905242009121003,197905242009121003,197905242009121003,197905242009121003";
		//$_POST['kode'] = "JASERVCONTROL";
		$nimEx = explode(",",$this->isNullPost('nim'));
		$nipEx = explode(",",$this->isNullPost('nip'));
		if(count($nimEx) != count($nipEx)){
			echo "0Data nim dan nip tidak valid";
			return;
		}
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('Aktor/Mahasiswa');
		$this->loadLib('Aktor/Dosen');
		$mahasiswa = new Mahasiswa($this->inputJaservFilter);
		$dosen = new Dosen($this->inputJaservFilter);
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$kode = $this->isNullPost('kode');
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		$succes = 0;
		for($i=0;$i<count($nimEx);$i++){
			$nim = $nimEx[$i];
			$nip = $nipEx[$i];
			if(!$mahasiswa->getCheckNim($nim,1)[0]){
				if(count($nimEx) > 1) exit("0terdapat nim yang tidak sesuai");
				else exit("0nim tidak sesuai");
			}
			$tempBool=true;
			$nipNext=true;
			if($nip != "0"){
				$tempBool=false;
				if(!$dosen->getCheckNip($nip,1)[0]){
					if(count($nimEx) > 1) exit("0terdapat nip yang tidak sesuai");
					else exit("0nim tidak sesuai");
				}
				$tempObjectDBD = $controlDosen->getDataByNip($nip);
				if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor())
					$nipNext=false;
				else{
					$nip=$tempObjectDBD->getIdentified();
				}
			}
			$tempObjectDB = $controlMahasiswa->getDataByNim($nim);
			if($tempObjectDB && $tempObjectDB->getNextCursor()){
				if($nipNext){
					if($controlRegistrasi->setDospemForTA($tempObjectDB->getIdentified(),$nip,$tahunAk,$tempBool)[0]) $succes++;
				}
			}
		}
		if(count($nimEx) == $succes){
			echo "1data berhasil dirubah";
		}else{
			echo "0terdapat data yang gagal dirubah";
		}
		return;
	}
	//
	public function getInfoMahasiswaFull(){
		$kode = $this->isNullPost('kode');
		$nim = $this->isNullPost('nim');
		//filter tahun
		$tahun = $this->input->post('tahun');
		if($this->input->post('tahun') === null){ $tahun = null;
		}else {
			if(intval($tahun) < 2004 || intval($tahun) > intval(date("Y"))){ echo "0Tahun ajaran tidak valid"; return; }
			$tahun = intval($tahun)."";
		}
		//semester
		$semester = $this->input->post('semester');
		if($this->input->post('semester') === null){ $semester = null;
		}else{
			if(intval($semester) < 1 || intval($semester) > 2){ echo "0Semester tidak di ketahui"; return; }
			$semester = intval($semester)."";
		}
		
		$this->loadLib('ControlTime');
		$controlTime = new ControlTime($this->gateControlModel);
		if($semester == null || $tahun == null){ $tahunAk = $controlTime->getYearNow();
		}else{ $tahunAk = "".$tahun."".$semester.""; }
		
		$this->loadLib("Aktor/Mahasiswa");
		$mahasiswa = new Mahasiswa($this->inputJaservFilter);
		if($kode != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap system');
		if(!$mahasiswa->getCheckNim($nim,1)[0])
			exit('0anda melakukan debugging terhadap system');
		$this->loadLib('ControlMahasiswa');
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDB = $controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor())
			exit("0nim ini tidak terdaftar");
		$this->loadLib('ControlDetail');
		$this->loadLib('ControlRegistrasi');
		$controlDetail = new ControlDetail($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$tempObjectDBD = $controlDetail->getDetail('minat',$tempObjectDB->getMinat());
		$tempObjectDBD->getNextCursor();
		$tempObjectDBT = $controlRegistrasi->getAllData($tahunAk,$tempObjectDB->getIdentified(),1,null);
		if(!$tempObjectDBT || !$tempObjectDBT->getNextCursor())
			exit("0anda melakukan debugging terhadap system");
		$tempObjectDBE = $controlDetail->getDetail('kategori',$tempObjectDBT->getKategori());
		$tempObjectDBE->getNextCursor();
		$data = array(
			'nim' => $tempObjectDB->getNim(),
			'nama' => $tempObjectDB->getNama(),
			'minat' => $tempObjectDBD->getDetail(),
			'email' => $tempObjectDB->getEmail(),
			'notelp' => $tempObjectDB->getNohp(),
			'judulTA' => $tempObjectDBT->getJudulTa(),
			'statusTA' => $tempObjectDBE->getDetail()
		);
		exit("1".json_encode($data));
		//old
		$data = array(
				'nim' => $tempObjectDB->getNim(),
				'nama' => $tempObjectDB->getNama(),
				'minat' => $tempObjectDBD->getDetail(),
				'foto' => $tempObjectDB->getNamaFoto(),
				'email' => $tempObjectDB->getEmail(),
				'notelp' => $tempObjectDB->getNohp(),
				'judulTA' => $tempObjectDBT->getJudulTa(),
				'statusTA' => $tempObjectDBE->getDetail(),
				'urltranskrip' => base_url()."Filesupport/getTranskrip/".$tempObjectDB->getNim().".jsp",
				'urlkrs' => base_url()."Filesupport/getKRS/".$tempObjectDB->getNim()."/".$tahunAk.".jsp"
		);
		echo "1";
		$this->load->view('Bodyright/Controlroom/Infomahasiswaview',$data);
	}
	public function getInfoDosenFull(){
		$kode = $this->isNullPost('kode');
		$nip = $this->isNullPost('nip');
		$nim = $this->isNullPost('nim');
		$this->load->library('Aktor/Dosen');
		$this->load->library('Aktor/Mahasiswa');
		$this->mahasiswa->initial($this->inputJaservFilter);
		$this->dosen->initial($this->inputJaservFilter);
		if(!$this->mahasiswa->getCheckNim($nim,1)[0])
			exit('0anda melakukan debugging terhadap system');
		if($kode != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap system');
		if(!$this->dosen->getCheckNip($nip,1)[0])
			exit('0anda melakukan debugging terhadap system');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlMahasiswa');
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDB = $controlDosen->getDataByNip($nip);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit("0nip tidak terdaftar");
		}
		$tempObjectDBD = $controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()){
			exit("0nim tidak terdaftar");
		}

		$intNo = 1;
		$yourTable = null;
		$dosenFavorit = "Bukan";
		if(strlen($tempObjectDBD->getDosenS()) == 40){
			if($tempObjectDBD->getDosenS() == $tempObjectDB->getIdentified()){
				$dosenFavorit = "Ya";
			}
		}
		if(strlen($tempObjectDBD->getDosenD()) == 40){
			if($tempObjectDBD->getDosenD() == $tempObjectDB->getIdentified()){
				$dosenFavorit = "Ya";
			}
		}
		if(strlen($tempObjectDBD->getDosenT()) == 40){
			if($tempObjectDBD->getDosenT() == $tempObjectDB->getIdentified()){
				$dosenFavorit = "Ya";
			}
		}
		$data = array(
				'nip' => $tempObjectDB->getNip(),
				'nama' => $tempObjectDB->getNama(),
				'bidris' => $tempObjectDB->getBidangRiset(),
				'alamat' => $tempObjectDB->getAlamat(),
				'email' => $tempObjectDB->getEmail(),
				'notelp' => $tempObjectDB->getNoHp(),
				'dosenFavor'=> $dosenFavorit
		);
		echo "1";
		$this->load->view('Bodyright/Controlroom/Infodosenview',$data);
	}
	public function getInfoDosenAndMahasiswaComparasiFull(){
		$kode = $this->isNullPost('kode');
		$nip = $this->isNullPost('nip');
		$nim = $this->isNullPost('nim');
		//filter tahun
		$tahun = $this->input->post('tahun');
		if($this->input->post('tahun') === null){ $tahun = null;
		}else {
			if(intval($tahun) < 2004 || intval($tahun) > intval(date("Y"))){ echo "0Tahun ajaran tidak valid"; return; }
			$tahun = intval($tahun)."";
		}
		//semester
		$semester = $this->input->post('semester');
		if($this->input->post('semester') === null){ $semester = null;
		}else{
			if(intval($semester) < 1 || intval($semester) > 2){ echo "0Semester tidak di ketahui"; return; }
			$semester = intval($semester)."";
		}
		
		$this->loadLib('ControlTime');
		$controlTime = new ControlTime($this->gateControlModel);
		if($semester == null || $tahun == null){ $tahunAk = $controlTime->getYearNow();
		}else{ $tahunAk = "".$tahun."".$semester.""; }
		
		if($kode != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap system');$this->load->library('Aktor/Dosen');
		$this->load->library('Aktor/Mahasiswa');
		$this->load->library('Aktor/Dosen');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlDetail');
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlDetail = new ControlDetail($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$this->mahasiswa->initial($this->inputJaservFilter);
		$this->dosen->initial($this->inputJaservFilter);
		if(!$this->mahasiswa->getCheckNim($nim,1)[0])
			exit('0anda melakukan debugging terhadap system');
		$tempObjectDB = $controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit("0nim tidak terdaftar");
		}
		$tempObjectDBD = $controlDosen->getDataByNip($nip);
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()){
			exit("0nim tidak terdaftar");
		}
		$tempObjectDBT = $controlDetail->getDetail('minat',$tempObjectDB->getMinat());
		$tempObjectDBT->getNextCursor();
		$tempObjectDBE = $controlRegistrasi->getAllData($tahunAk,$tempObjectDB->getIdentified(),1,null);
		if(!$tempObjectDBE || !$tempObjectDBE->getNextCursor()){
			exit("0anda melakukan debugging terhadap system");
		}
		$tempObjectDBL = $controlDetail->getDetail('kategori',$tempObjectDBE->getKategori());
		$tempObjectDBL->getNextCursor();
		$data = array(
				'nim' => $tempObjectDB->getNim(),
				'nama' => $tempObjectDB->getNama(),
				'minat' => $tempObjectDBT->getDetail(),
				'foto' => $tempObjectDB->getNamaFoto(),
				'email' => $tempObjectDB->getEmail(),
				'notelp' => $tempObjectDB->getNoHp(),
				'judulTA' => $tempObjectDBE->getJudulTA(),
				'statusTA' => $tempObjectDBL->getDetail()
		);
		if(!$this->dosen->getCheckNip($nip,1)[0])
			exit('0anda melakukan debugging terhadap system');
		$intNo = 1;
		$yourTable = null;
		$dosenFavorit = "Bukan";
		if(strlen($tempObjectDB->getDosenS()) == 40){
			if($tempObjectDB->getDosenS() == $tempObjectDBD->getIdentified()){
				$dosenFavorit = "Ya";
			}
		}
		if(strlen($tempObjectDB->getDosenD()) == 40){
			if($tempObjectDB->getDosenD() == $tempObjectDBD->getIdentified()){
				$dosenFavorit = "Ya";
			}
		}
		if(strlen($tempObjectDB->getDosenT()) == 40){
			if($tempObjectDB->getDosenT() == $tempObjectDBD->getIdentified()){
				$dosenFavorit = "Ya";
			}
		}
		$data['dosenNip'] = $tempObjectDBD->getNip();
		$data['dosenNama'] = $tempObjectDBD->getNama();
		$data['dosenBidris'] = $tempObjectDBD->getBidangRiset();
		$data['dosenAlamat'] = $tempObjectDBD->getAlamat();
		$data['dosenAmail'] = $tempObjectDBD->getEmail();
		$data['dosenNotelp'] = $tempObjectDBD->getNohp();
		$data['dosenFavor']= $dosenFavorit;
		echo "1";
		$this->load->view('Bodyright/Controlroom/Infodosenmahasiswaview',$data);
	}
	protected function changeStatusMahasiswaRegister($tempArray){
		$this->chacheUs['namaMhs'] = "-";
		$this->loadLib("Aktor/Mahasiswa");
		$mahasiswa = new Mahasiswa($this->inputJaservFilter);
		if(!$mahasiswa->getCheckNim($tempArray[0],1)[0])
			return false;
		
		if($tempArray[1] < 1 || $tempArray[1] > 3){
			return false;
		}
		$this->loadLib("ControlTime");
		$this->loadLib("ControlMahasiswa");
		$this->loadLib("ControlRegistrasi");
		$this->loadLib("ControlSeminar");
		$this->loadLib("ControlSidang");
		$controlTime = new ControlTime($this->gateControlModel);
		$tahunAk = $controlTime->getYearNow();
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDB = $controlMahasiswa->getDataByNim($tempArray[0]);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) return false;
		$this->chacheUs['namaMhs'] = $tempObjectDB->getNama();
		$tempObjectDBD = $controlRegistrasi->getAllData($tahunAk, $tempObjectDB->getIdentified(),1,null);
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()) return false;
		if((new ControlSeminar($this->gateControlModel))->getDataByMahasiswa($tahunAk,$tempObjectDB->getIdentified())->getNextCursor()) return false;
		if((new ControlSidang($this->gateControlModel))->getDataByMahasiswa($tahunAk,$tempObjectDB->getIdentified())->getNextCursor()) return false;
		/* echo "data proses ".$tempObjectDB->getNim()." = ".$tempObjectDBD->getDataProses();
		exit(); */
		switch($tempArray[1]){
			case 1 :
			case 2 :
				if($tempArray[1] == 2){
					$tempDosbing = $controlRegistrasi->getDosenPembimbing($tempObjectDBD->getIdentified());
					$tempDosbing->getNextCursor();
					if(strlen($tempDosbing->getDosen()) < 40) return false;
				}
				$tempObjectDBD->setDataProses($tempArray[1]);
				if($controlRegistrasi->tryUpdate($tempObjectDBD)){
					$tempObjectDB->setFormBaru(2);
					$tempObjectDB->setRegistrasiBaru(2);
					$tempObjectDB->setRegistrasiLama(2);
					$tempObjectDB->setTanpaWaktu(2);
					return $controlMahasiswa->tryUpdate($tempObjectDB);
				}
			break;
			case 3 :
				$tempObjectDBD->setDataProses($tempArray[1]);
				if($controlRegistrasi->tryUpdate($tempObjectDBD)){
					if(!$controlTime->isRegisterTime()){
						$tempObjectDB->setTanpaWaktu(1);
					}else{
						$tempObjectDB->setTanpaWaktu(2);
					}
					$tempObjectDB->setFormBaru(1);
					if(intval($tempObjectDBD->getKategori()) == 1){
						$tempObjectDB->setRegistrasiBaru(1);
					}else{
						$tempObjectDB->setRegistrasiLama(1);
					}
					return $controlMahasiswa->tryUpdate($tempObjectDB);
				}
			break;
		}
		return false;
	}
	public function setStatus(){
		$tempS = $this->isNullPost('kodeS');
		$nimEx = explode(",",$this->isNullPost('nim'));
		$string = "<h4>Informasi Acara</h4><div class='well'>Data Tidak ditemukan</div>";
		$dataTemp = "";
		
		$dataNim = "<table style='width 100%;'><thead><tr><td>No</td><td>Nama</td><td>Status perubahan</td></tr></thead><tbody>";
		$tempData = "";
		$n = 1;
		
		echo 1;
		for($i=0;$i<count($nimEx);$i++){
			$nim = $nimEx[$i];
			if($this->changeStatusMahasiswaRegister(array($nim,$tempS))){
				$tempData .= "<tr><td>".$n."</td><td>".$this->chacheUs['namaMhs']."</td><td>berhasil dirubah</td></tr>";
			}else{
				$tempData .= "<tr><td>".$n."</td><td>".($this->chacheUs['namaMhs'] == "-"?$nim:$this->chacheUs['namaMhs'])."</td><td>gagal dirubah</td></tr>";
			}
			$n+=1;
		}
		if($tempData == ""){
			$tempData .= "<tr><td>-</td><td>-</td><td>-</td></tr>";
		}
		$tempData .= "</tbody></table>";
		echo $dataNim."".$tempData;
	}
	//
	//optimized - complex
	//print excel document on this table view
	public function getDataWithExcel($year){
		$year = intval($year);
		$this->loadLib("ControlTime");
		$srt = (new ControlTime($this->gateControlModel))->getYearNow();
		if($year >= 20131 && $year <= intval($srt))
			$srt = $year."";
		$srt = "".$srt."";
		$this->load->library("phpexcel");
		 //membuat objek
		$objPHPExcel = new Phpexcel();
		$listTitle = array(
			'No',
			'Nim',
			'Nama',
			"No Handphone",
			'Judul',
			'Status',
			'Dosen',
			'Metode',
			'Referensi 1',
			'Referensi 2',
			'Referensi 3',
			'Dosen yang dipilih 1',
			'Dosen yang dipilih 2',
			'Dosen yang dipilih 3',
		);
		$year = intval(substr($srt,0,4));
		$semester = "ganjil dan genap";
		$semesters = 2;
		if(strlen($srt) == 5){
			$semesters = 1;
			if($srt[4] == '1')
				$semester = "ganjil";
			else
				$semester = "genap";
		}
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "Peserta Registrasi Tahun Ajaran ".$year."-".($year+1)." Semester ".$semester);
		$objPHPExcel->getActiveSheet()->mergeCells('B2:O2');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(42);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(165);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(38);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(100);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(165);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(165);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(165);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(38);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(38);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(38);
		//set font bold
		$objPHPExcel->getActiveSheet()->getStyle("B2")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("B4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("C4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("D4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("E4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("F4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("G4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("H4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("I4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("J4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("K4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("L4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("M4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("N4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("O4")->getFont()->setBold(true);
		//set text align center
		$objPHPExcel->getActiveSheet()->getStyle("B2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("B4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("C4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("D4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("E4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("F4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("G4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("H4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("I4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("J4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("K4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("L4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("M4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("N4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("O4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// Nama Field Baris Pertama
		$col = 1;
		foreach ($listTitle as $field)
		{
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 4, $field);
			$col++;
		}
		$this->loadLib("ControlRegistrasi");
		$this->loadLib("ControlMahasiswa");
		$this->loadLib("ControlDosen");
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$tempObjectDB = $controlRegistrasi->getAllData($srt,null,1,null);
		$i=1;
		$row = 5;

		if(!$tempObjectDB) exit("0data tidak ditemukan");
		while($tempObjectDB->getNextCursor()){
			$objPHPExcel->getActiveSheet()->getStyle("B".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle("C".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle("E".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//$objPHPExcel->getActiveSheet()->getStyle("D4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//$objPHPExcel->getActiveSheet()->getStyle("E".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle("F".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//$objPHPExcel->getActiveSheet()->getStyle("G".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//$objPHPExcel->getActiveSheet()->getStyle("H".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$tempObjectDBD = $controlMahasiswa->getAllData($tempObjectDB->getMahasiswa());
			$tempObjectDBD->getNextCursor();
			$tempDosbing = $controlRegistrasi->getDosenPembimbing($tempObjectDB->getIdentified());
			$tempDosbing->getNextCursor();
			$tempObjectDBT = $controlDosen->getAllData($tempDosbing->getDosen());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $i);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $tempObjectDBD->getNim());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $tempObjectDBD->getNama());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $tempObjectDBD->getNoHp());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $this->inputJaservFilter->stringFilteringDecode($tempObjectDB->getJudulTA()));//
			if(intval($tempObjectDB->getKategori()) == 1){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Baru");
			}else{
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Melanjutkan");
			}
			if(!$tempObjectDBT || !$tempObjectDBT->getNextCursor())
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "belum dipilihkan");
			else
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $tempObjectDBT->getNama());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $this->inputJaservFilter->stringFilteringDecode($tempObjectDB->getMetode()));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $this->inputJaservFilter->stringFilteringDecode($tempObjectDB->getRefS()));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $this->inputJaservFilter->stringFilteringDecode($tempObjectDB->getRefD()));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $this->inputJaservFilter->stringFilteringDecode($tempObjectDB->getRefT()));
			$tempObjectDBT = $controlDosen->getAllData($tempObjectDBD->getDosenS());
			if(!$tempObjectDBT || !$tempObjectDBT->getNextCursor())
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, "-");
			else
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $tempObjectDBT->getNama());
			$tempObjectDBT = $controlDosen->getAllData($tempObjectDBD->getDosenD());
			if(!$tempObjectDBT || !$tempObjectDBT->getNextCursor())
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, "-");
			else
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $tempObjectDBT->getNama());
			$tempObjectDBT = $controlDosen->getAllData($tempObjectDBD->getDosenT());
			if(!$tempObjectDBT || !$tempObjectDBT->getNextCursor())
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "-");
			else
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $tempObjectDBT->getNama());
			$row++;
			$i++;
		}
		$objPHPExcel->setActiveSheetIndex(0);
		//Set Title
		$objPHPExcel->getActiveSheet()->setTitle('Data Absen');
		//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		//Header
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//Nama File
		header('Content-Disposition: attachment;filename="Data Peserta Registrasi Tugas Akhir Tahun '.$year.'-'.($year+1).' Semester '.($semester == 1? "Gasal":"Genap").'.xlsx"');
		//Download
		$objWriter->save("php://output");
	}
}
