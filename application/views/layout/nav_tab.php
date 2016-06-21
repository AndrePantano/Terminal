
<?php 
	$url = $_SERVER["REQUEST_URI"];
	$url = explode("/",$url);
	//echo "<pre>".print_r($url,1)."</pre>";
?>
<div class="row">
	<div class="col-sm-12">
	<br/>
		<ul class="nav nav-tabs">
		  <li role="presentation" <?= $url[2] == "trens"?"class='active'":"" ?> ><a href="<?=base_url("trens/trem/".$trem['idtrem'])?>"><i class="fa fa-train"></i> Trem</a></li>
		  <li role="presentation" <?= $url[2] == "previsao"?"class='active'":"" ?> ><a href="<?=base_url("previsao/trem/".$trem['idtrem'])?>"><i class="fa fa-clock-o"></i> Previsão de Chegada</a></li>
		  <li role="presentation" <?= $url[2] == "operacao"?"class='active'":"" ?> ><a href="<?=base_url("operacao/trem/".$trem['idtrem'])?>"><i class="fa fa-cogs"></i> Previsões de Saída</a></li>
		  <li role="presentation" <?= $url[2] == "operacao"?"class='active'":"" ?> ><a href="<?=base_url("operacao/trem/".$trem['idtrem'])?>"><i class="fa fa-cogs"></i> Operações</a></li>
		  <li role="presentation" <?= $url[2] == "nota"?"class='active'":"" ?> ><a href="<?=base_url("nota/trem/".$trem['idtrem'])?>"><i class="fa fa-info-circle"></i> Notas de Atividades</a></li>
		  <li role="presentation" <?= $url[2] == "nota"?"class='active'":"" ?> ><a href="<?=base_url("nota/trem/".$trem['idtrem'])?>"><i class="fa fa-info-circle"></i> Avarias de Vagões</a></li>
		  <li role="presentation" <?= $url[2] == "nota"?"class='active'":"" ?> ><a href="<?=base_url("nota/trem/".$trem['idtrem'])?>"><i class="fa fa-info-circle"></i> Avarias de Conteiners</a></li>
		</ul>
		<br/>
	</div>
</div>