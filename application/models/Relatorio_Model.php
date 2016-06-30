<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function query($str_query){
		
		$query = $this->db->query($str_query);

		if($query->num_rows()){						
			return $query->result_array();
		}else{
			return false;
		}
	}

	// RELATORIO DE ENCONTE X FATURAMENTO ALL
	public function rel_01($inicio,$fim){

		// RETORNA FALSE SE O INICIO FOR MAIOR QUE O FIM
		if($inicio > $fim) return false;

		$str = "SELECT *," 
			." idtrem,"
			." idoperacao,"
			." prefixo_trem, "
			." encoste_linha,"
			." faturamento_all, "
			." TIMESTAMPDIFF(HOUR,encoste_linha,faturamento_all) AS duracao, "
			." meta_all, "
			." meta_operacao FROM `tb_operacao` JOIN tb_trem USING(idtrem)"
			." WHERE "
				."encoste_linha"
					." BETWEEN "
						."'".date("Y-m-d",strtotime($inicio))."'"
						." AND "
						."'".date("Y-m-d",strtotime($fim))."'"
						." AND "
						." TIMESTAMPDIFF(HOUR,encoste_linha,faturamento_all) IS NOT NULL";

		$operacoes = $this->query($str);

		if($operacoes){

			$dados = array();
			$labels = array();
			$meta_all = array();
			$meta_operacao = array();
			$duracao = array();
			$excedidas_all = $excedidas_operacao = 0;

			foreach ($operacoes as $k => $operacao) {
				
				$prefixo = "";
				
				if( $k > 0 && $operacao["idtrem"] == $operacoes[$k - 1]["idtrem"]){
					$prefixo = $operacao["prefixo_trem"]." (2)";
				}else{
					$prefixo = $operacao["prefixo_trem"]." (1)";
				}

				array_push($labels, $prefixo." - ".date("d/m H:i",strtotime($operacao["encoste_linha"])));
				array_push($duracao,$operacao["duracao"]);
				array_push($meta_all,$operacao["meta_all"]);
				array_push($meta_operacao,$operacao["meta_operacao"]);

				if($operacao["duracao"] > $operacao["meta_all"]) $excedidas_all += 1;
				if($operacao["duracao"] > $operacao["meta_operacao"]) $excedidas_operacao += 1;

			}

			$dados = array(
				"labels" => $labels,
				"duracao" => $duracao,
				"meta_all" => $meta_all,
				"meta_operacao" => $meta_operacao,
				"excedidas_operacao" => $excedidas_operacao - $excedidas_all,
				"excedidas_all" => $excedidas_all,
				"margem_total" => round((($excedidas_operacao- $excedidas_all) * 100) / count($labels)),
				"margem_all" => round(($excedidas_all * 100) / count($labels)),
				"assertividade" => count($labels) - $excedidas_operacao,
				"margem_assertividade" => round(((count($labels) - $excedidas_operacao)*100) / count($labels))
			);

			return $dados;
		}

		return false;

	}

}