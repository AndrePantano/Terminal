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
				
				$(".idusuario").val(id);
				
				// EDITAR DADOS
				$(".nome").val($(".nome"+id).text());
				$(".email").val($(".email"+id).text());
				
				if($(".ativo"+id).data("id") == "não"){
					$(".ativo-nao").prop("checked","true");
				}else{
					$(".ativo-sim").prop("checked","true");
				}
				
				//SELECIONA O OPTION DO SELECT DE TIPOS DE PERFIS
				var idperfil = $(".perfil"+id).data("id");			
				$(".perfil option[value='"+idperfil+"']").prop("selected","selected");

				// EXCLUIR DADOS
				$(".nome_del").text($(".nome"+id).text());
				$(".email_del").text($(".email"+id).text());
				$(".ativo_del").text($(".ativo"+id).text());
				$(".perfil_del").text($(".perfil"+id).text());

				$("#modal_edit").modal("show");

			});

			// CHAMA A MODAL DE RESET DE SENHA
			$("#btn_reset").click(function(){

				$("#modal_edit").modal("hide");
				$("#modal_reset").modal({
					show:true,
					backdrop:'static'
				});
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
	<?php $this->load->view("usuario/insert"); ?>
	<?php $this->load->view("usuario/edit"); ?>
	<?php $this->load->view("usuario/delete"); ?>
	<?php $this->load->view("usuario/reset"); ?>
	<?php $this->load->view("layout/nav_bar"); ?>

	<div class="row">
		<div class="col-sm-12">			
			<h1 class="page-header"><i class="<?=$main['icon']?>"></i> <?=$main['name']?>
				<button class="btn btn-default pull-right" type="button" data-target="#modal_add" data-toggle="modal">Adicionar Usuário</button>
			</h1>
		</div>
	</div>

	<div class="row">
		
		<div class="col-sm-12">

			<!-- LAYOUT DE MENSAGENS -->
			<?php $this->load->view("layout/message"); ?>
		
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading"></div>
						<div class="panel-body">
					<?php if(count($usuarios) > 0 ): ?>				
					
							<table class="table table-hover" id="table">
								<thead>
									<tr>
										<th width="50px">Cód.</th>
										<th>Nome</th>
										<th>Email</th>
										<th>Ativo</th>
										<th>Perfil</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($usuarios as $value): ?>
										<tr class="<?= $value['ativo'] =='sim'?'':'danger'?>" data-id="<?=$value["idusuario"]?>">
											<td><?= $value['idusuario']?></td>
											<td class="nome<?=$value['idusuario']?>"><?= ucwords($value['nome'])?></td>
											<td class="email<?=$value['idusuario']?>"><?= $value['email']?></td>
											<td class="ativo<?=$value['idusuario']?>" data-id="<?= $value['ativo']?>"><?= $value['ativo'] ?></td>
											<td class="perfil<?=$value['idusuario']?>" data-id="<?= $value['idperfil']?>"><?= $value['nome_perfil']?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>						
							</table>
						
					<?php else: ?>
						<div class="jumbotron">
						  <h1>Não há usuários!</h1>
						  <p>Para adicionar um clique no botão abaixo.</p>
						  <p><a class="btn btn-primary btn-lg" href="<?= base_url('ads/insert') ?>" role="button">Adicionar Usuário</a></p>
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