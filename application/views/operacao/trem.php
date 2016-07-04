<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php $this->load->view("layout/head"); ?> 	
	<title><?=$main['name']?></title>
	<script type="text/javascript">
		$(document).ready(function(){
			
			// ADICIONA PARADA
			$(".add-parada").click(function(){
				$(".idoperacao").val($(this).data("operacao"));
				$(".numero_linha").text($(this).data("linha"));
				$("#modal_add_parada").modal().hide();
			});

			// EDITA PARADA
			$("tr").click(function(){
				var id = $(this).data("id");
				
				// MONTA O CABEÇALHO DA MODAL
				$(".ordem_parada").text($(".ordem_parada"+id).text());
				$(".linha_operacao").text($(this).data("linha_operacao"));

				//SELECIONA O OPTION DO SELECT DE TIPOS DE PARADAS
				var idtipo_parada = $(".tipo_parada"+id).data("id");			
				$("#edit_tipo_parada option[value='"+idtipo_parada+"']").prop("selected","selected");
				
				// ATRIBUI O ID DA OPERACAO
				$(".idoperacao").val($(this).data("idoperacao"));

				// ATRIBUI O ID DA PARADA
				$(".idparada").val(id);

				// ATRIBUI AS DATAS 
				$("#edit_inicio_parada").val($(".inicio"+id).data("parada"));
				$("#edit_fim_parada").val($(".fim"+id).data("parada"));

				// ATRIBUI AS DATA A MODAL DE EXCLUSÃO
				$("#del_inicio_parada").text($(".inicio"+id).text());
				$("#del_fim_parada").text($(".fim"+id).text());
				$("#del_tipo_parada").text($(".tipo_parada"+id).text());

				$("#modal_edit_parada").modal("show");
			});

			// EXCLUI PARADA
			$("#btn_del_parada").click(function(){

				$("#modal_edit_parada").modal("hide");
				$("#modal_del_parada").modal({
					show:true,
					backdrop:'static'
				});
			});

			//CHAMA A MODAL DE EXCLUIR
			$(".btn-del").click(function(){
				var id = $(this).data("id");
				$("#modal_edit_operacao"+id).modal('hide');
				$("#modal_del_operacao"+id).modal({
					show:true,
					backdrop:'static'
				});
			});

			//CHAMA MODAL EDITAR AO SAIR DA MODAL DE EXCLUIR
			$(".close-del").click(function(){
				var id = $(this).data("id");
				$("#modal_edit_operacao"+id).modal('show');
			});
		});
	</script>
</head>
<body>
	<div class="container">
		<?php if($this->session->userdata('idperfil')!=3):?>
			<?php $this->load->view("operacao/insert"); ?>
			<?php $this->load->view("operacao/edit"); ?>
			<?php if($this->session->userdata('idperfil')==1){$this->load->view("operacao/delete"); }?>
			<?php $this->load->view("parada/insert"); ?>
			<?php $this->load->view("parada/edit"); ?>
			<?php if($this->session->userdata('idperfil')==1){$this->load->view("parada/delete"); }?>
		<?php endif; ?>
		
		<?php $this->load->view("layout/nav_bar"); ?>
		<?php $this->load->view("layout/page_header"); ?>
		<?php $this->load->view("layout/message"); ?>
		<?php $this->load->view("layout/nav_tab"); ?>

		<!-- CABECALHO OPERAÇÃO -->
		<div class="row">
			<div class="col-sm-6">
				<h3><i class="fa fa-cogs"></i> Operações
				<?php if($this->session->userdata('idperfil')!=3):?>
					<?php if(count($operacoes) < 2): ?>
							<button type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#modal_add_operacao">Adicionar outra operação</button>
					<?php endif;?>
				<?php endif;?>
				</h3>
				<p>Total atual de vagões: <?=$qtd_vagoes?></p>
			</div>
		</div>

		<div class="row">
			<?php if(count($operacoes) > 0): ?>
				<?php foreach ($operacoes as $linha => $operacao): 
				$linha = $linha + 1;?>

					<div class="col-sm-6">

						<!-- PAINEL DE OPERAÇÕES -->
						<div class="panel panel-default">
						 	<div class="panel-heading">
					 			<h4>
					 				<i class="fa fa-cog"></i> Operação da Linha <?= $linha?>
									<?php if($this->session->userdata('idperfil')!=3):?>
										<button type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#modal_edit_operacao<?=$operacao['idoperacao']?>">Editar Dados</button>
									<?php endif;?>
								</h4>
						 	</div>
						 	<div class="panel-body">

							 	<div class="row">
									<div class="col-sm-12">
										<label class="col-sm-6" style="text-align:right;">Quantidade de Vagões:</label>
										<span class="col-sm-6"><?= $operacao['qtd_vagoes']?></span>
									</div>
									<div class="col-sm-12">
										<label class="col-sm-6" style="text-align:right;">Encoste na Linha:</label>
										<span class="col-sm-6"><?= is_null($operacao['encoste_linha'])?"&nbsp;":date("d/m/Y H:i",strtotime($operacao['encoste_linha']))?></span>
									</div>
									<div class="col-sm-12">
										<label class="col-sm-6" style="text-align:right;">Início da Operação:</label>
										<span class="col-sm-6"><?= is_null($operacao['inicio_operacao'])?"&nbsp;":date("d/m/Y H:i",strtotime($operacao['inicio_operacao']))?></span>
									</div>
									<div class="col-sm-12">
										<label class="col-sm-6" style="text-align:right;">Término da Operação:</label>
										<span class="col-sm-6"><?= is_null($operacao['termino_operacao'])?"&nbsp;":date("d/m/Y H:i",strtotime($operacao['termino_operacao']))?></span>
									</div>
									<div class="col-sm-12">
										<label class="col-sm-6" style="text-align:right;">Envio do Manisfesto:</label>
										<span class="col-sm-6"><?= is_null($operacao['envio_manifesto'])?"&nbsp;":date("d/m/Y H:i",strtotime($operacao['envio_manifesto']))?></span>
									</div>
									<div class="col-sm-12">
										<label class="col-sm-6" style="text-align:right;">Faturamento All:</label>
										<span class="col-sm-6"><?= is_null($operacao['faturamento_all'])?"&nbsp;":date("d/m/Y H:i",strtotime($operacao['faturamento_all']))?></span>
									</div>
							 	</div>
							 </div>
						</div>

						<!-- PAINEL DE PARADAS -->
						<div class="panel panel-default">
						 	<div class="panel-heading">
									<h4><i class="fa fa-hand-paper-o"></i> Paradas da Linha <?= $linha?>
									<?php if($this->session->userdata('idperfil')!=3):?>
										<button type="button" class="btn btn-default btn-sm pull-right add-parada" data-operacao="<?= $operacao['idoperacao']?>" data-linha="<?= $linha?>">Adicionar Parada</button>
									<?php endif;?>
									</h4>
						 	</div>
								<div class="panel-body">
							 	<div class="row">

									<?php if($operacao["paradas"] && count($operacao["paradas"]) > 0): ?>

											<div class="col-sm-12">
												<table class="table table-condensed table-hover table-striped">
													<thead>
														<tr>
															<th>#</th>
															<th>Tipo</th>
															<th>Data Início</th>
															<th>Data Fim</th>
															<th>Duração</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$segundos = 0;
														foreach ($operacao["paradas"] as $k => $parada): ?>
															<tr data-id="<?=$parada['idparada']?>" data-linha_operacao="<?=$linha?>" data-idoperacao="<?=$parada["idoperacao"]?>">
																<td class="ordem_parada<?=$parada['idparada']?>"><?= $k+1 ?></td>
																<td class="tipo_parada<?=$parada['idparada']?>" data-id="<?= $parada["idtipo_parada"]?>"><?= $parada["nome_tipo_parada"]?></td>
																<td class="inicio<?=$parada['idparada']?>" data-parada="<?=date('Y-m-d\TH:i',strtotime($parada['inicio_parada']))?>"><?= date("d/m/Y H:i",strtotime($parada["inicio_parada"]))?></td>
																<td class="fim<?=$parada['idparada']?>" data-parada="<?=date('Y-m-d\TH:i',strtotime($parada['fim_parada']))?>"><?= date("d/m/Y H:i",strtotime($parada["fim_parada"]))?></td>
																<td class="<?=$parada['idparada']?>"><?= $parada["duracao"] ?></td>
															</tr>
														<?php 
															list($h,$m) = explode(":",$parada["duracao"]);
															$segundos += $h * 3600;
															$segundos += $m * 60;

														endforeach; 

														$horas = floor( $segundos / 3600 ); //converte os segundos em horas e arredonda caso nescessario
														$segundos %= 3600; // pega o restante dos segundos subtraidos das horas
														$minutos = floor( $segundos / 60 );//converte os segundos em minutos e arredonda caso nescessario
														$segundos %= 60;// pega o restante dos segundos subtraidos dos minutos
														$horas < 10? $horas = "0".$horas:$horas;
														$minutos < 10? $minutos = "0".$minutos:$minutos;
														?>
													</tbody>
													<tfoot>
														<tr>
															<th colspan="4">Duração Total de Paradas</th>
															<th><?=$horas.":".$minutos?></th>
														</tr>
													</tfoot>

												</table>
											</div>
									
									<?php else: ?>
										<div class="col-sm-12">
											<p>Não há paradas lançadas</p>
										</div>
									<?php endif; ?>

								</div>
							</div>
						</div>
						
					</div>
				<?php endforeach; ?>
			
			<?php else: ?>
				<div class="col-sm-12">
					<p>Não há operações lançadas</p>
				</div>
			<?php endif; ?>
		</div>

		<?php $this->load->view("layout/rodape"); ?>

	</div>   
</body>
</html>

