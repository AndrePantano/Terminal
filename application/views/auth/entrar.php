<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php $this->load->view("layout/head"); ?>  
<title>Entrar</title>
</head>
<body>

  <div class="container"> 

    <div class="row">
    	<div class="col-sm-12">

    		<!-- LAYOUT DE MENSAGENS -->
    		<?php $this->load->view("layout/message"); ?>
    	</div>
    </div>

    <div class="row">
      <div class="col-sm-6 col-md-4 col-md-offset-4">
        <div class="panel panel-default">
          <div class="panel-heading text-center">
            <strong> Área de Acesso</strong>
          </div>
          <div class="panel-body">
            <form role="form" action="<?= base_url('auth/login')?>" method="POST">
              <fieldset>                
                <div class="row">
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                        </span> 
                        <input class="form-control" placeholder="usuário" name="usuario" type="text" autofocus required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-lock"></i>
                        </span>
                        <input class="form-control" placeholder="senha" name="senha" type="password" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-md btn-primary btn-block" value="Entrar">
                    </div>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
          <div class="panel-footer"></div>
        </div>
      </div>
    </div>

    <?php $this->load->view("layout/rodape"); ?>

  </div>    
</body>
</html>