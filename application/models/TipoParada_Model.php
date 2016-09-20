<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TipoParada_Model extends CI_Model {
	private $table = "tb_tipo_parada";

	public function __construct(){
		parent::__construct();
	}

	public function all(){
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->order_by("nome_tipo_parada", "asc");
		$query = $this->db->get();

		if($query->num_rows()){						
			return $query->result_array();
		}else{
			return false;
		}
	}

}