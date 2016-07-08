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

	// RELATORIO DE OPERAÇÕES
	public function rel_01($inicio,$fim){

		$this->load->model("Parada_Model");

		// RETORNA FALSE SE O INICIO FOR MAIOR QUE O FIM
		if($inicio > $fim) return false;

		$str = "SELECT *," 			
			." DATE_FORMAT(TIMEDIFF(faturamento_all,encoste_linha),'%H.%i') as tempo_operacao,"
			." DATE_FORMAT(TIMEDIFF(faturamento_all,envio_manifesto),'%H.%i') as tempo_bo,"
			." DATE_FORMAT(chegada_trem,'%d/%m/%Y %H:%i') as chegada,"
			." qtd_vagoes" 
			." FROM tb_operacao"
			." JOIN tb_trem USING(idtrem)"
			." WHERE "
				."chegada_trem"
					." BETWEEN "
						."'".date("Y-m-d",strtotime($inicio))."'"
						." AND "
						."'".date("Y-m-d",strtotime($fim))."'"
						." AND "
						."chegada_trem IS NOT NULL";

		//echo $str."<br/>";

		$operacoes = $this->query($str);

		if($operacoes){

			$dados = array();
			$labels = array();
			$prefixo_trem = array();
			$meta_all = array();
			$meta_operacao = array();
			$op_duracao = array();
			$bo_duracao = array();
			$pr_duracao = array();
			$mi_duracao = array();
			$tu_duracao = array();
			$chegada_trem = array();
			$qtd_vagoes = array();

			$excedidas_all = $excedidas_operacao = 0;

			foreach ($operacoes as $k => $operacao) {

				// IDENTIFICA E ALIMENTA O ARRAY DE LABELS DAS OPERAÇÕES
					$prefixo = "";
					
					$linha = 0;

					if($k < (count($operacoes) -1) && $operacao["idtrem"] == $operacoes[$k + 1]["idtrem"]){
						$prefixo = $operacao["prefixo_trem"]." I";
					}else{
						if( $k > 0 && $operacao["idtrem"] == $operacoes[$k - 1]["idtrem"]){
							$prefixo = $operacao["prefixo_trem"]." II";
						}else{
							$prefixo = $operacao["prefixo_trem"];
						}
					}

					array_push($labels, $prefixo." ".date("d/m",strtotime($operacao["chegada_trem"])));
					array_push($prefixo_trem,$prefixo);

				// ALIMENTA OS ARRAYS COMO OS TEMPOS
					array_push($bo_duracao,$operacao["tempo_bo"]);
					array_push($op_duracao,$operacao["tempo_operacao"]);
					array_push($meta_all,$operacao["meta_all"]);
					array_push($meta_operacao,$operacao["meta_operacao"]);

				// ALIMENTA OS ARRAYS COM OUTROS DETALHES
					array_push($chegada_trem,$operacao['chegada']);
					array_push($qtd_vagoes,$operacao['qtd_vagoes']);

				// IDENTIFICA E CONTA AS OPERAÇÕES QUE EXCEDERAM O TEMPO
					if($operacao["tempo_operacao"] > $operacao["meta_all"]) $excedidas_all += 1;
					if($operacao["tempo_operacao"] > $operacao["meta_operacao"]) $excedidas_operacao += 1;
					
				// RETORNA TODAS AS PARADAS DESTA OPERAÇÃO
					$paradas = $this->Parada_Model->paradas("idoperacao",$operacao["idoperacao"]);

					$pr = $mi = $total_paradas = 0;

					if($paradas){
						foreach ($paradas as $j => $parada) {
							if($parada["idtipo_parada"]==1 ||$parada["idtipo_parada"]==2) $mi += $parada["tempo"];
							if($parada["idtipo_parada"]==3) $pr += $parada["tempo"];
							$total_paradas += $parada["tempo"];
						}
					}

					array_push($pr_duracao,$this->converte_em_hora($pr));
					array_push($mi_duracao,$this->converte_em_hora($mi));
					array_push($tu_duracao,$this->converte_em_hora($operacao["tempo_operacao"]-$total_paradas));

			}

			$dados = array(
				"labels" => $labels,
				"prefixo_trem" => $prefixo_trem,
				"op_valores" => $op_duracao,
				"bo_valores" => $bo_duracao,
				"pr_valores" => $pr_duracao,
				"mi_valores" => $mi_duracao,
				"tu_valores" => $tu_duracao,
				"meta_all" => $meta_all,
				"meta_operacao" => $meta_operacao,
				"qtd_vagoes" => $qtd_vagoes,
				"chegada_trem" => $chegada_trem,
				//"excedidas_operacao" => $excedidas_operacao - $excedidas_all,
				"excedidas_all" => $excedidas_all,
				"margem_total" => round((($excedidas_operacao- $excedidas_all) * 100) / count($labels)),
				"margem_all" => round(($excedidas_all * 100) / count($labels)),
				"assertividade" => count($labels) - $excedidas_all,
				"margem_assertividade" => round(((count($labels) - $excedidas_all)*100) / count($labels))
			);

			return $dados;
		}

		return false;
		
	}

	// RELATORIO DE TRENS
	public function rel_02($inicio,$fim){

		$this->load->model("Operacao_Model");

		// RETORNA FALSE SE O INICIO FOR MAIOR QUE O FIM
		if($inicio > $fim) return false;

		$str = "SELECT *,"
			." DATE_FORMAT(chegada_trem,'%d/%m/%Y %H:%i') as chegada" 			
			." FROM tb_trem"
			." WHERE "
				."chegada_trem"
					." BETWEEN "
						."'".date("Y-m-d",strtotime($inicio))."'"
						." AND "
						."'".date("Y-m-d",strtotime($fim))."'"
						." AND "
						."chegada_trem IS NOT NULL";

		//echo $str."<br/>";

		$trens = $this->query($str);

		if($trens){

			$dados = array();
			$labels = array();
			$prefixo_trem = array();
			$chegada_trem = array();
			$qtd_vagoes = array();
			$tempo_operacao = array();			

			foreach ($trens as $k => $trem) {

				// IDENTIFICA E ALIMENTA O ARRAY DE LABELS DOS TRENS
					array_push($labels, $trem["prefixo_trem"]." ".date("d/m",strtotime($trem["chegada_trem"])));
					array_push($prefixo_trem, $trem["prefixo_trem"]);
					
				// BUSCA TODAS AS OPERAÇÕES DO TREM
					$operacoes = $this->Operacao_Model->operacoes("idtrem",$trem["idtrem"]);

					$total_vagoes = 0;

					if($operacoes){
						
						$encoste_linha = strtotime($operacoes[0]["encoste_linha"]);
						
						if(count($operacoes) > 1) {
							$faturamento_all = strtotime($operacoes[1]["faturamento_all"]);
							$total_vagoes = $operacoes[0]["qtd_vagoes"] + $operacoes[1]["qtd_vagoes"];
						}else{
							$faturamento_all = strtotime($operacoes[0]["faturamento_all"]);
							$total_vagoes = $operacoes[0]["qtd_vagoes"];
						}						
					}

					$segundos = $minutos = $horas = 0; 
					$segundos = $faturamento_all - $encoste_linha;
					$horas = floor( $segundos / 3600 ); //converte os segundos em horas e arredonda caso nescessario
					$segundos %= 3600; // pega o restante dos segundos subtraidos das horas
					$minutos = floor( $segundos / 60 );//converte os segundos em minutos e arredonda caso nescessario
					$segundos %= 60;// pega o restante dos segundos subtraidos dos minutos
					$horas < 10? $horas = "0".$horas:$horas;
					$minutos < 10? $minutos = "0".$minutos:$minutos;

					//array_push($tempo_operacao,$operacao["tempo_trem"]);
					array_push($tempo_operacao,$horas.".".$minutos);

				// ALIMENTA A QUANTIDADE DE VAGOES
				array_push($qtd_vagoes,$total_vagoes);

				// ALIMENTA A CHEGADA DO TREM
				array_push($chegada_trem,$trem["chegada"]);
			}

			$dados = array(
				"labels" => $labels,
				"chegada_trem" => $chegada_trem,
				"prefixo_trem" => $prefixo_trem,
				"qtd_vagoes" => $qtd_vagoes,
				"tempo_operacao" => $tempo_operacao,				
			);

			return $dados;
		}

		return false;
		
	}

	public function converte_em_hora($tempo){

		$segundos = $minutos = $horas = 0;
		list($h,$m) = explode(".", number_format(($tempo),2));
		$segundos += $h * 3600;
		$segundos += $m * 60;
		$horas = floor( $segundos / 3600 ); //converte os segundos em horas e arredonda caso nescessario
		$segundos %= 3600; // pega o restante dos segundos subtraidos das horas
		$minutos = floor( $segundos / 60 );//converte os segundos em minutos e arredonda caso nescessario
		$segundos %= 60;// pega o restante dos segundos subtraidos dos minutos
		$horas < 10? $horas = "0".$horas:$horas;
		$minutos < 10? $minutos = "0".$minutos:$minutos;
		
		return  $horas.".".$minutos;
	}

}