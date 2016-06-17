<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php $this->load->view("layout/head"); ?> 
	<script src="<?php echo base_url('assets/data-table/js/data-table-o.js')?>"></script>
	<script src="<?php echo base_url('assets/data-table/js/dataTables.bootstrap.js')?>"></script>
	<link rel="stylesheet" href="<?php echo base_url('assets/data-table/css/jquery.dataTables.css')?>"/>
	<link rel="stylesheet" href="<?php echo base_url('assets/data-table/css/dataTables.bootstrap.css')?>"/>
	<link rel="stylesheet" href="<?php echo base_url('assets/data-table/css/andre_dataTable.css')?>"/>

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
	<?php $this->load->view("layout/nav_bar"); ?>

	<div class="row">
		<div class="col-sm-12">			
			<h1 class="page-header"><i class="<?=$main['icon']?>"></i> <?=$main['name']?></h1>
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
											<th>Cód.</th>
											<th>Trem</th>
											<th>Data Chegada</th>
											<th>Data Partida</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($trens as $value): ?>
											<tr onclick="javascript:window.location.href = '<?=base_url('trens/trem/'.$value['idtrem'])?>'" >
												<td><?= $value['idtrem']?></td>
												<td><?= $value['prefixo_trem']?></td>
												<td><?= date("d/m/Y H:i",strtotime($value['chegada_trem']))?></td>
												<td><?= date("d/m/Y H:i",strtotime($value['partida_trem']))?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>						
								</table>
							
						<?php else: ?>
							<div class="jumbotron">
							  <h1>Não há trens neste período!</h1>
							  <p>Para adicionar um trem, clique no botão abaixo.</p>
							  <p><a class="btn btn-primary btn-lg" href="<?= base_url('ads/insert') ?>" role="button">Adicionar Trem</a></p>
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