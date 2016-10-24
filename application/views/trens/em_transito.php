<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php $this->load->view("layout/head"); ?> 
	<script src="<?php echo base_url('assets/data-table/js/data-table-o.js')?>"></script>
	<script src="<?php echo base_url('assets/data-table/js/dataTables.bootstrap.js')?>"></script>
	<script src="<?php echo base_url('assets/data-table/js/moment.js')?>"></script>
	<script src="<?php echo base_url('assets/data-table/js/datetime-moment.js')?>"></script>
	<link rel="stylesheet" href="<?php echo base_url('assets/data-table/css/jquery.dataTables.css')?>"/>
	<link rel="stylesheet" href="<?php echo base_url('assets/data-table/css/dataTables.bootstrap.css')?>"/>
	<link rel="stylesheet" href="<?php echo base_url('assets/data-table/css/andre_dataTable.css')?>"/>
	
	<script type="text/javascript">
		$("document").ready(function(){
			$.fn.dataTable.moment( 'DD/MM/YY HH:mm' );
		
			$('#table').DataTable({
				paginate:true,
				order: [[ 2, "asc" ]]
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
	<?php $this->load->view("layout/nav_bar"); ?>

	<div class="row">
		<div class="col-sm-12">			
			<h2 class="page-header"><i class="<?=$main['icon']?>"></i> <?=$main['name']?></h2>
			<p class="text-muted">Os trens da tabela abaixo são exibidos pela ordem da previsão de chegada, do primeiro para o último a chegar.</p>
		</div>
	</div>

	<div class="row">
		
		<div class="col-sm-12">

			<!-- LAYOUT DE MENSAGENS -->
			<?php $this->load->view("layout/message"); ?>
		
			<div class="row">
				<div class="col-sm-8">
					<div class="panel panel-default">
						<div class="panel-heading"></div>
						<div class="panel-body">
							<?php if(count($trens) > 0 ): ?>
							
									<table class="table table-hover" id="table">
										<thead>
											<tr>
												<!-- th>Cód.</th -->
												<th class="text-center">Trem</th>
												<th class="text-center">Qtd. Vagões</th>
												<th class="text-center">Previsão de Chegada</th>
											</tr>
										</thead>
										<tbody class="text-center">
											<?php foreach ($trens as $value): ?>
												<tr onclick="javascript:window.location.href = '<?=base_url('trem/trem/'.$value['idtrem'])?>'" >
													<!-- td><?= $value['idtrem']?></td -->
													<td><?= $value['prefixo_trem']?></td>
													<td><?= $value['qtd_vagoes']?></td>
													<td><?= date("d/m/y H:i",strtotime($value['data_previsao']))?></td>
												</tr>
											<?php endforeach; ?>
										</tbody>						
									</table>								
							<?php else: ?>
								<div class="jumbotron">
								  <h2>Não há trens cadastrados!</h2>
								  	<?php if($this->session->userdata('idperfil')!=3):?>
								  		<p>Para adicionar um trem, clique no botão abaixo.</p>
								  		<p><a class="btn btn-primary btn-lg" href="#" data-target="#modal_add_trem" data-toggle="modal" role="button">Adicionar Trem</a></p>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="panel-footer"></div>
					</div>
				</div>
			</div>

		</div>

	</div>

	<?php $this->load->view("layout/rodape"); ?>

</div>    
</body>
</html>