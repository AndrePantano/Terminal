<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php $this->load->view("layout/head"); ?> 	
	<title><?=$main['name']?></title>	
</head>
<body>
	<div class="container">
		<?php if($this->session->userdata('idperfil')!=3):?>
			<?php $this->load->view("trem/edit"); ?>
			<?php if($this->session->userdata('idperfil')==1){$this->load->view("trem/delete"); }?>
		<?php endif; ?>

		<?php $this->load->view("layout/nav_bar"); ?>
		<?php $this->load->view("layout/page_header"); ?>
		<?php $this->load->view("layout/message"); ?>
		<?php $this->load->view("layout/nav_tab"); ?>

		<!-- CABECALHO -->
		<div class="row">
			<div class="col-sm-6">
				<h3>
					<i class="fa fa-train"></i> Trem
					<?php if($this->session->userdata('idperfil')!=3):?>
						<div class="btn-group pull-right">
							<?php if($this->session->userdata('idperfil')==1):?>
								<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_del_trem">Excluir Trem</button>
							<?php endif;?>
							<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_edit_trem">Editar Dados</button>
						</div>
					<?php endif;?>
				</h3>
			</div>
		</div>
		<!-- PAINEL -->
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading"></div>
					<div class="panel-body">
						<div class="row">

							<div class="col-sm-12">
								<label class="col-sm-6" style="text-align:right;">Prefixo do Trem:</label>
								<span class="col-sm-6"><?=$trem["prefixo_trem"]?></span>
							</div>
							<div class="col-sm-12">
								<label class="col-sm-6" style="text-align:right;">Previsão de Chegada</label>
							 	<?= $previsoes && count($previsoes) > 0?"<span class='col-sm-6'>".date("d/m/Y H:i",strtotime($previsoes[count($previsoes)-1]["data_previsao"]))."</span>":"<span class='col-sm-6 text-danger'>Aguardando Dados</span>"?></span>
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
								<?php 
								if(is_null($trem["chegada_trem"]) || is_null($trem["partida_trem"])){
									echo "<span class='col-sm-6 text-danger'>Aguardando Dados</span>";
								}else{
									echo $trem["dias"] > 0 ? $trem["dias"]." dias, ":"";
									echo $trem["horas"] > 0 ? $trem["horas"]." hs, ":"";
									echo $trem["minutos"] > 0 ? $trem["minutos"]." min.":"";
								}?>
							</div>							
						</div>
					</div>
					<div class="panel-footer"></div>
				</div>	
			</div>
			<div class="col-sm-12">
				<p class="text-muted">O tempo de permanência é calculado somente quando há data de chegada e partida do trem.</p>
			</div>
		</div>	

		<?php $this->load->view("layout/rodape"); ?>

	</div>   
</body>
</html>

