<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class JudulTAObjectDBModel extends ObjectDBModel {

	public function __construct(){
		parent::__construct();
		$this->tempTableName = "judulta";
		$this->tempDataArrayIndexPrimary = array(
			'identifiedjt'
		);

		$this->tempDataArrayCase = array(
			"*"
		);

		$this->tempDataArrayWhere = array(
			"",
			"flag='<|flag|>'",
			"md5(md5(md5(identifiedgu)))='<|nip|>' AND flag='<|flag|>'",
			"md5(md5(md5(identifiedgu)))='<|nip|>'",
			"md5(md5(md5(identifiedjt)))='<|id|>' AND identifiedgu='<|nip|>'",
			"md5(md5(md5(identifiedgu)))='<|id|>'",
		);

		$this->tempCodeOfWhere = array(
			"identifiedjt" => array(
				'kode' => "<%id%>",
				'value' => "<|id|>"
			),
			"identifiedgu" => array(
				'kode' => "<%nip%>",
				'value' => "<|nip|>"
			),
			"judulta" => array(
				'kode' => "<%judul%>",
				'value' => "<|judul|>"
			),
			"description" => array(
				'kode' => "<%descr%>",
				'value' => "<|descr|>"
			),
			"flag" => array(
				'kode' => "<%flag%>",
				'value' => "<|flag|>"
			)

		);

	}

	public function resetValue(){

		parent::resetValue();

	}

	public function getIdentified(){ return $this->getData('identifiedjt'); }
	public function getDosen(){ return $this->getData('identifiedgu'); }
	public function getJudulTA(){ return $this->getData('judulta'); }
	public function getDeskripsi(){ return $this->getData('description'); }
	public function getFlag(){ return $this->getData('flag'); }

	

	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identifiedjt',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDosen($tempData,$tempAsWhere = false){
		return $this->setData('identifiedgu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setJudulTA($tempData,$tempAsWhere = false){
		return $this->setData('judulta',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDeskripsi($tempData,$tempAsWhere = false){
		return $this->setData('description',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setFlag($tempData,$tempAsWhere = false){
		return $this->setData('flag',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}

	
}