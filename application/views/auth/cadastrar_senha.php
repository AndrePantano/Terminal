<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php $this->load->view("layout/head"); ?>  
<title>Cadastrar Senha</title>
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
            <strong> Cadastrar Nova Senha</strong>
          </div>
          <div class="panel-body">
            <form role="form" action="<?= base_url('auth/nova_senha')?>" method="POST">
              <input name="idusuario" value="<?=$this->session->flashdata('idusuario')?>" type="hidden" required>
              <input name="token" value="<?=$this->session->flashdata('token')?>" type="hidden" required>
              <fieldset>                
                <div class="row">
            
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                    <p>Olá <?= ucwords($this->session->flashdata("nome"))?>!</p>
                    <p>Sua senha atual é a padrão, você precisa cadastrar uma nova senha para acessar o sistema.</p>
                  </div>

                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">

                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-lock"></i>
                        </span>
                        <input class="form-control" placeholder="senha" name="senha" type="password" required autofocus>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-lock"></i>
                        </span>
                        <input class="form-control" placeholder="confirme a senha" name="confirmar_senha" type="password" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-md btn-primary btn-block" value="Confirmar">
                    </div>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
          <div class="panel-footer text-center">
          </div>
        </div>
      </div>
    </div>

    <?php $this->load->view("layout/rodape"); ?>

  </div>    
</body>
</html>