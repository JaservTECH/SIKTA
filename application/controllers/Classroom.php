<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');

require_once(APPPATH.'controllers/CI_Controller_Modified.php');
/*
dependencies:
-ControlDosen
-ControlMahasiswa
-ControlRegistrasi
-ControlTime
*/
class Classroom extends CI_Controller_Modified {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->mahasiswa))
			exit("#<script>window.location = '".base_url()."Gateinout.jsp'</script>");
	}
	//fix
	public function index($pageShow="default"){
		$this->loadLib('ControlMahasiswa');
		$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDB->getNextCursor();
		$data['url_script'] = array(
			"resources/taurus/js/plugins/jquery/jquery.min.js",
			"resources/taurus/js/plugins/jquery/jquery-ui.min.js",
			"resources/taurus/js/plugins/jquery/jquery-migrate.min.js",
			"resources/taurus/js/plugins/jquery/globalize.js",	
			"resources/taurus/js/plugins/bootstrap/bootstrap.min.js",
			"resources/taurus/js/plugins/uniform/jquery.uniform.min.js",
			"resources/taurus/js/plugins/select2/select2.min.js",
			"resources/taurus/js/plugins/tagsinput/jquery.tagsinput.min.js",
			"resources/taurus/js/plugins/jquery/jquery-ui-timepicker-addon.js",
			"resources/taurus/js/plugins/fullcalendar/fullcalendar.min.js",
			"resources/plugins/fullcalendar/v2/lib/moment.min.js",
			"resources/taurus/js/plugins/noty/jquery.noty.js",
			"resources/taurus/js/plugins/noty/layouts/topCenter.js",
			"resources/taurus/js/plugins/noty/layouts/topLeft.js",
			"resources/taurus/js/plugins/noty/layouts/topRight.js",
			"resources/taurus/js/plugins/noty/themes/default.js",
			"resources/LibraryJaserv/js/jaserv.min.dev.js",
			"resources/LibraryJaserv/js/jaservajax.powerfull.dev.js",
			"resources/mystyle/js/global-style.js",
			"resources/mystyle/js/Classroom-beranda.js",
			"resources/mystyle/js/Classroom-registrasi-baru.js",
			"resources/mystyle/js/Classroom-registrasi-lama.js",
			"resources/mystyle/js/Classroom-seminartad.js",
			"resources/mystyle/js/Classroom-bimbingan.js",
			"resources/mystyle/js/Classroom-likedosen.js",
			"resources/mystyle/js/Classroom-pengaturan.js",
			"resources/mystyle/js/Classroom-bantuan.js",
			"resources/mystyle/js/Classroom-seminartas.js",
			"resources/mystyle/js/Classroom-acara.js",
			"resources/mystyle/js/Classroom.js",
			/*
				
				
				//"resources/taurus/js/settings.js",
				*/
		);
		$data['url_link'] = array(
				"resources/taurus/css/stylesheets.css",
				"resources/mystyle/css/global-style.css",
				"resources/mystyle/css/classroom.css"
		);
		$data['nim'] = $tempObjectDB->getNim();
		$data['nama'] = $tempObjectDB->getNama();
		$data['title'] = "Beranda | Mahasiswa";
		$data['pageShow'] = $pageShow;
		$this->load->view('Structure/Header',$data);
		$data['image'] = base_url().'filesupport/getPhotoMahasiswaProfil/'.$tempObjectDB->getNim();
		$this->load->view('Structure/Bodytopcls',$data);
		$this->load->view('Structure/Bodyleftcls',$data);
		$this->load->view('Bodyright/Classroom/Bodyright');
		$this->load->view('Structure/Bodyplugcls');
		$dataFoot['url_script'] = array(
				"resources/plugins/calender/underscore-min.js",
				"resources/plugins/calender/moment-2.2.1.js",
				"resources/plugins/calender/clndr.js",
				"resources/plugins/calender/site.js"
		);
		$dataFoot['url_link'] = array(
				"resources/plugins/calender/clndr.css"
		);
		$this->load->view('Structure/Footer',$dataFoot);
	}
	//fix
	public final function signOut(){
		$this->loginFilter->setLogOut();
		redirect(base_url()."Gateinout.jsp");
	}
	//fix
	public function getLayoutHome(){
		echo "1";
		$this->load->view("Bodyright/Classroom/Home");
	}
	//fix
	public function getJsonInfoFastRegistrasi(){
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlTime');
		$this->loadLib('ControlRegistrasi');
		$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDB->getNextCursor();
		$controlTime = new ControlTime($this->gateControlModel);
		$tahunAk = $controlTime->getYearNow();
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$tempObjectDBD = $controlRegistrasi->getAllData($tahunAk,$tempObjectDB->getIdentified(),1, null);
		$data['tombolsavetoasnew'] = $tempObjectDB->getTanpaWaktu()."";
		$data['name'] = $tempObjectDB->getNama();
		$data['nim'] = $tempObjectDB->getNim();
		$data['ta'] = "Belum Registrasi";
		$data['dosen'] = "Belum daftar";
		$temp_change_content = true;
		$temp_bool = false;
		if($tempObjectDBD)
			$temp_bool = $tempObjectDBD->getNextCursor();
		
		
		$data['statusta'] = 'Belum Mengajukan';
		$data['kodeubah'] = "00";
		
		if(!$temp_bool) $data['kodeubah'] = "00";
		if(intval($tempObjectDB->getFormBaru()) == 1){	
			$temp_change_content = false;
			if(intval($tempObjectDB->getRegistrasiBaru()) == 1){
				$data['ta'] = "Mengajukan ulang Judul TA";
				$data['dosen'] = "Belum bisa di pilihkan";
				if(intval($tempObjectDB->getRegistrasiLama()) == 1){
					$data['ta'] = "Mengajukan ulang Judul TA";
					$data['dosen'] = "Belum bisa di pilihkan";
				}
			}
		} 
		$isTime = $controlTime->isRegisterTime();
		//var_dump($temp_change_content);
		if($temp_change_content){
			if($temp_bool){
				$data['ta'] = $this->inputJaservFilter->stringFilteringDecode($tempObjectDBD->getJudulTa());
				$data['referensis'] = $this->inputJaservFilter->stringFilteringDecode($tempObjectDBD->getRefS());
				$data['referensid'] = $this->inputJaservFilter->stringFilteringDecode($tempObjectDBD->getRefD());
				$data['referensit'] = $this->inputJaservFilter->stringFilteringDecode($tempObjectDBD->getRefT());
				$data['lokasi'] = $this->inputJaservFilter->stringFilteringDecode($tempObjectDBD->getLokasi());
				$data['metode'] = $this->inputJaservFilter->stringFilteringDecode($tempObjectDBD->getMetode());
				$data['tombolsavetoasnew'] .= $tempObjectDBD->getKategori();
				$tempObjectDBT = $this->controlDetail->getDetail('kategori',$tempObjectDBD->getKategori());
				if($tempObjectDBT->getNextCursor() && $tempObjectDBT){
					$data['kategori'] = $tempObjectDBT->getDetail();
					
				}
				$data['kodeubah'] = "01";
				if($isTime){
					if(intval($tempObjectDBD->getDataProses()) != 2){
						$data['kodeubah'] = "11";
					}
					
				}else if(intval($tempObjectDB->getTanpaWaktu()) == 1){
					if(intval($tempObjectDBD->getDataProses()) != 2){
						$data['kodeubah'] = "11";
					}
				}
				
				$tempDosbing = $controlRegistrasi->getDosenPembimbing($tempObjectDBD->getIdentified());
				$tempDosbing->getNextCursor();
				if(strlen($tempDosbing->getDosen()) != 40){
					$data['dosen'] = "Dalam Proses seleksi dosen";
				}else{
					$this->loadLib('ControlDosen');
					$tempObjectDBT = (new ControlDosen($this->gateControlModel))->getAllData($tempDosbing->getDosen());
					$tempObjectDBT->getNextCursor();
					$data['dosen'] = $tempObjectDBT->getNama();
				}
				$tempObjectDBT = $this->controlDetail->getDetail('dataproses',$tempObjectDBD->getDataProses());
				if($tempObjectDBT->getNextCursor() && $tempObjectDBT){
					$data['statusta'] = $tempObjectDBT->getDetail();
					
				}
			}
		}
		echo json_encode($data);
		return;
	}
	
	public function setReferences(){
		if($this->input->post('kode') === null)
			exit('0kode tidak diterima');
		if($this->input->post('referensi') === null)
			exit('0isi tidak diterima');
		$kode = intval($this->input->post('kode'));
		if($kode > 7 || $kode < 1){
			exit("0Kode tidak valid");
		}
		$isi = $this->input->post('referensi');
		$isi = str_ireplace('|--|','&',$isi);
		$this->mahasiswa->initial($this->inputJaservFilter);
		$this->loadLib('ControlTime');
		$this->loadLib('ControlMahasiswa');
		$controlTime = new ControlTime($this->gateControlModel);
		$tahunAk = $controlTime->getYearNow();
		$this->loadLib('ControlRegistrasi');
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$tempObjectDB = $controlRegistrasi->getAllData($tahunAk, $this->loginFilter->getIdentifiedActive(), 1,null);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor())
			exit('0anda belum registrasi');
		if(intval($tempObjectDB->getDataProses()) == 2)
			exit("0registrasi sudah disetujui");
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDBD = $controlMahasiswa->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDBD->getNextCursor();
		if(!$controlTime->isRegisterTime()){
			if(intval($tempObjectDBD->getTanpaWaktu()) == 2){
				exit('0Maaf, waktu registrasi sudah selesai atau tidak memiliki izin perubahan');
			}
		}
		$bool = false;
		switch($kode){
			case 1 :
				if(!$this->mahasiswa->getCheckTitleFinalTask($isi,1)[0]){
					exit("0format judul tidak valid");
				}
				$isi = $this->inputJaservFilter->stringFiltering($isi);
				$tempObjectDB->setJudulTA($isi);
			break;
			case 2 :
				if(!$this->mahasiswa->getCheckMethode($isi,1)[0]){
					exit("0format metode tidak valid");
				}
				$isi = $this->inputJaservFilter->stringFiltering($isi);
				$tempObjectDB->setMetode($isi);
			break;
			case 3 :
				if(!$this->mahasiswa->getCheckLokasi($isi,1)[0]){
					exit("0format lokasi tidak valid");
				}
				$isi = $this->inputJaservFilter->stringFiltering($isi);
				$tempObjectDB->setLokasi($isi);
			break;
			case 4 :
			case 5 :
			case 6 :
				if(!$this->mahasiswa->getCheckRefrence($isi,1)[0]){
					exit("0Kontent referensi tidak valid");
				}
				$isi = $this->inputJaservFilter->stringFiltering($isi);
				switch($kode){
					case 4 :
						$errorRefere = 0;
						if($isi == ""  || $isi == " "){
							if($tempObjectDB->getRefD() == "" || $tempObjectDB->getRefD() == " " || $tempObjectDB->getRefD() === null)
								$errorRefere++;
							if($tempObjectDB->getRefT() == "" || $tempObjectDB->getRefT() == " " || $tempObjectDB->getRefT() === null)
								$errorRefere++;
							if($errorRefere == 2){
								exit("0minimal 1 referensi");
							}
							$tempObjectDB->setRefS($tempObjectDB->getRefD());
							$tempObjectDB->setRefD($tempObjectDB->getRefT());
							$tempObjectDB->setRefT("");
						}else{
							$tempObjectDB->setRefS($isi);
						}
					break;
					case 5 :
						if($isi == "" || $isi == " "){
							$tempObjectDB->setRefD(($tempObjectDB->getRefT()===null?"":$tempObjectDB->getRefT()));
							$tempObjectDB->setRefT("");
						}else{
							$tempObjectDB->setRefD($isi);
						}
					break;
					case 6 :
						$tempObjectDB->setRefT($isi);
					break;
				}
			break;
			case 7 :
				$filename = "";
				$conPic['upload_path'] = './upload/krs/';	
				$conPic['allowed_types'] = 'pdf'; 
				$conPic['file_name'] = substr($tempObjectDB->getNamaKRS(),0,(strlen($tempObjectDB->getNamaKRS())-4));	
				$conPic['overwrite'] = true; 
				$conPic['remove_spaces'] = true; 
				$conPic['max_size'] = 1000;	 
				$this->load->library('upload');
				$this->upload->initialize($conPic);
				if(!$this->upload->do_upload($isi)){
					exit('0Gagal mengganti Krs');		
				}	
				$filename = $this->upload->data('file_name');
				if($filename == ""){
					exit("0data kosong, silahkan pilih jika ingin merubah");
				}
				$tempObjectDB->setNamaKRS($filename);
			break;
		}
		$tempObjectDB->setDataProses(1);
		//exit("1".$tempObjectDB->getRefS());
		if($controlRegistrasi->tryUpdate($tempObjectDB)){
			echo "1Berhasil mengubah";
		}
		else echo "0gagal mengubah";
	}
}