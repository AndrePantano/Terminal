<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php $this->load->view("layout/head"); ?> 	
	<title><?=$main['name']?></title>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".add-parada").click(function(){
				$(".idoperacao").val($(this).data("operacao"));
				$(".numero_linha").text($(this).data("linha"));
				$("#modal_add_parada").modal().hide();
			});
		});
	</script>
</head>
<body>
	<div class="container">

		<?php $this->load->view("trens/edit"); ?>
		<?php $this->load->view("operacao/edit"); ?>
		<?php $this->load->view("previsao/insert"); ?>
		<?php $this->load->view("parada/insert"); ?>
		<?php $this->load->view("operacao/insert"); ?>
		<?php $this->load->view("nota/insert"); ?>
		<?php $this->load->view("layout/nav_bar"); ?>

		<div class="row">
			<div class="col-sm-12">			
				<h1><i class="<?=$main['icon']?>"></i> <?=$main['name']?></h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">

				<!-- LAYOUT DE MENSAGENS -->
				<?php $this->load->view("layout/message"); ?>
			</div>
		</div>

		<!-- TREM -->
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
								<div class="col-sm-6">
									<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion1" href="#collapseOperacoes" aria-expanded="false" aria-controls="collapseOperacoes">
									  <i class="fa fa-train"></i> Trem
									</a>
									</h4>
								</div>
								<div class="col-sm-6">
									<button type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#modal_edit_trem">Editar Dados</button>
								</div>
							</div>
					</div>
					<div class="panel-body">
						<div class="row">

							<div class="col-sm-12">
								<label class="col-sm-6" style="text-align:right;">Prefixo do Trem:</label>
								<span class="col-sm-6"><?=$trem["prefixo_trem"]?></span>
							</div>
							<div class="col-sm-12">
								<label class="col-sm-6" style="text-align:right;">Previsão de Chegada</label>
							 	<span class="col-sm-6"><?= $previsoes && count($previsoes) > 0?date("d/m/Y H:i",strtotime($previsoes[count($previsoes)-1]["data_previsao"])):""?></span>
							</div>
							<div class="col-sm-12">
								<label class="col-sm-6" style="text-align:right;">Data Chegada:</label>
								<?=is_null($trem["chegada_trem"])?"<span class='col-sm-6 text-danger'>Aguardando Dados</span>":"<span class='col-sm-6'>".date("d/m/Y H:i",strtotime($trem["chegada_trem"]))."</span>"?>
							</div>
							<div class="col-sm-12">
								<label class="col-sm-6" style="text-align:right;">Data Partida:</label>
								<?=is_null($trem["partida_trem"])?"<span class='col-sm-6 text-danger'>Aguardando Dados</span>":"<span class='col-sm-6'>".date("d/m/Y H:i",strtotime($trem["partida_trem"]))."</span>"?>
							</div>
							<div class="col-sm-12">
								<label class="col-sm-6" style="text-align:right;">Tempo de Permanência:</label>
								<?=is_null($trem["chegada_trem"]) || is_null($trem["partida_trem"])?"<span class='col-sm-6 text-danger'>Aguardando Dados</span>":$trem["dias"]." dias, ".$trem["horas"]." hs e ".$trem["minutos"]." min."?>
							</div>
							<div class="col-sm-12">
								<hr></hr>							
								<p class="text-muted">O tempo de permanência é calculado somente quando há data de chegada e partida do trem.</p>
							</div>
						</div>
					</div>
				</div>	
			</div>

			<!-- COLAPSE PREVISAO -->
			<div class="col-sm-6">
				<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingPrevisao">
							<div class="row">
								<div class="col-sm-6">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapsePrevisao" aria-expanded="true" aria-controls="collapsePrevisao">
										  <i class="fa fa-clock-o"></i> Previsões de Chegada <span class="badge"><?=$previsoes?count($previsoes):0?></span>
										</a>
									</h4>
								</div>
								<div class="col-sm-6">
									<button type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#modal_add_previsao">Adicionar</button>
								</div>
							</div>						
						</div>
						<div id="collapsePrevisao" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingPrevisao">
								
							<?php if($previsoes && count($previsoes) > 0): ?>								
								<table class="table table-hover">
									<thead>
										<tr>
											<th width="150px">Previsão</th>
											<th>Motivo</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($previsoes as $previsao): ?>
											<tr>
												<td><?= date("d/m/Y H:i",strtotime($previsao['data_previsao']))?></td>
												<td><?= $previsao['motivo_previsao']?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>						
								</table>
							<?php else: ?>
								<p>Não há previsões lançadas</p>
							<?php endif; ?>
													
						</div>
					</div>
					
				</div>
			</div>
		</div>	

		<!-- CABECALHO OPERAÇÃO -->
		<div class="row">
			<div class="col-sm-12 page-header">
				<h3><i class="fa fa-cogs"></i> Operações</h3>
			<?php if(count($operacoes) < 2): ?>
				<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_add_operacao">Adicionar outra operação</button>
			<?php endif;?>
			</div>
		</div>

		<div class="row">
			<?php if(count($operacoes) > 0): ?>
				<?php foreach ($operacoes as $operacao): ?>

					<div class="col-sm-6">
						<div class="panel panel-default">
						 	<div class="panel-heading">
							 	<div class="row">
									<div class="col-sm-6">
							 			<h3 class="panel-title"><i class="fa fa-cog"></i> Operação da Linha <?= $operacao['numero_linha']?></h3>
									</div>
									<div class="col-sm-6">
										<button type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#modal_edit_operacao<?=$operacao['numero_linha']?>">Editar Dados</button>
									</div>
								</div>
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

						<div class="panel-group" id="parada<?= $operacao['numero_linha']?>" role="tablist" aria-multiselectable="true">
							
							<div class="panel panel-default">
							 	<div class="panel-heading" id="heading_parada<?= $operacao['numero_linha']?>">
								 	<div class="row">
										<div class="col-sm-6">
								 			<h3 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse" data-parent="#parada<?= $operacao['numero_linha']?>" href="#collapseparada<?= $operacao['numero_linha']?>" aria-expanded="false" aria-controls="collapseparada<?= $operacao['numero_linha']?>">
									 				<i class="fa fa-hand-paper-o"></i> Paradas da Linha <?= $operacao['numero_linha']?>
												</a>
								 			</h3>
										</div>
										<div class="col-sm-6">
											<button type="button" class="btn btn-default btn-sm pull-right add-parada" data-operacao="<?= $operacao['idoperacao']?>" data-linha="<?= $operacao['numero_linha']?>">Adicionar Parada</button>
										</div>
									</div>
							 	</div>

								<div id="collapseparada<?= $operacao['numero_linha']?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_parada<?= $operacao['numero_linha']?>">
							 		<div class="panel-body">
									 	<div class="row">

											<?php if($operacao["paradas"] && count($operacao["paradas"]) > 0): ?>

													<div class="col-sm-12">
														<table class="table table-condensed table-hover table-striped">
															<thead>
																<tr>
																	<th>Tipo</th>
																	<th>Data Início</th>
																	<th>Data Fim</th>
																	<th>Duração</th>
																</tr>
															</thead>
															<tbody>
																<?php 
																$segundos = 0;
																foreach ($operacao["paradas"] as $parada): ?>
																	<tr>
																		<td><?= $parada["nome_tipo_parada"]?></td>
																		<td><?= date("d/m/Y H:i",strtotime($parada["inicio_parada"]))?></td>
																		<td><?= date("d/m/Y H:i",strtotime($parada["fim_parada"]))?></td>
																		<td><?= $parada["duracao"] ?></td>
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
																	<th colspan="3">Duração Total de Paradas</th>
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
						</div>
					</div>
				<?php endforeach; ?>
			
			<?php else: ?>
				<div class="col-sm-12">
					<p>Não há operações lançadas</p>
				</div>
			<?php endif; ?>
		</div>

		<!-- CABECALHO OUTRAS INFORMAÇÕES -->
		<div class="row">
			<div class="col-sm-12 page-header">
				<h3><i class="fa fa-info-circle"></i> Outras Informações</h3>			
			</div>
		</div>

		<div class="row">
			
			<!-- COLAPSE NOTAS -->
			<div class="col-sm-12">
				<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
				  	
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingNota">
							<div class="row">
								<div class="col-sm-6">
									<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapseNota" aria-expanded="false" aria-controls="collapseNota">
									  <i class="fa fa-pencil-square-o"></i> Notas de Atividades <span class="badge"><?=$notas?count($notas):0?></span>
									</a>
									</h4>
								</div>
								<div class="col-sm-6">
									<button type="button" data-toggle="modal" data-target="#modal_add_nota" class="btn btn-default btn-sm pull-right" role="button">Adicionar</button>
								</div>
							</div>
						</div>
						<div id="collapseNota" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingNota">
								
								<?php if($notas && count($notas) > 0):?>
									<table class="table table-hover">
										<thead>
											<tr>
												<th width="150px">Data</th>
												<th>Atividade</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($notas as $nota): ?>
												<tr>
													<td><?= date("d/m/Y H:i",strtotime($nota['criacao_nota']))?></td>
													<td><?= $nota['texto_nota']?></td>
												</tr>
											<?php endforeach;?> 
										</tbody>						
									</table>
								<?php else: ?>
									<p>Não há notas lançadas</p>
								<?php endif; ?>
							
						</div>
					</div>

				</div>
			</div>
		</div>
		
		<?php $this->load->view("layout/rodape"); ?>

	</div>   
</body>
</html>

