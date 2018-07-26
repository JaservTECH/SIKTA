<?php
/*
dependencies:
-Koordinator
-ControlEvent
-ControlTime
*/
if(!defined('BASEPATH'))
	exit("You dont have permission on this siite");
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
Class Controlacarakoor extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->loadLib('ControlTime');
		$this->koordinator->initial($this->inputJaservFilter);
		if(!$this->loginFilter->isLogin($this->koordinator))
			exit("#<script>window.location = '".base_url()."Gateinout.jsp'</script>");
	
		$this->loadLib("Inputjaservfilter");
		$this->inputJaservFilter = new Inputjaservfilter();
	}
	public function getLayoutAcara(){
		echo "1";
		$tempYear = (new ControlTime($this->gateControlModel))->getYearNow();
		$data['year'] = intval(substr($tempYear,0,4));
		$data['semester'] = intval(substr($tempYear,4,1));
		$this->load->view("Bodyright/Controlroom/Acara.php",$data);
	}
	//exist on javascript
	public function getTableAcara(){
		echo "1";
		$this->loadLib("ControlEvent");
		$tempObjectDB = (new ControlEvent($this->gateControlModel))->getAllData(1);
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$tahunNow = false;
		$data = "";
		$no = 1;
		while($tempObjectDB->getNextCursor()){
			$tempYear = substr($tempObjectDB->getTahunAk(),0,4);
			$tempSemester = $tempObjectDB->getTahunAk()[4];
			if(intval($tempObjectDB->getStatus()) == 1 && intval($tempObjectDB->getTahunAk()) == intval($tahunAk)){
				$tahunNow = true;
				$data .= "<tr>
					<td style='text-align : center;'>1</td>
					<td style='text-align : center;'>".$tempYear."</td>
					<td style='text-align : center;'>".$tempSemester."</td>
					<td style='text-align : center;'>".$this->dateJaservFilter->setDate($tempObjectDB->getMulai()." 00:00:00",true)->getDate("L WMM Y",false)."</td>
					<td style='text-align : center;'>".$this->dateJaservFilter->setDate($tempObjectDB->getBerakhir()." 23:59:59",true)->getDate("L WMM Y",false)."</td>
					<td style='text-align : center;'>
						<div style='text-align : center;'>
							<button class='btn btn-clean btn-primary' onclick='editAkademikAktif();'  title='Ubah jadwal registrasi'><span class='icon-edit'> ubah</span></button>
							<button class='btn btn-clean btn-info' onclick='showMeThisRegistrasiContent(".$tempYear.",".$tempSemester.")' title='lihat lebih lengkap'><span class='icon-info-sign'> selengkapnya</span></button>								
						</div>
					</td>
				</tr>";
				/* 
				<div>
					<div class='col-md-4'>
						<span class='icon-pencil pointer' style='color : green' title='lakukan perubahan jadwal : ya'></span>
					</div>
					<div class='col-md-4'>
						<span class='icon-ok' style='color:red' title='sudah diarsipkan : tidak'></span>
					</div>
					<div class='col-md-4'>
						<span class='icon-info-sign pointer' onclick='showMeThisRegistrasiContent(".$tempYear.",".$tempSemester.")' style='color:green' title='lihat lebih lengkap'></span>
					</div>
				</div>
				*/
			}else{
				$data .= "<tr>
					<td style='text-align : center;'>".$no."</td>
					<td style='text-align : center;'>".$tempYear."</td>
					<td style='text-align : center;'>".$tempSemester."</td>
					<td style='text-align : center;'>".$this->dateJaservFilter->setDate($tempObjectDB->getMulai()." 00:00:00",true)->getDate("L WMM Y",false)."</td>
					<td style='text-align : center;'>".$this->dateJaservFilter->setDate($tempObjectDB->getBerakhir()." 23:59:59",true)->getDate("L WMM Y",false)."</td>
					<td style='text-align : center;'>
						<div style='text-align : center;'>
							<button disabled class='btn btn-clean btn-primary' title='Sudah diarsipkan'><span class='icon-edit'> ubah</span></button>
							<button class='btn btn-clean btn-info' onclick='showMeThisRegistrasiContent(".$tempYear.",".$tempSemester.")' title='lihat lebih lengkap'><span class='icon-info-sign'> selengkapnya</span></button>								
						</div>
					</td>
				</tr>";
				/* 
				<div>
					<div class='col-md-4'>
						<span class='icon-pencil' style='color : red' title='lakukan perubahan jadwal : tidak'></span>
					</div>
					<div class='col-md-4'>
						<span class='icon-ok' style='color:green' title='sudah diarsipkan :ya'></span>
					</div>
					<div class='col-md-4'>
						<span class='icon-info-sign pointer' onclick='showMeThisRegistrasiContent(".$tempYear.",".$tempSemester.")' style='color:green' title='lihat lebih lengkap'></span>
					</div>
				</div>
				*/
			}
			$no++;
		}
		if(!$tahunNow){
			$tempYear = substr($tahunAk,0,4);
			$tempSemester = $tahunAk[4];
			echo "<tr>
				<td style='text-align : center;'>1</td>
				<td style='text-align : center;'>".$tempYear."</td>
				<td style='text-align : center;'>".$tempSemester."</td>
				<td style='text-align : center;'>".$this->dateJaservFilter->setDate(date("Y-m-d H:i:s"),true)->getDate("L WMM Y",false)."</td>
				<td style='text-align : center;'>".$this->dateJaservFilter->setDate(date("Y-m-d H:i:s"),true)->getDate("L WMM Y",false)."</td>
				<td style='text-align : center;'>
					<div style='text-align : center;'>
						<button class='btn btn-clean btn-primary' onclick='editAkademikAktif();' title='Ubah jadwal registrasi'><span class='icon-edit'> ubah</span></button>
						<button class='btn btn-clean btn-info' onclick='showMeThisRegistrasiContent(".$tempYear.",".$tempSemester.")' title='lihat lebih lengkap'><span class='icon-info-sign'> selengkapnya</span></button>								
					</div>
				</td>
			</tr>";
			/* <div class='col-md-4'>
				<span class='icon-pencil pointer' style='color : green'  title='lakukan perubahan jadwal : ya'></span>
			</div>
			<div class='col-md-4'>
				<span class='icon-ok' style='color:red' title='sudah diarsipkan : tidak'></span>
			</div>
			<div class='col-md-4'>
				<span class='icon-info-sign pointer'  style='color:green' title='lihat lebih lengkap'></span>
			</div> */
		}
		echo $data;
	}
	//exist on javascript
	public function getTableAcaraNonDefault(){
		$year = $this->input->post('year');
		$kode = $this->isNullPost('kode');
		if(strlen($year) <= 0) 
			$year = "";
		if(!$this->koordinator->getCheckTitle($year,1)[0]) $year = null;
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		$this->loadLib('ControlEvent');
		$tempObjectDB = (new ControlEvent($this->gateControlModel))->getAllData(3,null,$year);
		//var_dump($BOOL);
		echo "1";
		if($tempObjectDB->getCountData() == 0){
			echo "<tr>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
			</tr>";
		}else{
			$ii = 0;
			$no = 1;
			while($tempObjectDB->getNextCursor()){
				$judul = $this->inputJaservFilter->stringFilteringDecode($tempObjectDB->getJudul());
				$isi = $this->inputJaservFilter->stringFilteringDecode($tempObjectDB->getIsi());
				
				echo "<tr>
					<td style='text-align : center;'>".$no."</td>
					<td>".(strlen($judul) > 20?substr($judul,0,20)."...":$judul)."</td>
					<td>".(strlen($isi) > 30?substr($isi,0,45)."...":$isi)."</td>
					<td style='text-align : center;'>";
				if(intval($tempObjectDB->getStatus()) == 1)
				{
					echo "
							<div>
								<button class='btn btn-clean btn-primary'  onclick='editEventAktif(".'"'.$tempObjectDB->getIdentified().'"'.");' title='ubah informasi'><span class='icon-edit'> ubah</span></button>
								<button class='btn btn-clean btn-info'  onclick='showMeThisRegistrasiContentNonDefault(".'"'.$tempObjectDB->getIdentified().'"'.")' title='lihat lebih lengkap'><span class='icon-info-sign'> selengkapnya</span></button>								
								
							</div>
						</td>
					</tr>";
				}
				else{
					echo "
							<div>
								<button disabled class='btn btn-clean btn-primary' title='informasi sudah diarsipkan'><span class='icon-edit'> ubah</span></button>
								<button class='btn btn-clean btn-info'  onclick='showMeThisRegistrasiContentNonDefault(".'"'.$tempObjectDB->getIdentified().'"'.")' title='lihat lebih lengkap'><span class='icon-info-sign'> selengkapnya</span></button>								
							</div>
						</td>
					</tr>";
				}
				$no++;
			}
		}
	}
	public function getJsonDataRegistrasiActive(){
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$this->loadLib('ControlEvent');
		$tempObjectDB = (new ControlEvent($this->gateControlModel))->getDataByTahunAk($tahunAk);
		$data = null;
		if(!$tempObjectDB->getNextCursor()){
			$data = array(
			"year"=>substr($tahunAk,0,4),
			"semester"=>$tahunAk[4],
			"start"=>date("Y-m-d"),
			"end"=>date("Y-m-d"),
			"judul"=>"",
			"isi"=>""
			);
		}else{
			$data = array(
			"year"=>substr($tempObjectDB->getTahunAk(),0,4),
			"semester"=>$tempObjectDB->getTahunAk()[4],
			"start"=>$tempObjectDB->getMulai(),
			"end"=>$tempObjectDB->getBerakhir(),
			"judul"=>$this->inputJaservFilter->stringFilteringDecode($tempObjectDB->getJudul()),
			"isi"=>$this->inputJaservFilter->stringFilteringDecode($tempObjectDB->getIsi())
			);
		}
		echo "1".json_encode($data);
	}
	//exist on javascript
	public function getJsonDataRegistrasi(){
		$tahunAk = intval($this->isNullPost('year')."".$this->isNullPost('semester'));
		if($tahunAk < 20131 || $tahunAk > 99999){
			exit("0Anda melakukan debugging");
		}
		$tahunAk .="";
		$this->loadLib('ControlEvent');
		$tempObjectDB = (new ControlEvent($this->gateControlModel))->getDataByTahunAk($tahunAk,1,null);
		$data = null;
		if(!$tempObjectDB->getNextCursor()){
			$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
			$data = array(
			"year"=>substr($tahunAk,0,4),
			"semester"=>$tahunAk[4],
			"start"=>date("Y-m-d"),
			"end"=>date("Y-m-d"),
			"judul"=>"",
			"isi"=>""
			);
		}else{
			$data = array(
			"year"=>substr($tahunAk,0,4),
			"semester"=>substr($tahunAk,4,1),
			"start"=>$tempObjectDB->getMulai(),
			"end"=>$tempObjectDB->getBerakhir(),
			"judul"=>$this->inputJaservFilter->stringFilteringDecode($tempObjectDB->getJudul()),
			"isi"=>$this->inputJaservFilter->stringFilteringDecode($tempObjectDB->getIsi())
			);
		}
		echo "1".json_encode($data);
	}
	public function getCheck($value=null,$kode=null,$cat=null){
		if($value == null){
			$value = $this->isNullPost('value'); 
		}
		if($kode == null){
			$kode = $this->isNullPost('kode');
		}
		if($cat == null){
			$cat = $this->isNullPost('cat');
		}
		
		$value=str_ireplace("|--|","&",$value);
		//exit("0".$value);
		switch ($kode){
			case 'SUMMARY' :
				return $this->koordinator->getCheckSummary($value,$cat);
				break;
			case 'TITLE' :
				return $this->koordinator->getCheckTitle($value,$cat);
				break;
			case 'DATE' :
				if($cat == 0)
					exit("1Valid");
				else 
					return true;
				break;
		}
	}
	//valid
	public function getJsonDataEventActive(){
		$TEMP_CODE = $this->isNullPost('kode');
		$TEMP_ID=$this->isNullPost('id');
		if($TEMP_CODE != "JASERVCONTROL")
			exit("0maaf, anda melakukan debuggings");
		$this->loadLib('ControlEvent');
		$tempObjectDB = (new ControlEvent($this->gateControlModel))->getDataByIdentified($TEMP_ID);
		if(!$tempObjectDB) exit("0anda melakukan debuggingd");
		$temp1='1{"data" : [';
		if(!$tempObjectDB->getNextCursor()){
			$year = (new ControlTime($this->gateControlModel))->getYearNow();
			$temp1.=(substr($year,0,4).",".$year[4].',"'.date("Y-m-d").'","'.date("Y-m-d").'","",""');
		}else{
			$temp1.=(substr($tempObjectDB->getTahunAk(),0,4).",".substr($tempObjectDB->getTahunAk(),4,1).',"'.$tempObjectDB->getMulai().'","'.$tempObjectDB->getBerakhir().'","'.$this->inputJaservFilter->stringFilteringDecode($tempObjectDB->getJudul()).'","'.$this->inputJaservFilter->stringFilteringDecode($tempObjectDB->getIsi()).'"');
		}
		$temp1.="]}";
		echo $temp1;
	}
	//exist on javascript
	public function getJsonDataRegistrasiNonDefault(){
		$this->loadLib('ControlEvent');
		$tempObjectDB = (new ControlEvent($this->gateControlModel))->getDataByIdentified($this->isNullPost('id'));
		if(!$tempObjectDB) exit("0anda melakukan debugging");
		$temp1='1{"data" : [';
		if(!$tempObjectDB->getNextCursor()){
			$year = (new ControlTime($this->gateControlModel))->getYearNow();
			$temp1.=(substr($year,0,4).",".$year[4].',"'.date("Y-m-d").'","'.date("Y-m-d").'","",""');
		}else{
			$temp1.=(substr($tempObjectDB->getTahunAk(),0,4).",".substr($tempObjectDB->getTahunAk(),4,1).',"'.$tempObjectDB->getMulai().'","'.$tempObjectDB->getBerakhir().'","'.$tempObjectDB->getJudul().'","'.$tempObjectDB->getIsi().'"');
		}
		$temp1.="]}";
		
		echo $temp1;
	}
	public function setNewAkademik(){
		$start = $this->isNullPost('start');
		$end = $this->isNullPost('end');
		$kode = $this->isNullPost('kode');
		$title = $this->inputJaservFilter->stringFiltering(str_ireplace("|--|","&",$this->isNullPost('title')));
		$summary = $this->inputJaservFilter->stringFiltering(str_ireplace("|--|","&",$this->isNullPost('summary'))); 
		if(md5($kode) != md5("JASERVTECH-CODE-CREATE-NEW-AKADEMIK"))
			exit("0maaf, anda tidak berhak mengakses kedalam halaman ini");
		if(!$this->getCheck($start,"DATE",1))
			exit("0maaf, input data mulai hari ini");
		if(!$this->getCheck($end,"DATE",1))
			exit("0maaf, input data mulai hari ini");
		$this->loadLib('Datejaservfilter');
		$dateJaservFilter = new Datejaservfilter();
		if(!$dateJaservFilter->setDate($start,true)->isBefore($end)){
			exit("0tanggal mulai harus lebih awal dari tanggal akhir");
		}
		
		$this->loadLib('ControlKoordinator');
		$tempObjectDBD = (new ControlKoordinator($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
		if(!$tempObjectDBD->getNextCursor()) exit("0terjadi kesalahan saat menvalidasi data");
		
		$ganjil = explode("|", $tempObjectDBD->getStartGanjil());
		$genap = explode("|", $tempObjectDBD->getStartGenap());
		$tempGanjil = date("Y")."-".$ganjil[0]."-".$ganjil[1]." 00:00:00";
		$tempGenap = date("Y")."-".$genap[0]."-".$genap[1]." 00:00:00";
		$tempStart = "";
		$tempEnd = "";
		$now = date("Y-m-d H:i:s");
		if($dateJaservFilter->setDate($tempGanjil,true)->isBefore($tempGenap)){
			if($dateJaservFilter->setDate($now,true)->isBefore($tempGanjil)){
				$tempStart = (intval(date("Y"))-1)."-".$genap[0]."-".$genap[1]." 00:00:00";
				$tempEnd = $tempGanjil;
			}else if($dateJaservFilter->setDate($now,true)->isAfterAndNow($tempGenap)){
				$tempStart = $tempGenap;
				$tempEnd = (intval(date("Y"))+1)."-".$ganjil[0]."-".$ganjil[1]." 00:00:00";
			}else{
				$tempStart = $tempGanjil;
				$tempEnd = $tempGenap;
			}
		}else{
			if($dateJaservFilter->setDate($now,true)->isBefore($tempGenap)){
				$tempStart = (intval(date("Y"))-1)."-".$ganjil[0]."-".$ganjil[1]." 00:00:00";
				$tempEnd = $tempGenap;
			}else if($dateJaservFilter->setDate($now,true)->isAfterAndNow($tempGanjil)){
				$tempStart = $tempGanjil;
				$tempEnd = (intval(date("Y"))+1)."-".$genap[0]."-".$genap[1]." 00:00:00";
			}else{
				$tempStart = $tempGenap;
				$tempEnd = $tempGanjil;
			}
		}
		if(!$dateJaservFilter->setDate($start." 00:00:00",true)->isBefore($tempEnd, true)->isAfterAndNow($tempStart)){
			exit("0Maaf waktu awal harus diantara waktu akademik yang sedang berlangsung");
		}
		if(!$dateJaservFilter->setDate($end." 00:00:00",true)->isBefore($tempEnd, true)->isAfterAndNow($tempStart)){
			exit("0Maaf waktu akhir harus diantara waktu akademik yang sedang berlangsung");
		}
		
		
		$this->loadLib('ControlEvent');
		if((new ControlEvent($this->gateControlModel))->setAktifAkademikRegistrasi($start,$end,$title,$summary,(new ControlTime($this->gateControlModel))->getYearNow())) exit('1berhasil memasukan data waktu registrasi akademik');
		exit("0gagal melakukan perubahan terhadapa waktu akademik");
	}
	public function setDataEditEvent(){
		$id = $this->isNullPost('id');
		$start = date("Y-m-d");
		$end = date("Y-m-d");
		$kode = $this->isNullPost('kode');
		$title = $this->inputJaservFilter->stringFiltering(str_ireplace("|--|","&",$this->isNullPost('title')));
		$summary = $this->inputJaservFilter->stringFiltering(str_ireplace("|--|","&",$this->isNullPost('summary')));
		if(md5($kode) != md5("JASERVTECH-CODE-CREATE-NEW-EVENT"))
			exit("0maaf, anda tidak berhak mengakses kedalam halaman ini");
		$this->loadLib('ControlEvent');
		if((new ControlEvent($this->gateControlModel))->setAktifAkademikEvent($start,$end,$title,$summary,$id)) exit('1berhasil memasukan data waktu registrasi akademik');
		exit("0gagal melakukan perubahan terhadapa waktu akademik");
	}
	public function setNewEvent(){
		$start = date("Y-m-d");
		$end = date("Y-m-d");
		$kode = $this->isNullPost('kode');
		$title = $this->inputJaservFilter->stringFiltering(str_ireplace("|--|","&",$this->isNullPost('title')));
		$summary = $this->inputJaservFilter->stringFiltering(str_ireplace("|--|","&",$this->isNullPost('summary')));
		if(md5($kode) != md5("JASERVTECH-CODE-CREATE-NEW-EVENT-AKADEMIK"))
			exit("0maaf, anda tidak berhak mengakses kedalam halaman ini");
		$this->loadLib('ControlEvent');
		$this->loadLib('ControlTime');
		if((new ControlEvent($this->gateControlModel))->setNewAktifAkademikEvent($start,$end,$title,$summary,(new ControlTime($this->gateControlModel))->getYearNow())) exit('1berhasil memasukan data waktu registrasi akademik');
		exit("0gagal melakukan perubahan terhadapa waktu akademik");
	}
}