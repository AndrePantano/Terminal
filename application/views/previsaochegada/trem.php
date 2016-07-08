<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php $this->load->view("layout/head"); ?> 	
	<title><?=$main['name']?></title>
	<script type="text/javascript">
		$(document).ready(function(){
			
			$("tr").click(function(){
				var id = $(this).data("id");
				$(".idprevisao").val(id);
				$("#edit_previsao").val($(".data-prev"+id).data("previsao"));
				$("#edit_motivo").val($(".motivo-prev"+id).text());
				$("#del_previsao").text($(".data-prev"+id).text());
				$("#del_motivo").text($(".motivo-prev"+id).text());
				$("#modal_edit_previsao").modal({show:true});
			});

			$("#btn-excluir").click(function(){
				$("#modal_edit_previsao").modal().hide();				
				$("#modal_del_previsao").modal({
					show:true,
					backdrop:'static'
				});
			});

			$(".close-del").click(function(){
				$("#modal_edit_previsao").modal().show();
			});

		});
	</script>
</head>
<body>
	<div class="container">
		<?php if($this->session->userdata('idperfil')!=3):?>
			<?php $this->load->view("previsaochegada/insert"); ?>
			<?php $this->load->view("previsaochegada/edit"); ?>
			<?php if($this->session->userdata('idperfil')==1){$this->load->view("previsaochegada/delete"); }?>
		<?php endif; ?>

		<?php $this->load->view("layout/nav_bar"); ?>
		<?php $this->load->view("layout/page_header"); ?>
		<?php $this->load->view("layout/message"); ?>
		<?php $this->load->view("layout/nav_tab"); ?>


		<!-- CABECALHO -->
		<div class="row">
			<div class="col-sm-8">
				<h3><i class="fa fa-clock-o"></i> Previsões de Chegada
					<?php if($this->session->userdata('idperfil')!=3):?>
						<button type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#modal_add_previsao">Adicionar</button>
					<?php endif; ?>
				</h3>
			</div>
		</div>
		<!-- PANEL -->
		<div class="row">
			<div class="col-sm-8">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingPrevisao">
											
					</div>
					<div class="panel-body">
						<?php if($previsoes_chegada && count($previsoes_chegada) > 0): ?>								
							<div class="table-responsive">
								
								<table class="table table-hover">
									<thead>
										<tr>
											<th width="150px">Previsão</th>
											<th>Motivo</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($previsoes_chegada as $previsao): ?>
											<tr data-id="<?= $previsao['idprevisao']?>">
												<td class="data-prev<?= $previsao['idprevisao']?>" data-previsao="<?=date('Y-m-d\TH:i',strtotime($previsao['data_previsao']))?>"><?= date("d/m/Y H:i",strtotime($previsao['data_previsao']))?></td>
												<td class="motivo-prev<?= $previsao['idprevisao']?>"><?= $previsao['motivo_previsao']?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>						
								</table>
							</div>
						<?php else: ?>
							<p>Não há previsões lançadas</p>
						<?php endif; ?>
					</div>								
					<div class="panel-footer"></div>
				</div>
			</div>
		</div>	
		
		<?php $this->load->view("layout/rodape"); ?>

	</div>   
</body>
</html>

