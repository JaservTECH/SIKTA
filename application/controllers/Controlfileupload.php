<?php
/*
dependencies:
-Koordinator
-ControlFile
*/
if(!defined('BASEPATH')) exit('you dont have permition');
	require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Controlfileupload extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->koordinator))
			exit("#<script>window.location = '".base_url()."Gateinout.jsp'</script>");
	}
	public function addNewRecord(){
		$title = htmlspecialchars($this->input->post('file-data-keterangan-name'));
		$id1 = date("Y-m-d");
		$id2 = date("H:i:s");
		$id=$id1." ".$id2;
		$data = str_ireplace("-",":",$id1."".$id2);
		//exit("0".$data);
		$this->load->library('upload',array(
			'upload_path' => "./upload/file/",
			"allowed_types" => "doc|DOC|pdf|PDF|xls|XLS|docx|DOCX|xlsx|XLSX",
			"max_size" => 10240,
			"overwrite" => true,
			"file_name" => md5($id1).md5($id2)
		));
		//$this->upload->initialize($conPic);
		if(!$this->upload->do_upload('file-data-name')){
			exit('0Gagal, format yang didukung .pdf .doc .docx .xls .xlsx , maksimal dengan ukuran file 10MB');		
		}
		$filename = $this->upload->data('file_name');
		$this->loadLib('ControlFile');
		if((new ControlFile($this->gateControlModel))->addFile(array("detail"=>$title,"namadata"=>$filename))) exit("1File berhasil ditambahkan");
		exit("0File gagal di unggah");
	}
	public function updateRecord(){
		if($this->isNullPost('kode') != 'JASERVCONTROL') exit("0anda melakukan debuging");
		$title = htmlspecialchars($this->input->post('content'));
		$id = $this->isNullPost('ID');
		$id = str_ireplace(sha1(" ")," ",$id);
		$id = str_ireplace(sha1("-"),"-",$id);
		$id = str_ireplace(sha1(":"),":",$id);
		$this->loadLib('ControlFile');
		//exit("0".$id);
		if((new ControlFile($this->gateControlModel))->updateFile(array("detail"=>$title,"identified"=>$id))) exit("1Informasi file berhasil dirubah");
		exit("0Detail file gagal di rubah");
		
	}
	public function getListRecord(){
		if($this->isNullPost('kode') != 'JASERVCONTROL') exit("0anda melakukan debuging");
		$this->loadLib('ControlFile');
		$tempObjectDB = (new ControlFile($this->gateControlModel))->getAllData();
		if($tempObjectDB->getCountData() > 0){
			$i=1;
			echo "1";
			while($tempObjectDB->getNextCursor()){
				$id = str_ireplace(" ",sha1(" "),$tempObjectDB->getIdentified());
				$id = str_ireplace("-",sha1("-"),$id);
				$id = str_ireplace(":",sha1(":"),$id);
				
				echo "
				<tr>
					<td style='text-align : center;'>
						".$i."
					</td>
					<td>
						".$tempObjectDB->getDetail()."
					</td>
					<td style='text-align : center;'>
						<div>
							<button onclick='openURL(this)' data-target-url='".base_url()."/upload/file/".$tempObjectDB->getNamaData()."' class='btn btn-clean btn-info'><i class='icon-eye-open'> tampilkan</i></button>&nbsp;&nbsp;
							<button onclick='editFileKeterangan(".'"'.$id.'"'.",this);' title='Ubah keterangan file' class='btn btn-clean btn-primary'><i class='icon-edit'> ubah</i></button>&nbsp;&nbsp;
							<button onclick='hapusFile(".'"'.$id.'"'.",this);' title='Hilangkan file' class='btn btn-clean btn-warning'><i class='icon-remove'> hapus</i></button>
						</div>
					</td>
				</tr>";
				$i++;
			}
		}else{
			echo "1<tr><td>-</td><td>-</td><td>-</td></tr>";
		}
	}
	public function removeRecord(){
		if($this->isNullPost('kode') != 'JASERVCONTROL') exit("0anda melakukan debuging");
		$id = $this->isNullPost('ID');
		$id = str_ireplace(sha1(" ")," ",$id);
		$id = str_ireplace(sha1("-"),"-",$id);
		$id = str_ireplace(sha1(":"),":",$id);
		$this->loadLib('ControlFile');
		if((new ControlFile($this->gateControlModel))->deleteFile($id)) exit("1File berhasil dihapus");
		exit("0File gagal di hapus");
	}
}