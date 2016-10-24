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
				
				$(".idtipo_parada").val(id);
				
				// EDITAR DADOS
				$(".nome").val($(".nome"+id).text());
				$(".email").val($(".email"+id).text());
								
				//SELECIONA O OPTION DO SELECT DE TIPOS DE PERFIS
				var idterminal = $(".terminal"+id).data("id");			
				$(".terminal option[value='"+idterminal+"']").prop("selected","selected");

				// EXCLUIR DADOS
				$(".nome_del").text($(".nome"+id).text());				
				$(".terminal_del").text($(".terminal"+id).text());

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
	<?php $this->load->view("tipoparada/insert"); ?>
	<?php $this->load->view("tipoparada/edit"); ?>
	<?php $this->load->view("tipoparada/delete"); ?>
	<?php $this->load->view("layout/nav_bar"); ?>

	<div class="row">
		<div class="col-sm-12">
			<h1 class="page-header"><i class="<?=$main['icon']?>"></i> <?=$main['name']?>
				<button class="btn btn-default pull-right" type="button" data-target="#modal_add" data-toggle="modal">Adicionar Tipo de Parada</button>
			</h1>
		</div>
	</div>

	<div class="row">
		
		<div class="col-sm-12">

			<!-- LAYOUT DE MENSAGENS -->
			<?php $this->load->view("layout/message"); ?>
		
			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading"></div>
						<div class="panel-body">
					<?php if(count($tipos) > 0 ): ?>
					
						<table class="table table-hover" id="table">
							<thead>
								<tr>
									<th width="50px">Cód.</th>
									<th>Tipo de Parada</th>
									<th>Disponível em:</th>										
								</tr>
							</thead>
							<tbody>
								<?php foreach ($tipos as $value): ?>
									<tr data-id="<?= $value['idtipo_parada']?>">
										<td><?= $value['idtipo_parada']?></td>
										<td class="nome<?=$value['idtipo_parada']?>"><?= ucwords($value['nome_tipo_parada'])?></td>
										<td class="terminal<?=$value['idtipo_parada']?>" data-id="<?= $value['idterminal']?>"><?= ($value["idterminal"] == 0)?"Todos Terminais": $value['nome_terminal']?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>						
						</table>						
					<?php else: ?>
						<div class="jumbotron">
						  <h1>Não há Tipos de Parada!</h1>
						  <p>Para adicionar um clique no botão abaixo.</p>
						  <p><a class="btn btn-primary btn-lg" href="#" data-target="#modal_add" data-toggle="modal" role="button">Adicionar Tipo de Parada</a></p>
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