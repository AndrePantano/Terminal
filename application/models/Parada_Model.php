<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parada_Model extends CI_Model {
	private $table = "tb_parada";

	public function __construct(){
		parent::__construct();
	}

	// INSERE OS DADOS NA TABELA
	public function create($data){
		return $this->db->insert($this->table,$data);
	}

	// ATUALIZA OS DADOS NA TABELA
	public function update($dados){
		$this->db->where(array("idparada" => $dados["idparada"]));
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

	public function paradas($coluna,$valor){
		$str_query = "SELECT *,"
			." DATE_FORMAT(TIMEDIFF(fim_parada,inicio_parada),'%H:%i') as duracao,"
			." TIMESTAMPDIFF(MINUTE,inicio_parada,fim_parada) as t_parada"
			." FROM tb_parada"
			." JOIN tb_tipo_parada USING(idtipo_parada)"
			." JOIN tb_usuario USING(idusuario)"
			." WHERE ".$coluna." = ".$valor
			." ORDER BY inicio_parada ASC";
		return $this->query($str_query);
	}

	public function delete($dados){
		$this->db->where($dados);
		$this->db->delete($this->table);
	}

	public function contar_registros_do_usuario($idusuario){
		$str = "SELECT COUNT(idusuario) as quantidade FROM ".$this->table." WHERE idusuario = ".$idusuario;
		$quantidade = $this->query($str);
		return $quantidade[0]["quantidade"];
	}

	public function contar_registros_tipo_parada($idtipo_parada){
		$str = "SELECT COUNT(idtipo_parada) as quantidade FROM ".$this->table." WHERE idtipo_parada = ".$idtipo_parada;
		$quantidade = $this->query($str);
		return $quantidade[0]["quantidade"];
	}
}
