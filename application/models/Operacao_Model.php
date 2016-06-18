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

	public function all($where,$joins){
		$this->db->select("*");
		$this->db->from($this->table);
				
		if(!is_null($where) ) $this->db->where($where);		
		
		if(!is_null($joins) ) {
			foreach ($joins as $k => $join) {
				$this->db->join($k,$join);
			}
		}

		$query = $this->db->get();

		if($query->num_rows()){						
			return $query->result_array();
		}else{
			return false;
		}
	}

	public function find($id){	
		$where = "idoperacao = ".$id;
		$registros = $this->all($where,null);
		if($registros){						
			return $registros[0];
		}else{
			return false;
		}
	}

}