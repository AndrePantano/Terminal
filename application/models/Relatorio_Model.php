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
			." TIMESTAMPDIFF(MINUTE,encoste_linha,faturamento_all) as t_operacao,"
			." TIMESTAMPDIFF(MINUTE,envio_manifesto,faturamento_all) as t_bo,"
			." TIMESTAMPDIFF(MINUTE,envio_manifesto,partida_trem) as t_estadia,"
			." DATE_FORMAT(chegada_trem,'%d/%m %H:%i') as chegada"			
			." FROM tb_operacao"
			." JOIN tb_trem USING(idtrem)"
			." WHERE "
				."chegada_trem BETWEEN '".date("Y-m-d",strtotime($inicio))."' AND '".date("Y-m-d",strtotime($fim))."'"
				." AND chegada_trem IS NOT NULL AND partida_trem IS NOT NULL AND tb_trem.idterminal = ".$this->session->userdata("idterminal")
				." ORDER BY chegada_trem ASC";

		//echo $str."<br/>";

		$operacoes = $this->query($str);

		if($operacoes){

			$dados = array();
			$labels = array();
			$idtrem = array();
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
			$a_cobrar_terloc = array();
			$estadia_vagoes = array();

			$excedidas_all = $excedidas_operacao = 0;

			foreach ($operacoes as $k => $operacao) {

				// IDENTIFICA E ALIMENTA O ARRAY DE LABELS DAS OPERAÇÕES
					$prefixo = "";
					
					$unica_linha = false;

					if($k < (count($operacoes) -1) && $operacao["idtrem"] == $operacoes[$k + 1]["idtrem"]){
						$prefixo = $operacao["prefixo_trem"]." I";
					}else{
						if( $k > 0 && $operacao["idtrem"] == $operacoes[$k - 1]["idtrem"]){
							$prefixo = $operacao["prefixo_trem"]." II";
						}else{
							$prefixo = $operacao["prefixo_trem"];
							$unica_linha = true;
						}
					}

					array_push($labels, $prefixo." ".date("d/m",strtotime($operacao["chegada_trem"])));
					array_push($prefixo_trem,$prefixo);

				// ALIMENTA OS ARRAYS COM OUTROS DETALHES
					array_push($chegada_trem,$operacao['chegada']);
					array_push($qtd_vagoes,$operacao['qtd_vagoes']);
					array_push($idtrem,$operacao['idtrem']);

				// ALIMENTA OS ARRAYS COMO OS TEMPOS
					array_push($bo_duracao,$this->converter_tempo($operacao["t_bo"]));
					array_push($op_duracao,$this->converter_tempo($operacao["t_operacao"]));
					array_push($meta_all,$operacao["meta_all"]);
					array_push($meta_operacao,$operacao["meta_operacao"]);

				// IDENTIFICA E CONTA AS OPERAÇÕES QUE EXCEDERAM O TEMPO
					$mt_operacao = $operacao["meta_operacao"] * 60;
					$mt_all = $operacao["meta_all"] * 60;
					if($operacao["t_operacao"] > $mt_all) $excedidas_all += 1;
					if($operacao["t_operacao"] > $mt_operacao) $excedidas_operacao += 1;
					
				// RETORNA TODAS AS PARADAS DESTA OPERAÇÃO
					$paradas = $this->Parada_Model->paradas("idoperacao",$operacao["idoperacao"]);

					$pr = $mi = $total_paradas = 0;

					if($paradas){
						foreach ($paradas as $j => $parada) {

							// SE HOUVER UMA LINHA, ACRESCENTA TEMPO DE MANOBRA E INVERSÃO
							// SE HOUVEREM DUAS LINHAS, ACRESCENTA APENAS TEMPO DE MANOBRA
							if($unica_linha){
								if($parada["idtipo_parada"]==2) $mi += $parada["t_parada"];								
							}else{
								if($parada["idtipo_parada"]==1 ||$parada["idtipo_parada"]==2) $mi +=  $parada["t_parada"];								
							}

							if($parada["idtipo_parada"]==3) $pr += $parada["t_parada"];

							// SE PARADA FOR MANOBRA OU INVERSAO, ACRESCENTA O VALOR DE $MI
							if($parada["idtipo_parada"]==1 ||$parada["idtipo_parada"]==2){
								$total_paradas += $mi;
							}else{
								$total_paradas += $parada["t_parada"];
							}
						}
					}
								
					$tempo_util = $operacao["t_operacao"] - $total_paradas;

					array_push($pr_duracao,$this->converter_tempo($pr));
					array_push($mi_duracao,$this->converter_tempo($mi));
					array_push($tu_duracao,$this->converter_tempo($tempo_util));

					$act = $tev = 0;
					
					if($this->session->userdata("idterminal") == 1){
						
					// ALIMENTA OS ARRAYS DE VALORES MONETÁRIOS
						if($tempo_util > $mt_operacao)
							$act = (($tempo_util - $mt_operacao) * ($operacao["tarifa"] /60) ) * $operacao["qtd_vagoes"];

					// SE O TEMPO DE ESTADIA FOR SUPERIOR A 24 HORAS
						if($operacao["t_estadia"] > 1440)
							$tev = (($operacao["t_estadia"] - 1440) * ($operacao["tarifa"] /60) ) * $operacao["qtd_vagoes"];
					}
					
					array_push($a_cobrar_terloc,$act);
					array_push($estadia_vagoes,$tev);

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
				"idtrem" => $idtrem,
				"chegada_trem" => $chegada_trem,
				"a_cobrar_terloc" => $a_cobrar_terloc,
				"estadia_vagoes" => $estadia_vagoes,
				"excedidas_all" => $excedidas_all,
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
						." '".date("Y-m-d",strtotime($inicio))."'"
						." AND "
						." '".date("Y-m-d",strtotime($fim))."'"
						." AND "
						." chegada_trem IS NOT NULL"
						."	AND "
						."	idterminal = ".$this->session->userdata("idterminal")
						." ORDER BY chegada_trem ASC";

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

	// RELATORIO DE PREVISÃO DE CHEGADA
	public function rel_03($inicio,$fim){

		$this->load->model("Trem_Model");

		// RETORNA FALSE SE O INICIO FOR MAIOR QUE O FIM
		if($inicio > $fim) return false;

		$str = "SELECT *"
			." FROM tb_trem"			
			." WHERE "
				."chegada_trem"
					." BETWEEN "
						." '".date("Y-m-d",strtotime($inicio))."'"
						." AND "
						." '".date("Y-m-d",strtotime($fim))."'"
						." AND "
						." chegada_trem IS NOT NULL"
						."	AND "
						."	idterminal = ".$this->session->userdata("idterminal")
						." ORDER BY partida_trem DESC";

		//echo $str."<br/>";

		$trens = $this->query($str);

		$dados = array();

		if($trens){
		
			$deltas = array();
			$previsoes = array();

			foreach ($trens as $trem) {

				$str = "SELECT * FROM tb_previsao_chegada WHERE idtrem = ".$trem["idtrem"]." ORDER BY idprevisao DESC LIMIT 4";
				$previsoes = $this->query($str);

				$array_previsoes = array();
				$array_deltas = array();
				$array_deltas_color = array();

				if($previsoes){
					for($i=0;$i<4;$i++){ // RODA 4 VEZES					
						if(array_key_exists($i, $previsoes)){
							
							array_push($array_previsoes,date("d/m H:i",strtotime($previsoes[$i]["data_previsao"])));

							// RETORNA O DELTA DE ENTRE CADA PREVISÃO
							if($i > 0){
								$datatime1 = new DateTime($previsoes[$i - 1]["data_previsao"]);
								$datatime2 = new DateTime($previsoes[$i]["data_previsao"]);

								$diff = $datatime1->diff($datatime2);

								$horas = $diff->format("%d") * 24 + $diff->format("%h");
								
								array_push($array_deltas, $this->posi_nega($datatime2,$datatime1).$horas);
								array_push($array_deltas_color, $this->color("delta_hs",$horas,10));
							}

							// RETORNA SOMENTE O DELTA ENTRE A ULTIMA PREVISAO E A DATA DE CHEGADA
							if($i == 0){
								
								$datatime1 = new DateTime($previsoes[$i]["data_previsao"]);
								$datatime2 = new DateTime($trem["chegada_trem"]);

								$diff = $datatime1->diff($datatime2);

								$delta_f = $this->posi_nega($datatime1,$datatime2).$diff->format('%H:%I');
								$horas = $diff->format("%d") * 24 + $diff->format("%h");					
								$cor = $this->color("delta_final",$horas,2);

							}

						}else{
							array_push($array_previsoes,"null");
							array_push($array_deltas, "null");
							array_push($array_deltas_color, "null");
						}
					}
				}

				$linha = array(
					"idtrem"		=> $trem["idtrem"],
					"prefixo" 		=> $trem["prefixo_trem"],
					"chegada" 		=> date("d/m H:i",strtotime($trem["chegada_trem"])),
					"previsoes" 	=> array_reverse($array_previsoes),
					"deltas" 		=> array_reverse($array_deltas),
					"deltas_color" 	=> array_reverse($array_deltas_color),
					"delta_f"		=> $delta_f,
					"color"			=> $cor
				);

				array_push($dados, $linha);

			}

			//echo "<pre>".print_r($dados,1)."</pre>";
			return $dados;
			
		}

		return false;
	}


	public function converte_em_hora($tempo){

		//$segundos = $minutos = $horas = 0;
		//list($h,$m) = explode(".", number_format(($tempo),2));
		//$segundos += $h * 3600;
		//$segundos += $m * 60;
		$segundos = $tempo;
		$horas = floor( $segundos / 3600 ); //converte os segundos em horas e arredonda caso nescessario
		$segundos %= 3600; // pega o restante dos segundos subtraidos das horas
		$minutos = floor( $segundos / 60 );//converte os segundos em minutos e arredonda caso nescessario
		$segundos %= 60;// pega o restante dos segundos subtraidos dos minutos
		$horas < 10? $horas = "0".$horas:$horas;
		$minutos < 10? $minutos = "0".$minutos:$minutos;
		
		return  $horas.".".$minutos;
	}

	public function converte_em_segundos($duracao){

		$segundos = $minutos = $horas = 0;
		list($h,$m) = explode(":",$duracao);
		$segundos += $h * 3600;
		$segundos += $m * 60;
		//$horas = floor( $segundos / 3600 ); //converte os segundos em horas e arredonda caso nescessario
		//$segundos %= 3600; // pega o restante dos segundos subtraidos das horas
		//$minutos = floor( $segundos / 60 );//converte os segundos em minutos e arredonda caso nescessario
		//$segundos %= 60;// pega o restante dos segundos subtraidos dos minutos
		//$horas < 10? $horas = "0".$horas:$horas;
		//$minutos < 10? $minutos = "0".$minutos:$minutos;
		
		return  $segundos;
	}

	public function converter_tempo($tempo){
		
		$horas = floor( $tempo / 60 );
		$minutos = $tempo % 60;
		$horas < 10? $horas = "0".$horas:$horas;
		$minutos < 10? $minutos = "0".$minutos:$minutos;
		
		return  $horas.".".$minutos;
	}

	public function color($item,$valor,$limite){
		
		// RETORNA A COR DO DELTA 
		
		if($valor != 0 || $item == "delta_final"){
			if($valor > $limite ){
				return '#FF7417'; // fora
			}else{
				return '#0F0'; // dentro
			}
		}else{
			return "null";
		}
	}

	public function posi_nega($var1,$var2){
		if($var1 > $var2){ // SE A PREVISAO FOR MAIOR QUE A CHEGADA
			return "-";
		}elseif($var1 < $var2){ // SE PREVISAO FOR MENOR QUE A CHEGADA
			return "+";
		}else{
			return "";
		}
	}

}