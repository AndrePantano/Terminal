<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_Model extends CI_Model {
	private $table = "tb_usuario";

	public function __construct(){
		parent::__construct();
	}

	// INSERE OS DADOS NA TABELA
	public function create($dados){
		return $this->db->insert($this->table,$dados);
	}

	// ATUALIZA OS DADOS NA TABELA
	public function update($dados){
		$this->db->where(array("idusuario" => $dados["idusuario"]));
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

	public function check_login($dados){
		$str = "SELECT * FROM ".$this->table." WHERE email = '".$dados["email"]."@brado.com.br' AND senha = '".md5($dados["senha"])."' AND ativo = 'sim'";
		return $this->query($str);
	}

	public function check_token($token){
		$str = "SELECT * FROM ".$this->table." WHERE token = '".$token."'";
		return $this->query($str);
	}

	public function all(){
		$str = "SELECT * FROM ".$this->table." JOIN tb_perfil USING(idperfil)";
		return $this->query($str);
	}

}