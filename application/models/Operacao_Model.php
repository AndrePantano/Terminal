<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operacao_Model extends CI_Model {
	private $table = "tb_operacao";

	public function __construct(){
		parent::__construct();
	}

	// INSERE OS DADOS NA TABELA
	public function create($data){
		return $this->db->insert($this->table,$data);
	}

	// ATUALIZA OS DADOS NA TABELA
	public function update($dados){
		$this->db->where(array("idoperacao" => $dados["idoperacao"]));
		return $this->db->update($this->table,$dados);
	}

	public function delete($dados){
		$this->db->where($dados);
		$this->db->delete($this->table);
	}

	public function query($query){
		$registros = $this->db->query($query);
		if($registros->num_rows()){						
			return $registros->result_array();
		}else{
			return false;
		}
	}
}