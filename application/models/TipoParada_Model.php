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
		$this->db->where('idterminal', $this->session->userdata("idterminal"));	
		$this->db->or_where('idterminal', '0');	
		$this->db->order_by("nome_tipo_parada", "asc");
		$query = $this->db->get();

		if($query->num_rows()){						
			return $query->result_array();
		}else{
			return false;
		}
	}

	// INSERE OS DADOS NA TABELA
	public function create($data){

		return $this->db->insert($this->table,$data);
	}

	// EXCLUI OS DADOS NA TABELA
	public function update($dados){
		$this->db->where("idtipo_parada",$dados["idtipo_parada"]);
		return $this->db->update($this->table,$dados);
	}
	
	// ATUALIZA OS DADOS NA TABELA
	public function delete($dados){
		$this->db->where($dados);
		return $this->db->delete($this->table,$dados);
	}

	public function query($str_query){
		//echo $str_query;
		$query = $this->db->query($str_query);

		if($query->num_rows()){						
			return $query->result_array();
		}else{
			return false;
		}
	}

	public function select_all(){
		$str = "SELECT * FROM ".$this->table." LEFT JOIN tb_terminal USING(idterminal)";
		return $this->query($str);
	}

}