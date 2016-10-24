<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operacao_Model extends CI_Model {
	private $table = "tb_operacao";

	public function __construct(){
		parent::__construct();
	}

	// INSERE OS DADOS NA TABELA
	public function create($dados){
		$dados = $this->acrescentar_meta_e_tarifa($dados);
		return $this->db->insert($this->table,$dados);
	}

	// ATUALIZA OS DADOS NA TABELA
	public function update($dados){
		$dados = $this->acrescentar_meta_e_tarifa($dados);
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
		$str = "SELECT * FROM ".$this->table." JOIN tb_usuario USING(idusuario) WHERE ".$coluna." =".$valor;
		return $this->query($str);
	}

	public function acrescentar_meta_e_tarifa($dados){
		$this->load->model("Terminal_Model");
	    $terminais = $this->Terminal_Model->all();

	    $dados["meta_all"] = 12;
	    
		if($terminais){
			foreach ($terminais as $terminal) {
				if($terminal["idterminal"] == $this->session->userdata("idterminal")){
					$dados["meta_operacao"] = $terminal["meta_operacao"];
					$dados["tarifa"] = $terminal["valor_tarifa"];
				}
			}
		}

	    return $dados;
	}
	
	public function contar_registros_do_usuario($idusuario){
		$str = "SELECT COUNT(idusuario) as quantidade FROM ".$this->table." WHERE idusuario = ".$idusuario;
		$quantidade = $this->query($str);
		return $quantidade[0]["quantidade"];
	}
}