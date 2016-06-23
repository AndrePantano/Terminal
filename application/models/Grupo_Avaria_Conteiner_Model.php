<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupo_Avaria_Conteiner_Model extends CI_Model {
	private $table = "tb_grupo_avaria_conteiner";

	public function __construct(){
		parent::__construct();
	}

	public function query($query){
		$registros = $this->db->query($query);
		if($registros->num_rows()){						
			return $registros->result_array();
		}else{
			return false;
		}
	}

	public function avarias($coluna, $valor){
		$str = "SELECT * FROM ".$this->table." WHERE ".$coluna." =".$valor;
		return $this->query($str);
	}

	public function all(){
		$str = "SELECT * FROM ".$this->table;
		return $this->query($str);
	}
	

}