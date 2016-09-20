<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php $this->load->view("layout/head"); ?>  
  <title><?=$main['name']?></title>
  <script type="text/javascript">
    $(document).ready(function(){
            
      $("tr").click(function(){
        var id = $(this).data("id");

        $(".idavaria").val(id);
        $(".vagao").val($(".vagao"+id).text());
        $(".del_vagao").text($(".vagao"+id).text());
        $(".descricao").val($(".descricao"+id).text());
        $(".del_descricao").text($(".descricao"+id).text());

        $("#modal_edit").modal({show:true});
      });

      $("#btn_del").click(function(){
        $("#modal_edit").modal().hide();       
        $("#modal_del").modal({
          show:true,
          backdrop:'static'
        });
      });

      $(".close-del").click(function(){
        $("#modal_edit").modal().show();
      });

    });
  </script>
</head>
<body>
  <div class="container">
    <?php if($this->session->userdata('idperfil')!=3):?>
      <?php $this->load->view("avariavagao/insert");?>
      <?php $this->load->view("avariavagao/edit");?>
      <?php if($this->session->userdata('idperfil')==1){$this->load->view("avariavagao/delete");}?>
    <?php endif; ?>

    <?php $this->load->view("layout/nav_bar");?>
    <?php $this->load->view("layout/page_header");?>
    <?php $this->load->view("layout/message");?>
    <?php $this->load->view("layout/nav_tab");?>


    <!-- CABECALHO -->
    <div class="row">
      <div class="col-sm-8">
        <h3>
          <i class="fa fa-warning"></i> Avarias de Vagão <span class="badge"><?= $avarias ? count($avarias) : 0?></span>
          <?php if($this->session->userdata('idperfil')!=3):?>
            <button type="button" data-toggle="modal" data-target="#modal_add" class="btn btn-default btn-sm pull-right" role="button">Adicionar</button>
          <?php endif; ?>

        </h3>     
      </div>
    </div>

    <!-- PANEL -->
    <div class="row">
      <div class="col-sm-8">
            
          <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">
                
                <?php if($avarias && count($avarias) > 0):?>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th width="115px">Vagão</th>
                          <th>Descrição da Avaria</th>
                          <?php if($this->session->userdata('idperfil')==1):?>
                            <th width="120px">Alterado por:</th>
                          <?php endif; ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($avarias as $avaria): ?>
                          <tr data-id="<?=$avaria['idavaria']?>">
                            <td class="vagao<?=$avaria['idavaria']?>"><?= $avaria['vagao']?></td>
                            <td class="descricao<?=$avaria['idavaria']?>"><?= $avaria['descricao']?></td>
                            <?php if($this->session->userdata('idperfil')==1):?>
                               <td><?= ucwords($avaria["nome"])?></td>
                            <?php endif; ?>
                          </tr>
                        <?php endforeach;?> 
                      </tbody>            
                    </table>
                  </div>
                <?php else: ?>
                  <p>Não há avarias lançadas</p>
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

