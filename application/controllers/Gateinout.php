<?php
/*
This Class has been rebuild revision build v3.0 Gateinout.php
Author By : Jafar Abdurrahman Albasyir
Since : 17/5/2016
Work : Home on 08:05 PM
dependencies:
-LoginFilter
-GateControlModel
-ControlMahasiswa
-ControlTime
-Inputjaservfilter
-Dosen
-Admin
-Koordinator
-Mahasiswa
*/
require_once APPPATH."libraries/PHPMailer/src/Exception.php";
require_once APPPATH."libraries/PHPMailer/src/SMTP.php";
require_once APPPATH."libraries/PHPMailer/src/PHPMailer.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Gateinout extends CI_Controller_Modified {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
	}
	//optimized
	public function index($tempInput=null){
		if($this->loginFilter->isLogin($this->mahasiswa)) redirect(base_url()."Classroom");
		if($this->loginFilter->isLogin($this->koordinator))	redirect(base_url()."Controlroom");
		if($this->loginFilter->isLogin($this->dosen)) redirect(base_url()."Kingroom");
		if($this->loginFilter->isLogin($this->admin)) redirect(base_url()."Palaceroom");
		$tempArray['url_script'] = array(
				"resources/mystyle/js/gateinout.js",
				"resources/LibraryJaserv/js/jaserv.min.dev.js",
				"resources/LibraryJaserv/js/ajax/jaservtech.ajax.js",
		);
		$tempArray['url_link'] = array(
				"resources/mystyle/css/gateinout.css",
				"resources/mystyle/css/global-style.css"
		);
		if($tempInput == null)
			$tempArray['backtobaseroom'] = false;
		else if($tempInput == "baseroom")
			$tempArray['backtobaseroom'] = true;
		else{
			$tempArray['backtobaseroom'] = false;
		}
		$this->load->view('Gateinout_layout',$tempArray);
	}
	//-optimized
	//function handle requesting for login
	public function getSignIn(){
		$nickName = $this->isNullPost('login-nim','Username tidak boleh kosong');
		$this->analysisFilterInput('login-nim', $nickName);
		$keyWord = $this->isNullPost('login-password', 'Password tidak boleh kosong');
		$this->analysisFilterInput('login-password', $keyWord);
		if($this->loginFilter->setLogIn($nickName,$keyWord))
			exit("1Gateinout");
		exit("0Akun anda tidak terdaftar dimanapun");
	}
	//optimized
	//function that handle requesting for reset password 
	public function resetPassword(){
		//$_POST['nim'] = '24010313130125';
		$this->mahasiswa->initial($this->inputJaservFilter);
		$nim = $this->isNullPost('nim');
		if(!$this->mahasiswa->getCheckNim($nim,1)[0]) exit('0Nim Tidak Valid');
		$this->loadLib("ControlMahasiswa");
		$waktuCookie = date("Y-m-d H:i:s");
		$this->load->helper('email');
		$kodeCookie = md5($waktuCookie."RequestResetNimBy".$nim);
		$email = (new ControlMahasiswa(new GateControlModel()))->trySendEmail($nim,$waktuCookie,$kodeCookie);
		if(!$email) exit("0terjadi kesalahan, mungkin nim anda tidak terdaftar, maupun akun anda sudah tidak aktif, atau email yang anda tautkan tidak valid");
		
		$tempArray = str_ireplace("=","+++1",
			base64_encode(
				str_ireplace("=","|",base64_encode($nim))."|".str_ireplace("=","|",base64_encode($email))."||".
				str_ireplace("=",'|',base64_encode($this->dateJaservFilter->human_to_unix($waktuCookie) + 1024))."|||".
				str_ireplace("=",'|',base64_encode(base_url()."Resetpassword/Akun/"))
			)
		);
		exit("1".$tempArray);
	}
	//sign Up session - valid
	public function getSignUp(){
		//getDataPost
		$nim = $this->isNullPost('daftar-nim')."";
		$this->analysisFilterInput('daftar-nim', $nim);
		//filtering
		if((new ControlMahasiswa(new GateControlModel()))->getDataByNim($nim)->getNextCursor()){	
			exit("03daftar-nim|nim sudah digunakan");	
		}
		$name = $this->isNullPost('daftar-nama')."";
		$this->analysisFilterInput('daftar-nama', $name);
		$email = $this->isNullPost('daftar-apes')."";
		$this->analysisFilterInput('daftar-apes', $email);
		$passwords = $this->isNullPost('daftar-kunci')."";
		$this->analysisFilterInput('daftar-kunci', $passwords);
		$passwordd = $this->isNullPost('daftar-kuncire')."";
		$this->analysisFilterInput('daftar-kuncire', $passwordd);
		if($passwords != $passwordd){
			exit("03daftar-kuncire|password konfirmasi harus sama");
		} 
		$telephone = $this->isNullPost('daftar-ntelp')."";
		$this->analysisFilterInput('daftar-ntelp', $telephone);
		$foto = 'daftar-foto-exe';
		$trans = 'daftar-trans-exe';
		//init return;
		$tempData = array(
			"nim" => null,
			"nama" => null,
			"email" => null,
			"keyword"=> null,
			"nickname" => null,
			"nohp" =>null,
			"namafoto" =>null,
			"namatranskrip" =>null,
			"aktiftahun" =>null
		);
		//enable fitur
		$this->loadLib("ControlMahasiswa");
		$this->mahasiswa->initial($this->inputJaservFilter);
		
		//init temp array
		$tempData['nim'] = $nim;
		$tempData['nickname'] = $nim;
		$tempData['nama'] = $name;
		$tempData['keyword'] = $passwords;
		
		$tempData['email'] = $email; 
		$tempData['nohp'] = $telephone;
		//get tahun akademik aktif account
		$this->loadLib("ControlTime");
		$tempData['aktiftahun'] = (new ControlTime(new GateControlModel()))->getYearNow();
		/*upload-foto*/
		$conPic['upload_path'] = './upload/foto/';	
		$conPic['allowed_types'] = 'png|jpg'; 
		$conPic['file_name'] = $nim."-foto";	
		$conPic['overwrite'] = true; 
		$conPic['remove_spaces'] = true; 
		$conPic['max_size'] = 500;	
		$conPic['max_width'] = 800;	
		$conPic['max_height'] = 1024; 
		$upload = $this->loadLib('upload',true);
		$upload->initialize($conPic);
		if(!$upload->do_upload($foto)){
			if(!isset($_POST[$foto]))
				exit("0anda belum memilih foto");
			else
				exit('0gagal upload foto, format yang didukung png atau jpg, maksimal resolusi 800 x 600 pixel, dengan ukuran file 500kb');		
		}
		$tempData['namafoto'] = $upload->data('file_name');
		/*upload-transkrip*/
		$conTrans['upload_path'] = './upload/transkrip/'; 
		$conTrans['file_name'] = $nim."-transkrip"; 
		$conTrans['allowed_types'] = 'pdf|PDF'; 
		$conTrans['max_size'] = 1024;	
		$conTrans['overwrite'] = true; 
		$conTrans['remove_spaces'] = true;
		$upload->initialize($conTrans);
		if(!$upload->do_upload($trans)){
			if(!isset($_POST[$trans]))
				exit("0anda belum memilih transkrip");
			else
				exit("0gagal upload transkrip, format yang didukung transkrip adalah pdf, dengan maksimum ukuran file 1 mb");		
		}
		$tempData['namatranskrip'] = $upload->data('file_name');
		if((new ControlMahasiswa(new GateControlModel()))->addNewData($tempData))
			exit("1berhasil melakukan pendaftaran, silahkan login");
		else
			exit("0Gagal melakukan pendaftaran");
	}
	//optimized

	//checking
	private function analysisFilterInput($tempNameVariable=null, $tempNameValue=null){
		$temp = $this->getCheck($tempNameVariable, $tempNameValue);
		if(!$temp[0]){
			exit("03".$tempNameVariable."|".$temp[1]);
		}
	}
	private function getCheck($tempNameVariable=null, $tempNameValue=null){
		if(is_null($tempNameVariable)) return array(false,"variable bernilai kosong");
		if(is_null($tempNameValue)) return array(false,"value bernilai kosong");

		$this->mahasiswa->initial($this->inputJaservFilter);
		$this->dosen->initial($this->inputJaservFilter);
		$this->koordinator->initial($this->inputJaservFilter);
		$this->admin->initial($this->inputJaservFilter);
		switch ($tempNameVariable){
			//filter login nim
			case 'login-nim' :
				$tempArray = $this->mahasiswa->getCheckNim($tempNameValue,1);
				if($tempArray[0]){
					return $tempArray;
				}else{
					$tempArray = $this->koordinator->getCheckKodeUsername($tempNameValue,1);
					if($tempArray[0]){
						return $tempArray;
					}else{
						$tempArray = $this->dosen->getCheckNip($tempNameValue,1);
						if($tempArray[0]){
							return $tempArray;
						}else{
							$tempArray = $this->admin->getCheckKodeUsername($tempNameValue,1);
							return $tempArray;
						}
					}
				}
				break;
			//filter daftar nim
			case 'daftar-nim' :
				$tempArray = $this->mahasiswa->getCheckNim($tempNameValue,1);
				if(!$tempArray[0]){
					return $tempArray;
				}
				$this->loadLib('ControlMahasiswa');
				if((new ControlMahasiswa(new GateControlModel()))->getDataByNim($tempNameValue)->getNextCursor()){ //methode repaired
					return array(false,"Nim sudah ada yang menggunakan, mohon gunakan nim yang lain");
				}else{
					return array(true, "nim valid");
				}
				break;
			//filter password login
			case 'login-password' :
				$tempArray = $this->koordinator->getCheckPassword($tempNameValue,1);
				if($tempArray[0])
					return $tempArray;
				else {
					$tempArray = $this->mahasiswa->getCheckPassword($tempNameValue,1);
					return $tempArray;
				}
				break;
			case 'daftar-kunci' :
			case 'daftar-kuncire' :
				return $this->mahasiswa->getCheckPassword($tempNameValue,1);
				break;
			case 'daftar-nama' :
				return $this->mahasiswa->getCheckName($tempNameValue,1);
				break;
			case 'daftar-apes' :
				return $this->mahasiswa->getCheckEmail($tempNameValue,1);
				break;
			case 'daftar-ntelp' :
				return $this->mahasiswa->getCheckNuTelphone($tempNameValue,1);
				break;
			default :
				return array(false, "Kode tidak valid");
				break;
		}
	}
}
/*

private function getCheck(){
		$this->mahasiswa->initial($this->inputJaservFilter);
		$this->dosen->initial($this->inputJaservFilter);
		$this->koordinator->initial($this->inputJaservFilter);
		$this->admin->initial($this->inputJaservFilter);
		$tempNameVariable = $this->isNullPost('variabel');
		$tempNameValue = $this->isNullPost('value');
		switch ($tempNameVariable){
			case 'login-nim' :
				$tempArray = $this->mahasiswa->getCheckNim($tempNameValue,1);
				if($tempArray[0]){
					echo "1".$tempArray[1];
				}else{
					$tempArray = $this->koordinator->getCheckKodeUsername($tempNameValue,1);
					if($tempArray[0]){
						echo "1".$tempArray[1];
					}else{
						$tempArray = $this->dosen->getCheckNip($tempNameValue,1);
						if($tempArray[0]){
							echo "1".$tempArray[1];
						}else{
							$tempArray = $this->admin->getCheckKodeUsername($tempNameValue,1);
							if($tempArray[0]){
								echo "1".$tempArray[1];
							}else{
								echo "0".$tempArray[1];
							} 
						}
					}
				}
				break;
			case 'daftar-nim' :
				$tempArray = $this->mahasiswa->getCheckNim($tempNameValue,1);
				if(!$tempArray[0]){
					echo "0".$tempArray[1];
					return ;
				}
				$this->loadLib('ControlMahasiswa');
				if((new ControlMahasiswa(new GateControlModel()))->getDataByNim($tempNameValue)->getNextCursor()){ //methode repaired
					echo "0Nim sudah ada yang menggunakan, mohon gunakan nim yang lain";
				}else{
					echo "1Valid";
				}
				break;
			case 'login-password' :
				
				$tempArray = $this->koordinator->getCheckPassword($tempNameValue,1);
				if($tempArray[0])
					echo "1".$tempArray[1];
				else {
					$tempArray = $this->mahasiswa->getCheckPassword($tempNameValue,1);
					if($tempArray[0]){
						echo "1".$tempArray[1];
						break;
					}else{
						echo "0".$tempArray[1];
					}
				}
				break;
			case 'daftar-kunci' :
			case 'daftar-kuncire' :
				$this->mahasiswa->getCheckPassword($tempNameValue);
				break;
			case 'daftar-nama' :
				$this->mahasiswa->getCheckName($tempNameValue);
				break;
			case 'daftar-apes' :
				$this->mahasiswa->getCheckEmail($tempNameValue);
				break;
			case 'daftar-ntelp' :
				$this->mahasiswa->getCheckNuTelphone($tempNameValue);
				break;
			case 'login-akun' :
				switch ($tempNameValue) {
					case 'mhs' :
					case 'dos' :
					case 'kor' :
					case 'adm' :
						echo '1valid';
						break;
					default:
						echo '0anda merubah default kategori';
				}
				break;
			default :
				echo "0Kode yang anda kirimkan tidak sesuai, kontak developer";
				break;
		}
	}
*/