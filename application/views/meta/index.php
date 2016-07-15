<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php $this->load->view("layout/head"); ?> 

  <title><?=$main['name']?></title>
</head>
<body>
  <div class="container">
  
  <?php foreach ($metas as $meta): ?>

    <div class="modal fade" tabindex="-1" role="dialog" id="modal_meta<?=$meta['idmeta']?>">
      <div class="modal-dialog">
          <form class="form-horizontal" method="post" action="<?=base_url('meta/update')?>">
            <input type="hidden" name="idmeta" value="<?=$meta['idmeta']?>">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close close-del" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><i class="fa fa-edit"></i> Atualizar Meta <?=ucwords($meta['nome_meta'])?></h4>
            </div>
            <div class="modal-body">

              <div class="form-group">
                <label class="col-md-3 control-label">Meta <?=ucwords($meta['nome_meta'])?>:</label>  
                  <div class="col-sm-3">
                    <div class="input-group">
                      <input type="number" name="valor_meta" value="<?= $meta['valor_meta'] ?>" required class="form-control" placeholder="0" min="1" max="99" maxlenght="2"/>
                      <span class="input-group-addon">hs</i></span> 
                    </div>
                    <span class="help-block">Informe um valor.</span>  
                  </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default close-del" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>

          </div><!-- /.modal-content -->

        </form>

      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

  <?php endforeach;?>

  <!-- LAYOUT DE MENSAGENS -->
  <?php $this->load->view("layout/message"); ?>

  <!-- LAYOUT DA NAVBAR -->
  <?php $this->load->view("layout/nav_bar"); ?>

  <div class="row">
    <div class="col-sm-12">     
      <h1 class="page-header"><i class="<?=$main['icon']?>"></i> <?=$main['name']?></h1>
    </div>
  </div>
 

  <div class="row">    
      <?php foreach ($metas as $meta): ?>
      <div class="col-sm-4">
        <div class="well well-sm">
          <h4><?= ucwords($meta["nome_meta"])?></h4>
          <p><?= $meta["valor_meta"]?>hs</p>
          <p>Atualizado em: <?= date("d/m/Y",strtotime($meta["criado_em"]))?></p>
        </div>
        <p><button type="button" class="btn btn-default" data-target="#modal_meta<?=$meta['idmeta']?>" data-toggle="modal">Editar</button>
      </div>
      <?php endforeach;?>
  </div>

  <?php $this->load->view("layout/rodape"); ?>

</div>    
</body>
</html>