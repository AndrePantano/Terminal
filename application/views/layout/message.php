<?php if($this->session->flashdata("class")): ?>
				
	<div class="row" id="mensagem">
		<div class="col-sm-12">
			<div class="alert alert-<?=$this->session->flashdata('class')?> alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  	<span aria-hidden="true">&times;</span>
			  </button>
			  <h3><?=$this->session->flashdata('title')?></h3> 
			  <p><?=$this->session->flashdata('content')?><p>
			</div>
		</div>
	</div>

	<script>
	$('#mensagem').delay(3000).fadeOut('slow');
	</script>	
	
<?php endif;?>	