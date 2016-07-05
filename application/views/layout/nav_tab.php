
<?php 
	$url = $_SERVER["REQUEST_URI"];
	$url = explode("/",$url);
?>
<div class="row">
	<div class="col-sm-12">
	<br/>
		<ul class="nav nav-tabs">
		  <li role="presentation" <?= $url[2] == "trem"?"class='active'":"" ?> ><a href="<?=base_url("trem/trem/".$trem['idtrem'])?>"><i class="fa fa-train"></i> Trem</a></li>
		  <li role="presentation" <?= $url[2] == "previsao_chegada"?"class='active'":"" ?> ><a href="<?=base_url("previsao_chegada/trem/".$trem['idtrem'])?>"><i class="fa fa-arrow-down"></i> Previsão de Chegada</a></li>
		  <li role="presentation" <?= $url[2] == "previsao_saida"?"class='active'":"" ?> ><a href="<?=base_url("previsao_saida/trem/".$trem['idtrem'])?>"><i class="fa fa-arrow-up"></i> Previsões de Saída</a></li>
		  <li role="presentation" <?= $url[2] == "operacao"?"class='active'":"" ?> ><a href="<?=base_url("operacao/trem/".$trem['idtrem'])?>"><i class="fa fa-cogs"></i> Operações</a></li>
		  <li role="presentation" <?= $url[2] == "nota"?"class='active'":"" ?> ><a href="<?=base_url("nota/trem/".$trem['idtrem'])?>"><i class="fa fa-info-circle"></i> Notas de Atividades</a></li>
		  <li role="presentation" <?= $url[2] == "avaria_conteiner"?"class='active'":"" ?> ><a href="<?=base_url("avaria_conteiner/trem/".$trem['idtrem'])?>"><i class="fa fa-warning"></i> Avarias de Conteiners</a></li>
		  <li role="presentation" <?= $url[2] == "avaria_vagao"?"class='active'":"" ?> ><a href="<?=base_url("avaria_vagao/trem/".$trem['idtrem'])?>"><i class="fa fa-warning"></i> Avarias de Vagão</a></li>
		</ul>
		<br/>
	</div>
</div>