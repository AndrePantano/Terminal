<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avaria_Conteiner_Model extends CI_Model {
	private $table = "tb_avaria_conteiner";

	public function __construct(){
		parent::__construct();
	}

	// INSERE OS DADOS NA TABELA
	public function create($dados){
		return $this->db->insert($this->table,$dados);
	}

	// ATUALIZA OS DADOS NA TABELA
	public function update($dados){
		$this->db->where(array("idnota" => $dados["idnota"]));
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

	public function avarias($coluna, $valor){
		$str = "SELECT * FROM ".$this->table." JOIN tb_grupo_avaria_conteiner USING (idgrupo_avaria_conteiner) WHERE ".$coluna." =".$valor;
		return $this->query($str);
	}

}