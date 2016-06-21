<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Previsao_Model extends CI_Model {
	private $table = "tb_previsao";

	public function __construct(){
		parent::__construct();
	}

	// INSERE OS DADOS NA TABELA
	public function create($data){
		return $this->db->insert($this->table,$data);
	}

	// ATUALIZA OS DADOS NA TABELA
	public function update($dados){
		$this->db->where(array("idprevisao" => $dados["idprevisao"]));
		return $this->db->update($this->table,$dados);
	}

	public function query($str_query){
		
		$query = $this->db->query($str_query);

		if($query->num_rows()){						
			return $query->result_array();
		}else{
			return false;
		}
	}

	public function delete($dados){
		$this->db->where($dados);
		$this->db->delete($this->table);
	}
}