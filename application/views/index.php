<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php $this->load->view("layout/head"); ?>  
<title>Início</title>
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
            <h1>Ol&aacute;! Seja bem vindo.</h1>
            <p class="text-muted">A planilha do terminal está ganhando um novo formato.</p>
        </div>
    </div>
</div>

<?php $this->load->view("layout/rodape"); ?>

</div>    
</body>
</html>