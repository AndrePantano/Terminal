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

			$("#table > tbody").on("click","tr",function(){

				var id = $(this).data("id");
				
				$(".idterminal").val(id);
				
				// EDITAR DADOS
				$(".nome").val($(".nome"+id).text());
				$(".sigla").val($(".sigla"+id).text());
				$(".meta").val($(".meta"+id).text());
				$(".tarifa").val($(".tarifa"+id).text());
								
				// EXCLUIR DADOS
				$(".nome_del").text($(".nome"+id).text());
				$(".sigla_del").text($(".sigla"+id).text());
				$(".meta_del").text($(".meta"+id).text());
				$(".tarifa_del").text($(".tarifa"+id).text());
				
				$("#modal_edit").modal("show");

			});
			
			// CHAMA A MODAL DE EXCLUIR
			$("#btn_del").click(function(){

				$("#modal_edit").modal("hide");
				$("#modal_del").modal({
					show:true,
					backdrop:'static'
				});
			});

			//CHAMA MODAL EDITAR AO SAIR DA MODAL DE EXCLUIR
			$(".close-del").click(function(){
				$("#modal_edit").modal('show');
			});

		});
	</script>
	<title><?=$main['name']?></title>
</head>
<body>
	<div class="container"> 		
	<?php $this->load->view("terminal/insert"); ?>
	<?php $this->load->view("terminal/edit"); ?>
	<?php $this->load->view("terminal/delete"); ?>
	<?php $this->load->view("layout/nav_bar"); ?>

	<div class="row">
		<div class="col-sm-12">			
			<h1 class="page-header"><i class="<?=$main['icon']?>"></i> <?=$main['name']?>
				<button class="btn btn-default pull-right" type="button" data-target="#modal_add" data-toggle="modal">Adicionar Terminal</button>
			</h1>
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
					<?php 
					if(count($terminais) > 0 ): ?>
					
						<table class="table table-hover" id="table">
							<thead>
								<tr>
									<th width="50px">Cód.</th>
									<th>Nome</th>
									<th>Sigla</th>
									<th style="text-align:center;">Meta (hs)</th>
									<th style="text-align:center;">Tarifa (R$)</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($terminais as $value): ?>
									<tr data-id="<?= $value['idterminal']?>">
										<td><?= $value['idterminal']?></td>
										<td class="nome<?=$value['idterminal']?>"><?= ucwords($value['nome_terminal'])?></td>
										<td class="sigla<?=$value['idterminal']?>"><?= $value['sigla_terminal']?></td>
										<td align="center" class="meta<?=$value['idterminal']?>"><?= $value['meta_operacao']?></td>
										<td align="center" class="tarifa<?=$value['idterminal']?>"><?= $value['valor_tarifa']?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>						
						</table>
						
					<?php else: ?>
						<div class="jumbotron">
						  <h1>Não há Terminais!</h1>
						  <p>Para adicionar um clique no botão abaixo.</p>
						  <p><a class="btn btn-primary btn-lg" href="#" data-target="#modal_add" data-toggle="modal" role="button">Adicionar Terminal</a></p>
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