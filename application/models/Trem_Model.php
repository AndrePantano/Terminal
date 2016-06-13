<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trem_Model extends CI_Model {
	private $table = "tb_trem";

	public function __construct(){
		parent::__construct();
	}
	
	// INSERE OS DADOS NA TABELA
	public function create($data){
		return $this->db->insert($this->table,$data);
	}

	// ATUALIZA OS DADOS NA TABELA
	public function update($dados){
		$this->db->where(array("idtrem" => $dados["idtrem"]));
		return $this->db->update($this->table,$dados);
	}

	public function all($where,$joins){
		$this->db->select("*");
		$this->db->from($this->table);
				
		if(!is_null($where) ) $this->db->where($where);		
		
		if(!is_null($joins) ) {
			foreach ($joins as $k => $join) {
				$this->db->join($k,$join);
			}
			//$this->db->join("users",$this->table.".created_by_user_id = users.user_id");
		}

		$query = $this->db->get();

		if($query->num_rows()){						
			return $query->result_array();
		}else{
			return false;
		}
	}

	public function em_transito(){
		$str = "SELECT * FROM tb_trem t JOIN tb_previsao USING(idtrem) WHERE chegada_trem is null AND partida_trem is null AND idprevisao = (SELECT MAX(idprevisao) from tb_previsao WHERE idtrem = t.idtrem)";
		$query = $this->db->query($str);
		if($query->num_rows()){						
			return $query->result_array();
		}else{
			return false;
		}
	}
	public function em_operacao(){
		$str = "SELECT * FROM tb_trem WHERE chegada_trem is not null AND partida_trem is null";
		$query = $this->db->query($str);
		if($query->num_rows()){						
			return $query->result_array();
		}else{
			return false;
		}
	}
	public function operados(){
		$str = "SELECT * FROM tb_trem WHERE chegada_trem is not null AND partida_trem is not null";
		$query = $this->db->query($str);
		if($query->num_rows()){						
			return $query->result_array();
		}else{
			return false;
		}
	}
	public function find($id){	
		$where = "idtrem = ".$id;
		$trens = $this->all($where,null);
		if($trens){						
			return $trens[0];
		}else{
			return false;
		}
	}

}