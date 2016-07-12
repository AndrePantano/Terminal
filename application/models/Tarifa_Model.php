<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarifa_Model extends CI_Model {
	private $table = "tb_tarifa";

	public function __construct(){
		parent::__construct();
	}

	// INSERE OS DADOS NA TABELA
	public function create($data){
		return $this->db->insert($this->table,$data);
	}

	// ATUALIZA OS DADOS NA TABELA
	public function update($dados){
		$this->db->where(array("idtarifa" => $dados["idtarifa"]));
		return $this->db->update($this->table,$dados);
	}

	public function delete($dados){
		$this->db->where($dados);
		$this->db->delete($this->table);
	}

	public function query($str_query){
		
		$query = $this->db->query($str_query);

		if($query->num_rows()){						
			return $query->result_array();
		}else{
			return false;
		}
	}

	public function tarifa_atual(){
		$str_query = "SELECT * FROM ".$this->table." ORDER BY criado_em DESC";
		$registros = $this->query($str_query);
		return $registros[0];
	}

	public function all(){
		$str_query = "SELECT * FROM ".$this->table;
		return $this->query($str_query);
	}

}