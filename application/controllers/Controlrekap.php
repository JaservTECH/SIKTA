<?php
if(!defined('BASEPATH')) exit("");
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
/*
dependencie:
-Koordinator
-ControlDosen
-ControlRegistrasi
-ControlSidang
-ControlTime
*/
class Controlrekap extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper('url');
		$this->loadLib('ControlTime');
		$this->koordinator->initial($this->inputJaservFilter);
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->koordinator))
			exit("#<script>window.location = '".base_url()."Gateinout.jsp'</script>");
	}
	public function getLayoutRekap(){
		echo "1";
		$srt['srt'] = (new ControlTime($this->gateControlModel))->getYearNow();
		$this->load->view("Bodyright/Controlroom/Rekap",$srt);
	}
	public function getListDataRekap(){
		$kode = $this->isNullPost('kode');
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		if($this->input->post('page') === NULL)
			$page = 1;
		else{		
			$page = intval($this->isNullPost('page'));
			if($page < 1)
				$page = 1;	
		}
		$key = null;
		if($this->input->post('key') === NULL)
			$key = "*";
		else if($this->isNullPost('key') == "" || $this->isNullPost('key') == " "){
			$key = "*";
		}else{
			if(!$this->inputJaservFilter->nameLevelFiltering($this->isNullPost('key'))[0]){
				echo "0Kata kunci harus berupa bagian nama dari seseorang";
				return;
			}else
				$key = $this->isNullPost('key');
		}
		$srt = (new ControlTime($this->gateControlModel))->getYearNow();
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlSidang');
		$this->loadLib('ControlRegistrasi');
		if($this->input->post('year') !== NULL){
			$srts = intval($this->isNullPost('year'))."";
			if(strlen($srts) == 5 || strlen($srts) == 4){
				$srt = $srts;
			}
		}
		$controlSidang = new ControlSidang($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$rest="";
		$i=1;
		$n = 1;
		$z = 1;
		$koko = 0;
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getAllData();
		while($tempObjectDB->getNextCursor()){
			if($key == "*" || !is_bool(strpos(strtolower($tempObjectDB->getNama()),strtolower($key)))){
				if($n <= 15 && $z == $page){
					//kode
					$rest.="<tr>";
					$rest.="<td style='text-align : center;'>".$i."</td>";
					$rest.="<td style='text-align : center;'>".$tempObjectDB->getNip()."</td>";
					$rest.="<td>".$tempObjectDB->getNama()."</td>";
					$tempObjectDBD = $controlRegistrasi->getAllDataByDosen($srt,$tempObjectDB->getIdentified());
					$totalUji = 0;
					$tempObjectDBT = $controlSidang->isTesterOfMahasiswa(1,$srt,$tempObjectDB->getIdentified());
					$totalUji += $tempObjectDBT->getCountData();
					$tempObjectDBT = $controlSidang->isTesterOfMahasiswa(2,$srt,$tempObjectDB->getIdentified());
					$totalUji += $tempObjectDBT->getCountData();
					$tempObjectDBT = $controlSidang->isTesterOfMahasiswa(3,$srt,$tempObjectDB->getIdentified());
					$totalUji += $tempObjectDBT->getCountData();
					
					$totalLulus = 0;
					while($tempObjectDBD->getNextCursor()){
						$tempSidang = $controlSidang->getDataByMahasiswa($srt,$tempObjectDBD->getTableStack(1)->getMahasiswa());
						if($tempSidang->getNextCursor()){
							if($tempSidang->getNilai() < 3) $totalLulus++;
						}
					}
					$semester = 2;
					//echo "total = ".$totalLulus."<br>";
					if(strlen($srt) == 5)
						$semester = 1;
					$rest.="<td style='text-align : center;'>";
					$rest.="<button title='lihat mahasiswa bimbingan' class='btn btn-info btn-clean' onclick='showTentor(".'"'.$tempObjectDB->getNip().'"'.")'><span class='icon-eye-open'> bimbingan(".$tempObjectDBD->getCountData().")</span></button>";
					//$rest.="<input type='button' value='lihat (".$tempObjectDBD->getCountData().")' class='btn btn-info' onclick='showTentor(".'"'.$tempObjectDB->getNip().'"'.")'>";
					$rest.="</td>";
					$rest.="<td style='text-align : center;'>";
					$rest.="<button title='lihat mahasiswa yang diuji' class='btn btn-info btn-clean' onclick='showUji(".'"'.$tempObjectDB->getNip().'"'.")'><span class='icon-eye-open'> menguji(".$totalUji.")</span></button>";
					//$rest.="<input type='button' value='lihat (".$totalUji.")' class='btn btn-info' onclick='showUji(".'"'.$tempObjectDB->getNip().'"'.")'>";
					$rest.="</td>";
					$rest.="<td style='text-align : center;'>";
					$rest.="<button title='lihat mahasiswa yang mendaftar sidang' class='btn btn-info btn-clean' onclick='showLulus(".'"'.$tempObjectDB->getNip().'"'.")'><span class='icon-eye-open'> lulus(".$totalLulus.")</span></button>";
					//$rest.="<input type='button' value='lihat (".$totalLulus.")' class='btn btn-info' onclick='showLulus(".'"'.$tempObjectDB->getNip().'"'.")'>";
					$rest.="</td>";
					//$rest.="<td style='text-align : center;'>".$semester."</td>";
					$rest.="</tr>";
					$koko ++;
					$n++;
				}else if($n == 15 && $z < $page){
					$n = 1;
					$z++;
				}else{
					$n++;
				}
				$i++;
			}
		}
		$result['left'] = 1;
		$result['right'] = 1;
		if($page == 1){
			if($koko == 15){				
				$result['left'] = 0;
				$result['right'] = 1;
			}else{				
				$result['left'] = 0;
				$result['right'] = 0;
			}
		}else{
			if($koko == 15){				
				$result['left'] = 1;
				$result['right'] = 1;
			}
			else{				
				$result['left'] = 1;
				$result['right'] = 0;
			}
		}
		if($i == 1)
			$rest.="<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>";
		$result['output'] = $rest; 
		echo "1".json_encode($result);
	}
	public function getJsonJumlahLulus(){/* 
		$_POST['kode'] = 'JASERVCONTROL';
		$_POST['year'] = '20171';
		$_POST['nip'] = '198203092006041002'; */
		$kode = $this->isNullPost('kode');
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		$nip = $this->isNullPost('nip');
		if(!$this->koordinator->getCheckNip($nip,1))
			exit("0Anda melakukan debuging");
		$srt = (new ControlTime($this->gateControlModel))->getYearNow();
		if($this->input->post('year') !== NULL){
			$srts = intval($this->isNullPost('year'))."";
			if(strlen($srts) == 5 || strlen($srts) == 4){
				$srt = $srts;
			}
		}
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getDataByNip($nip,null);
		if(!$tempObjectDB->getNextCursor()) exit("0maaf nip ini tidak terdaftar");
		$tempObjectDBD = (new ControlRegistrasi($this->gateControlModel))->getAllDataByDosen($srt,$tempObjectDB->getIdentified(),1,true,true);
		$temp2="";
		$temp=0;
		if($tempObjectDBD){
			while($tempObjectDBD->getNextCursor()){
				$tempObjectDBE = $tempObjectDBD->getTableStack(2);
				$temp++;
				$temp2.='["'.$tempObjectDBE->getNama().'",'.$tempObjectDBE->getNim().',"upload/foto/'.$tempObjectDBE->getNamaFoto().'"],';					
			}
		}
		if($temp2 != "")
			$temp2 = substr($temp2, 0,strlen($temp2)-1);
		$json = '{"data": ['.$temp;
		$json .= ",[";
		$json .= $temp2;
		$json .= "]]}";
		echo "1".$json;
	}
	//optimized
	//get list mahasiswa yang diuji, baik dengan status ketua penguji maupun 
	public function getJsonJumlahMenguji(){
		$kode = $this->isNullPost('kode');
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		$nip = $this->isNullPost('nip');
		if(!$this->koordinator->getCheckNip($nip,1))
			exit("0Anda melakukan debuging");
		$srt = (new ControlTime($this->gateControlModel))->getYearNow();
		if($this->input->post('year') !== NULL){
			$srts = intval($this->isNullPost('year'))."";
			if(strlen($srts) == 5 || strlen($srts) == 4){
				$srt = $srts;
			}
		}
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlSidang');
		$temp2="";
		$temp=0;
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getDataByNip($nip,null);
		$controlSidang = new ControlSidang($this->gateControlModel);
		if(!$tempObjectDB->getNextCursor()) exit("0maaf nip ini tidak terdaftar");
		$tempObjectDBD = $controlSidang->isTesterOfMahasiswa(1,$srt,$tempObjectDB->getIdentified(),1,true);
		while($tempObjectDBD->getNextCursor()){
			$tempObjectDBE = $tempObjectDBD->getTableStack(1);
			$temp2.='["'.$tempObjectDBE->getNama().'",'.$tempObjectDBE->getNim().',"upload/foto/'.$tempObjectDBE->getNamaFoto().'"],';	
			$temp++;
		}
		$tempObjectDBD = $controlSidang->isTesterOfMahasiswa(2,$srt,$tempObjectDB->getIdentified(),1,true);
		while($tempObjectDBD->getNextCursor()){
			$tempObjectDBE = $tempObjectDBD->getTableStack(1);
			$temp2.='["'.$tempObjectDBE->getNama().'",'.$tempObjectDBE->getNim().',"upload/foto/'.$tempObjectDBE->getNamaFoto().'"],';	
			$temp++;
		}
		$tempObjectDBD = $controlSidang->isTesterOfMahasiswa(3,$srt,$tempObjectDB->getIdentified(),1,true);
		while($tempObjectDBD->getNextCursor()){
			$tempObjectDBE = $tempObjectDBD->getTableStack(1);
			$temp2.='["'.$tempObjectDBE->getNama().'",'.$tempObjectDBE->getNim().',"upload/foto/'.$tempObjectDBE->getNamaFoto().'"],';	
			$temp++;
		}
		if($temp2 != "")
			$temp2 = substr($temp2, 0,strlen($temp2)-1);
		$json = '{"data": ['.$temp;
		$json .= ",[";
		$json .= $temp2;
		$json .= "]]}";
		echo "1".$json;
	}
	//optimized - fix
	public function getJsonJumlahBimbingan(){
		$kode = $this->isNullPost('kode');
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		$nip = $this->isNullPost('nip');
		if(!$this->koordinator->getCheckNip($nip,1))
			exit("0Anda melakukan debuging");
		$srt = (new ControlTime($this->gateControlModel))->getYearNow();
		if($this->input->post('year') !== NULL){
			$srts = intval($this->isNullPost('year'))."";
			if(strlen($srts) == 5 || strlen($srts) == 4){
				$srt = $srts;
			}
		}
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getDataByNip($nip,null);
		if(!$tempObjectDB->getNextCursor()) exit("0maaf nip ini tidak terdaftar");
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getDataByNip($nip);
		if(!$tempObjectDB->getNextCursor()) exit("0maaf nip ini tidak terdaftar");
		$tempObjectDBD = (new ControlRegistrasi($this->gateControlModel))->getAllDataByDosen($srt,$tempObjectDB->getIdentified(),1,true);
		//echo $srt."";
		$temp2="";
		$temp=0;
		if($tempObjectDBD){
			while($tempObjectDBD->getNextCursor()){
				$tempObjectDBT = $tempObjectDBD->getTableStack(2);
				$temp2.='["'.$tempObjectDBT->getNama().'",'.$tempObjectDBT->getNim().',"upload/foto/'.$tempObjectDBT->getNamaFoto().'"],';	
				$temp++;
			}
		}
		if($temp2 != "")
			$temp2 = substr($temp2, 0,strlen($temp2)-1);
		$json = '{"data": ['.$temp;
		$json .= ",[";
		$json .= $temp2;
		$json .= "]]}";
		echo "1".$json;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function getDataWithExcel($year=null){
		$srt = (new ControlTime($this->gateControlModel))->getYearNow();
		if($year !== NULL){
			$srts = intval($year)."";
			if(strlen($srts) == 5 || strlen($srts) == 4){
				$srt = $srts;
			}
		}
		$this->load->library("phpexcel");
		 //membuat objek
		$objPHPExcel = new Phpexcel();
		$listTitle = array(
			'No',
			'Nip',
			'Nama',
			'Jumlah bimbingan',
			'Jumlah Menguji',
			'Jumlah Lulusan',
			'Semester'
		);
		// Nama Field Baris Pertama
		$col = 1;
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
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "Rekapitulasi Tahun Ajaran ".$year." ".($year+1)." Semester ".$semester);
		$objPHPExcel->getActiveSheet()->mergeCells('B2:H2');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(21);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(38);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		//set font bold
		$objPHPExcel->getActiveSheet()->getStyle("B2")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("B4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("C4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("D4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("E4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("F4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("G4")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("H4")->getFont()->setBold(true);
		//set text align center
		$objPHPExcel->getActiveSheet()->getStyle("B2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("B4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("C4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("D4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("E4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("F4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("G4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("H4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		foreach ($listTitle as $field)
		{
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 4, $field);
			$col++;
		}
		$i=1;
		$row = 5;
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlSidang');
		$this->loadLib('ControlRegistrasi');
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getAllData();
		$controlSidang = new ControlSidang($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		
		while($tempObjectDB->getNextCursor()){
			$objPHPExcel->getActiveSheet()->getStyle("B".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle("C".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//$objPHPExcel->getActiveSheet()->getStyle("D4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle("E".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle("F".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle("G".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle("H".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $i);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $tempObjectDB->getNip());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $tempObjectDB->getNama());
			$tempObjectDBD = $controlRegistrasi->getAllDataByDosen($srt,$tempObjectDB->getIdentified());
			$totalUji = 0;
			$tempObjectDBT = $controlSidang->isTesterOfMahasiswa(1,$srt,$tempObjectDB->getIdentified());
			$totalUji += intval($tempObjectDBT->getCountData());
			$tempObjectDBT = $controlSidang->isTesterOfMahasiswa(2,$srt,$tempObjectDB->getIdentified());
			$totalUji += intval($tempObjectDBT->getCountData());
			$tempObjectDBT = $controlSidang->isTesterOfMahasiswa(3,$srt,$tempObjectDB->getIdentified());
			$totalUji += intval($tempObjectDBT->getCountData());
			$totalLulus = 0;
			while($tempObjectDBD->getNextCursor()){
				if($controlSidang->getDataByMahasiswa($srt,$tempObjectDBD->getTableStack(1)->getMahasiswa())->getNextCursor())
					$totalLulus++;
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $tempObjectDBD->getCountData());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $totalUji);	
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $totalLulus);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $semester);
						
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
		header('Content-Disposition: attachment;filename="Data-Rekapitulasi-'.$year."-".($year+1)."-".$semester.'.xlsx"');

		//Download
		$objWriter->save("php://output");
	}
	
}