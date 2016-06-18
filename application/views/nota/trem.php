<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php $this->load->view("layout/head"); ?>  
  <title><?=$main['name']?></title>
  <script type="text/javascript">
    $(document).ready(function(){
      $(".add-parada").click(function(){
        $(".idoperacao").val($(this).data("operacao"));
        $(".numero_linha").text($(this).data("linha"));
        $("#modal_add_parada").modal().hide();
      });
    });
  </script>
</head>
<body>
  <div class="container">

    <?php $this->load->view("nota/insert"); ?>
    <?php $this->load->view("layout/nav_bar"); ?>
    <?php $this->load->view("layout/page_header"); ?>
    <?php $this->load->view("layout/message"); ?>
    <?php $this->load->view("layout/nav_tab"); ?>


    <!-- CABECALHO -->
    <div class="row">
      <div class="col-sm-12">
        <h3>
          <i class="fa fa-info-circle"></i> Notas de Atividades
          <button type="button" data-toggle="modal" data-target="#modal_add_nota" class="btn btn-default btn-sm pull-right" role="button">Adicionar</button>
        </h3>     
      </div>
    </div>

    <!-- PANEL -->
    <div class="row">
      <div class="col-sm-12">
            
          <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">
                
                <?php if($notas && count($notas) > 0):?>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th width="150px">Data</th>
                          <th>Atividade</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($notas as $nota): ?>
                          <tr>
                            <td><?= date("d/m/Y H:i",strtotime($nota['criacao_nota']))?></td>
                            <td><?= $nota['texto_nota']?></td>
                          </tr>
                        <?php endforeach;?> 
                      </tbody>            
                    </table>
                  </div>
                <?php else: ?>
                  <p>Não há notas lançadas</p>
                <?php endif; ?>
              
            </div>
            <div class="panel-footer"></div>
          </div>

      </div>
    </div>
    
    <?php $this->load->view("layout/rodape"); ?>

  </div>   
</body>
</html>

