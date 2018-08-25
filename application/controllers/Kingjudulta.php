<?php
/*
dependencies:
-ControlDosen
*/
if(!defined('BASEPATH'))
	exit("You don't have accsees to this site");

require_once APPPATH."controllers/CI_Controller_Modified.php";

class Kingjudulta extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->dosen))
			exit("#<script>window.location = '".base_url()."Gateinout.jsp'</script>");

		$this->dosen->initial($this->inputJaservFilter);
		$this->loadLib('ControlJudulTA');
		$this->controlJudulTA = new ControlJudulTA($this->gateControlModel);
	}
	public function getAllData(){
		$tempDosen = $this->loginFilter->getIdentifiedActive();
		$tempDosen = md5(md5($tempDosen));
		$tempObject = $this->controlJudulTA->getAllData($tempDosen);
		$rest = array();
		if($tempObject){
			while($tempObject->getNextCursor()){
				array_push($rest, array(
					"id" => md5(md5($tempObject->getIdentified())),
					"judul" => $tempObject->getJudulTA(),
					"deskripsi" => $tempObject->getDeskripsi(),
					"status" => $tempObject->getFlag(),
				));
			}
		}
		echo json_encode(array("error"=>true, "message"=>(count($rest) > 0?"Data ditemukan":"Data tidak ditemukan"), "data"=>$rest ));
	}
	//controller add judul ta
	public function addData(){

		$data = array(
			"identifiedgu" => $this->loginFilter->getIdentifiedActive(),
			"judulta" => "Pengenalan Wajah",
			"deskripsi" => "Wajib dikerjakan dalam 2 Semester",
		);
		$tempObject = $this->controlJudulTA->addJudul($data);
		if($tempObject)
			echo json_encode(array("error"=>true, "message"=> "Berhasil menambahkan judul"));
		else
			echo json_encode(array("error"=>false, "message"=> "Terjadi kesalahan saat menambahkan judul"));
	}
	//step 1 OK
	//controller delete judul ta
	public function deleteData(){

		$data = array(
			"identified" => "34502577c7a4f7b982cf7a4fae68ffa1",
			"identifiedgu" => $this->loginFilter->getIdentifiedActive()

		);
		$tempObject = $this->controlJudulTA->deleteJudul($data);
		if($tempObject)
			echo json_encode(array("error"=>true, "message"=> "Berhasil menghapus judul"));
		else
			echo json_encode(array("error"=>false, "message"=> "Terjadi kesalahan saat menghapus judul"));
	}
	//step 1 OK
	//controller update judul ta
	public function updateData(){

		$data = array(
			"identified" => "05ad9340b5a0ba95d8fbd68fd1e4c3fb",//"3babdd9b21ffc39bab4216c6c758ec51",
			"identifiedgu" => $this->loginFilter->getIdentifiedActive(),
			"judulta" => "Ini Judul Baru",
			"deskripsi" => "Ini Deskripsi baru",
		);
		$tempObject = $this->controlJudulTA->updateJudul($data);
		if($tempObject)
			echo json_encode(array("error"=>true, "message"=> "Berhasil memperbaharui judul"));
		else
			echo json_encode(array("error"=>false, "message"=> "Terjadi kesalahan saat memperbaharui judul"));
	}
	public function activeOrNotData(){

		$data = array(
			"identified" => "05ad9340b5a0ba95d8fbd68fd1e4c3fb",//"3babdd9b21ffc39bab4216c6c758ec51",
			"identifiedgu" => $this->loginFilter->getIdentifiedActive(),
			"flag" => 1
		);
		$tempObject = $this->controlJudulTA->getData($data);
		if(!$tempObject) {echo json_encode(array("error"=>false, "message"=> "Judul tidak ditemukan")); return;}
		if(!$tempObject->getNextCursor()) {echo json_encode(array("error"=>false, "message"=> "Judul tidak ditemukan")); return;}

		
		if(intval($tempObject->getFlag()) == 1) $data['flag'] = 2;


		$tempObject = $this->controlJudulTA->updateJudul($data);
		if($tempObject)
			echo json_encode(array("error"=>true, "message"=> "Berhasil mengubah ketersediaan judul"));
		else
			echo json_encode(array("error"=>false, "message"=> "Terjadi kesalahan saat memperbaharui ketersediaan judul"));
	}
}

