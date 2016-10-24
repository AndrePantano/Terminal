<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terminal_Model extends CI_Model {
	private $table = "tb_terminal";

	public function __construct(){
		parent::__construct();
	}

	// INSERE OS DADOS NA TABELA
	public function create($dados){
		
		return $this->db->insert($this->table,$dados);
	}

	// ATUALIZA OS DADOS NA TABELA
	public function update($dados){
		$this->db->where(array("idterminal" => $dados["idterminal"]));
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

	public function all(){
		$str = "SELECT * FROM ".$this->table;
		$all = $this->query($str);
		if(!$all)
      		$all = array();
      	return $all;
	}

}