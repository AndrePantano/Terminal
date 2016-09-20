<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avaria_Vagao_Model extends CI_Model {
	private $table = "tb_avaria_vagao";

	public function __construct(){
		parent::__construct();
	}

	// INSERE OS DADOS NA TABELA
	public function create($dados){
		return $this->db->insert($this->table,$dados);
	}

	// ATUALIZA OS DADOS NA TABELA
	public function update($dados){
		$this->db->where(array("idavaria" => $dados["idavaria"]));
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
		$str = "SELECT * FROM ".$this->table." JOIN tb_usuario USING(idusuario)  WHERE ".$coluna." =".$valor;
		return $this->query($str);
	}

	public function contar_registros_do_usuario($idusuario){
		$str = "SELECT COUNT(idusuario) as quantidade FROM ".$this->table." WHERE idusuario = ".$idusuario;
		$quantidade = $this->query($str);
		return $quantidade[0]["quantidade"];
	}

}