
<?php 
	$url = explode("/", $_SERVER["REQUEST_URI"]);
	//echo "<pre>".print_r($url,1)."</pre>";
?>

<div class="panel panel-default">
	<div class="panel-heading"></div>

	<div class="list-group">
		<a href="<?= base_url('profile/')?>" class="list-group-item <?= count($url) > 1 && $url[1] == "profile"? 'active':''?>"><i class="fa fa-home fa-2x"></i> Início</a>
		<a href="<?= base_url('ads/')?>" 	 class="list-group-item <?= count($url) > 1 && $url[1] == "ads"? 'active':''?>"><i class="fa fa-files-o fa-2x"></i> Meus Anúncios</a>
		<a href="<?= base_url('comment/')?>" class="list-group-item"><i class="fa fa-comments-o fa-2x"></i> Minhas Mensagens</a>
		<?php if($this->session->userdata("id") == 1):?>
			<a href="<?= base_url('users/')?>" 	 class="list-group-item <?= count($url) > 1 && $url[1] == "users"? 'active':''?>"><i class="fa fa-users fa-2x"></i> Usuários</a>		
			<a href="" class="list-group-item"><i class="fa fa-thumbs-down fa-2x"></i> Denúncias</a>
		<?php endif; ?>
	</div>
	<div class="panel-footer"></div>
</div>