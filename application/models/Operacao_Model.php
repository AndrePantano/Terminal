<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operacao_Model extends CI_Model {
	private $table = "tb_operacao";

	public function __construct(){
		parent::__construct();
	}

	// INSERE OS DADOS NA TABELA
	public function create($dados){
		$dados = $this->acrescentar_metas($dados);
		$dados = $this->acrescentar_tarifa($dados);
		return $this->db->insert($this->table,$dados);
	}

	// ATUALIZA OS DADOS NA TABELA
	public function update($dados){
		$dados = $this->acrescentar_metas($dados);
		$dados = $this->acrescentar_tarifa($dados);
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

	public function operacoes($coluna, $valor){
		$str = "SELECT * FROM ".$this->table." WHERE ".$coluna." =".$valor;
		return $this->query($str);
	}

	public function acrescentar_metas($dados){
		$this->load->model("Meta_Model");
	    $metas = $this->Meta_Model->all();

	    if($metas){
	     foreach ($metas as $meta) {
	        if($meta["nome_meta"] == "all") $dados["meta_all"] = $meta["valor_meta"];
	        if($meta["nome_meta"] == "operação") $dados["meta_operacao"] = $meta["valor_meta"];
	      } 
	    }

	    return $dados;
	}

	public function acrescentar_tarifa($dados){
		$this->load->model("Tarifa_Model");
	    $tarifa = $this->Tarifa_Model->tarifa_atual();

	    if($tarifa){
			$dados["tarifa"] = $tarifa["valor_tarifa"];	        
	    }

	    return $dados;
	}
}