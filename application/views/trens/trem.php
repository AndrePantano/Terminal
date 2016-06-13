<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php $this->load->view("layout/head"); ?> 
	<script src="<?php echo base_url('assets/data-table/js/data-table-o.js')?>"></script>
	<script src="<?php echo base_url('assets/data-table/js/dataTables.bootstrap.js')?>"></script>
	<link rel="stylesheet" href="<?php echo base_url('assets/data-table/css/jquery.dataTables.css')?>"/>
	<link rel="stylesheet" href="<?php echo base_url('assets/data-table/css/dataTables.bootstrap.css')?>"/>

	<script type="text/javascript">
		$("document").ready(function(){
			$('#table').DataTable({
				//order: [[ 2, "asc" ]],
				paging: true,
        		select: true
			});

			$("#table > tbody > tr").hover(function(){
				$(this).css("cursor","pointer");
			});

		});
	</script>
	<title><?=$main['name']?></title>
</head>
<body>
	<div class="container">

		<?php $this->load->view("trens/edit"); ?>
		<?php $this->load->view("previsao/insert"); ?>
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
			<div class="col-sm-12">
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
						<div class="col-sm-3">
							<label>Prefixo do Trem:</label></br>
							<span><?=$trem["prefixo_trem"]?></span>
						</div>
						<div class="col-sm-3">
							<label>Previsão de Chegada</label><br/>
						 	<span><?= $previsoes && count($previsoes) > 0?date("d/m/Y H:i",strtotime($previsoes[count($previsoes)-1]["data_previsao"])):""?></span>
						</div>
						<div class="col-sm-3">
							<label>Data Chegada:</label><br/>
							<?=is_null($trem["chegada_trem"])?"<h4><span class='label label-danger'>Aguardando</span></h4>":date("d/m/Y H:i",strtotime($trem["chegada_trem"]))?>
						</div>
						<div class="col-sm-3">
							<label>Data Partida:</label><br/>
							<?=is_null($trem["partida_trem"])?"<h4><span class='label label-danger'>Aguardando</span></h4>":date("d/m/Y H:i",strtotime($trem["partida_trem"]))?>
						</div>
						
					</div>
				</div>	
			</div>
		</div>	

		<!-- COLAPSE OPERAÇÃO -->
		<div class="row">
			<div class="col-sm-12">
				<div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
				  
				  	<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOperacoes">
							<div class="row">
								<div class="col-sm-6">
									<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion1" href="#collapseOperacoes" aria-expanded="false" aria-controls="collapseOperacoes">
									  <i class="fa fa-cogs"></i> Operações
									</a>
									</h4>
								</div>
								<?php if(count($operacoes) < 2): ?>
									<div class="col-sm-6">
										<button type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#modal_add_operacao">Adicionar</button>
									</div>
								<?php endif;?>
							</div>
						</div>
						<div id="collapseOperacoes" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOperacoes">
							<div class="panel-body">
								
									<p class="text-muted"><i>Para editar clique na linha</i></p>

							</div>
							
							<?php if(count($operacoes) > 0): ?>
								<table class="table table-hover table-condensed table-bordered">
									<thead>
										<tr>
											<th>Linha</th>
											<th>Qtde</th>
											<th title="Encoste na Linha">Encoste na Linha</th>
											<th title="Início da Operação">Início da Oper.</th>
											<th title="Parada Inversão">P. Inver.</th>
											<th title="Parada Manobras">P. Man.</th>
											<th title="Parada Rodoviária">P. Rod.</th>
											<th title="Parada Diversos">P. Div.</th>
											<th title="Parada Troca de Turno">P. T. T.</th>
											<th title="Parada Refições">P. Ref</th>
											<th title="Término da Operação">Término da Oper.</th>
											<th title="Envio Manifesto">Env. Manisfesto</th>
											<th title="Faturamento All">Faturamento All</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($operacoes as $operacao): ?>
											<tr>
												<td><?= $operacao['numero_linha']?></td>
												<td><?= $operacao['qtd_vagoes']?></td>
												<td><?= is_null($operacao['encoste_linha'])?"":date("d/m/Y H:i",strtotime($operacao['encoste_linha']))?></td>
												<td><?= is_null($operacao['inicio_operacao'])?"":date("d/m/Y H:i",strtotime($operacao['inicio_operacao']))?></td>
												<td><?= is_null($operacao['parada_inversao'])?"":date("H:i",strtotime($operacao['parada_inversao']))?></td>
												<td><?= is_null($operacao['parada_manobras'])?"":date("H:i",strtotime($operacao['parada_manobras']))?></td>
												<td><?= is_null($operacao['parada_rodoviaria'])?"":date("H:i",strtotime($operacao['parada_rodoviaria']))?></td>
												<td><?= is_null($operacao['parada_diversos'])?"":date("H:i",strtotime($operacao['parada_diversos']))?></td>
												<td><?= is_null($operacao['parada_troca_turno'])?"":date("H:i",strtotime($operacao['parada_troca_turno']))?></td>
												<td><?= is_null($operacao['parada_refeicao'])?"":date("H:i",strtotime($operacao['parada_refeicao']))?></td>
												<td><?= is_null($operacao['termino_operacao'])?"":date("d/m/Y H:i",strtotime($operacao['termino_operacao']))?></td>
												<td><?= is_null($operacao['envio_manifesto'])?"":date("d/m/Y H:i",strtotime($operacao['envio_manifesto']))?></td>
												<td><?= is_null($operacao['faturamento_all'])?"":date("d/m/Y H:i",strtotime($operacao['faturamento_all']))?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>						
								</table>
							<?php else: ?>
								<p>Não há operações lançadas</p>
							<?php endif; ?>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="row">
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
						<div id="collapsePrevisao" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingPrevisao">
								
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
		
			<!-- COLAPSE NOTAS -->
			<div class="col-sm-6">
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
						<div id="collapseNota" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNota">
								
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

