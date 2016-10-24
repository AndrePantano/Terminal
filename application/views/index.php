<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php $this->load->view("layout/head"); ?>  
<title>Terminal</title>
</head>
<body>
  <div class="container"> 

<?php $this->load->view("layout/nav_bar"); ?>

<div class="row">
	<div class="col-sm-12">

		<!-- LAYOUT DE MENSAGENS -->
		<?php $this->load->view("layout/message"); ?>
	</div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="jumbotron">
            <?php if($this->session->has_userdata("idterminal")):?>
              <h2><i class="fa fa-thumbs-up"></i> Ok! Você está na <?= $this->session->userdata("nome_terminal")?>.</h2>
              <p>Utilize o menu superior para obter mais informações dos trens deste terminal.</p>
            <?php else: ?>
              <h2>Ol&aacute; <?= $this->session->userdata("nome")?>!</h2>
              <p class="text-muted">Seja bem vindo ao Sistema de Movimentação de Trens.</p>
              <p class="text-muted">Selecione um terminal acima para ter mais informações.</p>
            <?php endif; ?>            
        </div>        
    </div>    
</div>

<?php $this->load->view("layout/rodape"); ?>

</div>    
</body>
</html>