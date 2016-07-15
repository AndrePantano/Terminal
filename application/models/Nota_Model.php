<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nota_Model extends CI_Model {
	private $table = "tb_nota";

	public function __construct(){
		parent::__construct();
	}

	// INSERE OS DADOS NA TABELA
	public function create($data){
		return $this->db->insert($this->table,$data);
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

	public function query($str_query){
		
		$query = $this->db->query($str_query);

		if($query->num_rows()){						
			return $query->result_array();
		}else{
			return false;
		}
	}

	public function notas($coluna,$valor){
		$str_query = "SELECT * FROM ".$this->table." WHERE ".$coluna." = ".$valor;
		return $this->query($str_query);
	}

	public function contar_registros_do_usuario($idusuario){
		$str = "SELECT COUNT(idusuario) as quantidade FROM ".$this->table." WHERE idusuario = ".$idusuario;
		$quantidade = $this->query($str);
		return $quantidade[0]["quantidade"];
	}

}