
<?php 
	$url = explode("/", $_SERVER["REQUEST_URI"]);
	//echo "<pre>".print_r($url,1)."</pre>";

?>

<div class="panel panel-default">
	<div class="panel-heading">
		<label><i class="fa fa-filter"></i> Filtros</label>
		<span class="pull-right">
		<a href="<?= base_url('search')?>" class="btn btn-default btn-sm" title="Desfazer filtros"><i class="fa fa-undo"></i></a>
		</span>
	</div>
	<div class="panel-body">
		<div class="list-group">
			
		<!-- FILTRO DE AÇÕES -->
			<h4>Ações</h4>
			<?php foreach ($filters['actions'] as $k => $action): 
				if($url[2] == 'search_for'):?>

					<a class="list-group-item" href="<?= base_url('search_for/'.$k.'/'.$url[4].'/'.$url[5]) ?>" /><?= $action ?></a>
				<?php else:?>
					<a class="list-group-item" href="<?= base_url('search_for/'.$k.'/null/null') ?>" /><?= $action ?></a>
			
			<?php endif;
			endforeach;?>
			
		<!-- MOSTRA TODAS AS AÇÕES -->
			<?php if($url[2] == 'search_for' && $url[3] != 'null'):?>
				<a href="<?= base_url('search_for/null/'.$url[4].'/'.$url[5]) ?>" />Mostrar Tudo</a>
			<?php endif; ?>

		<!-- FILTRO DE CATEGORIAS -->
			<h4>Categorias</h4>
			<?php foreach ($filters['categories'] as $k => $category): 
				if($url[2] == 'search_for'):?>

				<a class="list-group-item" href="<?= base_url('search_for/'.$url[3].'/'.$k.'/'.$url[5]) ?>" /><?= $category ?></a>
				<?php else:?>
				<a class="list-group-item" href="<?= base_url('search_for/null/'.$k.'/null') ?>" /><?= $category ?></a>
			
			<?php endif;
			endforeach;?>

		<!-- MOSTRA TODAS AS CATEGORIAS -->
			<?php if($url[2] == 'search_for' && $url[4] != 'null'):?>
				<a href="<?= base_url('search_for/'.$url[3].'/null/'.$url[5]) ?>" />Mostrar Tudo</a>
			<?php endif; ?>

		<!-- FILTRO DE CIDADES -->
			<h4>Cidades</h4>
			<?php foreach ($filters['cities'] as $k => $city): 
				if($url[2] == 'search_for'):?>

				<a class="list-group-item" href="<?= base_url('search_for/'.$url[3].'/'.$url[4].'/'.$k) ?>" /><?= $city ?></a>
				<?php else:?>
				<a class="list-group-item" href="<?= base_url('search_for/null/null/'.$k) ?>" /><?= $city ?></a>
			<?php endif;
			endforeach;?>

		<!-- MOSTRA TODAS AS CIDADES -->
			<?php if($url[2] == 'search_for' && $url[5] != 'null'):?>
				<a href="<?= base_url('search_for/'.$url[3].'/'.$url[4].'/null/') ?>" />Mostrar Tudo</a>
			<?php endif; ?>

		</div>		
	</div>
	<div class="panel-footer"></div>
</div>