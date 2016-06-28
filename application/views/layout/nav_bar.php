<!-- INCLUI A MODAL DE ADICIONAR O TREM -->
<?php $this->load->view("trem/insert"); ?>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo base_url('/')?>">
        <i class="fa fa-industry"></i>
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">      
      <ul class="nav navbar-nav navbar-left">                                              
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-train"></i> Trens <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php if($this->session->userdata('idperfil')!=3):?>
              <li><a href="#" data-target="#modal_add_trem" data-toggle="modal" role="button"><i class="fa fa-plus"></i> Adicionar Trem</a></li>
            <li class="divider"></li>
            <?php endif; ?>
            <li><a href="<?= base_url('trens/em_transito')?>"><i class="fa fa-road"></i> Em Trânsito</a></li>
            <li><a href="<?= base_url('trens/em_operacao')?>"><i class="fa fa-square-o"></i> Em operação</a></li>
            <li><a href="<?= base_url('trens/operados')?>"><i class="fa fa-check-square-o"></i> Operados</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bar-chart"></i> Relatórios <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?= base_url('relatorios/permanencia')?>"><i class="fa fa-line-chart"></i> Tempo de Permanência</a></li>
            <li><a href="#"><i class="fa fa-pie-chart"></i> Por Trens</a></li>
            <li><a href="#"><i class="fa fa-pie-chart"></i> Por Tempo de Parada</a></li>
            <li><a href="#"><i class="fa fa-pie-chart"></i> Por Tempo de Saída</a></li>
          </ul>
        </li>
      </ul>

      <!-- NAVBAR RIGHT -->
      <ul class="nav navbar-nav navbar-right">                                              
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> <?=ucwords($this->session->userdata("nome"))?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?= base_url('auth/logout')?>"><i class="fa fa-sign-out"></i> Sair</a></li>
          </ul>
        </li>        
      </ul>

    </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->
</nav>