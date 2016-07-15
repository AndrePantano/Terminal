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

	// EXCLUI OS DADOS NA TABELA
	public function update($dados){
		$this->db->where("idtrem",$dados["idtrem"]);
		return $this->db->update($this->table,$dados);
	}
	
	// ATUALIZA OS DADOS NA TABELA
	public function delete($dados){
		$this->db->where($dados);
		return $this->db->delete($this->table,$dados);
	}

	public function em_transito(){
		$str = "SELECT * FROM tb_trem t JOIN tb_previsao_chegada USING(idtrem) WHERE chegada_trem is null AND partida_trem is null AND idprevisao = (SELECT MAX(idprevisao) from tb_previsao_chegada WHERE idtrem = t.idtrem)";
		return $this->query($str);
	}

	public function em_operacao(){
		$str = "SELECT * FROM tb_trem WHERE chegada_trem is not null AND partida_trem is null";
		return $this->query($str);
	}
	public function operados(){
		$str = "SELECT * FROM tb_trem WHERE chegada_trem is not null AND partida_trem is not null";
		return $this->query($str);
	}

	public function query($str_query){
		echo $str_query;
		$query = $this->db->query($str_query);

		if($query->num_rows()){						
			return $query->result_array();
		}else{
			return false;
		}
	}
	public function trem($id){
		
		$inicio = "chegada_trem";
		$fim = "partida_trem";
		$diff_meses = "TIMESTAMPDIFF(MONTH, ".$inicio.", ".$fim.") MONTH";
		$diff_dias = "TIMESTAMPDIFF(DAY,  ".$inicio.", ".$fim.") DAY";
		$diff_horas = "TIMESTAMPDIFF(HOUR,  ".$inicio.", ".$fim.") HOUR";

		$str_query = "SELECT * ,"
		." TIMESTAMPDIFF(DAY, ".$inicio." + INTERVAL ".$diff_meses.",".$fim.") AS dias ,"
		." TIMESTAMPDIFF(HOUR, ".$inicio." + INTERVAL ".$diff_dias.",".$fim.") AS horas ,"
		." TIMESTAMPDIFF(MINUTE, ".$inicio." + INTERVAL ".$diff_horas.",".$fim.") AS minutos"
		." FROM tb_trem"
		." WHERE idtrem = ".$id;

		$trens = $this->query($str_query);

		if($trens){			
			return $trens[0];
		}else{
			return false;
		}
	}

	public function trens($coluna,$valor){
		$str_query = "SELECT * FROM ".$this->table." WHERE ".$coluna." = ".$valor;
		return $this->query($str_query);
	}

	public function contar_registros_do_usuario($idusuario){
		$str = "SELECT COUNT(idusuario) as quantidade FROM ".$this->table." WHERE idusuario = ".$idusuario;
		$quantidade = $this->query($str);
		return $quantidade[0]["quantidade"];
	}
}