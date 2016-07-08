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
        $(".conteiner").val($(".conteiner"+id).text());
        $(".del_conteiner").text($(".conteiner"+id).text());
        $(".observacao").val($(".observacao"+id).text());
        $(".del_observacao").text($(".observacao"+id).text());

        //SELECIONA O OPTION DO SELECT DE TIPOS DE PARADAS
        var idgrupo = $(".grupo_avaria"+id).data("id");      
        $(".edit_grupo_avaria option[value='"+idgrupo+"']").prop("selected","selected");
        $(".del_grupo_avaria").text($(".grupo_avaria"+id).data("nome"));
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
      <?php $this->load->view("avariaconteiner/insert");?>
      <?php $this->load->view("avariaconteiner/edit");?>
      <?php if($this->session->userdata('idperfil')==1){$this->load->view("avariaconteiner/delete");}?>
    <?php endif; ?>

    <?php $this->load->view("layout/nav_bar");?>
    <?php $this->load->view("layout/page_header");?>
    <?php $this->load->view("layout/message");?>
    <?php $this->load->view("layout/nav_tab");?>


    <!-- CABECALHO -->
    <div class="row">
      <div class="col-sm-8">
        <h3>
          <i class="fa fa-warning"></i> Avarias de Conteiner <span class="badge"><?= $avarias ? count($avarias) : 0?></span>
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
                          <th width="115px">Conteiner</th>
                          <th>Avaria</th>
                          <th>Observação</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($avarias as $avaria): ?>
                          <tr data-id="<?=$avaria['idavaria']?>">
                            <td class="conteiner<?=$avaria['idavaria']?>"><?= $avaria['conteiner']?></td>
                            <td class="grupo_avaria<?=$avaria['idavaria']?>" data-nome="<?=$avaria['nome_avaria']?>" data-id="<?=$avaria['idgrupo_avaria_conteiner']?>"><?= $avaria['nome_avaria']?></td>
                            <td class="observacao<?=$avaria['idavaria']?>"><?= $avaria['observacao']?></td>
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

