<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_parada">
  <div class="modal-dialog modal-sm">
    <form class="form-horizontal" method="post" action="<?=base_url('parada/update')?>">
      <input name="idparada" class="idparada" type="hidden" value="" required="">
      <input name="idtrem" type="hidden" value="<?=$trem['idtrem']?>" required>
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-edit"></i> Parada <span class="ordem_parada"></span> da Linha <span class="linha_operacao"></span></h4>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-sm-12">

                  <div class="form-group">
                    <label class="col-md-12">Tipo da Parada:</label>  
                    <div class="col-md-12">
                      <select name="idtipo_parada" id="edit_tipo_parada" class="form-control input-md" required>
                      <option value="">Selecione uma opção</option>
                      <?php foreach($tipos_paradas as $tipo_parada):?>
                        <option value="<?=$tipo_parada['idtipo_parada']?>"><?=strtoupper($tipo_parada['nome_tipo_parada'])?></option>
                      <?php endforeach; ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-12">Início da Parada:</label>  
                    <div class="col-md-12">
                      <input name="inicio" type="datetime-local" value="" id="edit_inicio_parada" required class="form-control input-md">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-12">Fim da Parada:</label>  
                    <div class="col-md-12">
                      <input name="fim" type="datetime-local" value="" id="edit_fim_parada" required class="form-control input-md">
                    </div>
                  </div>
             
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <?php if($this->session->userdata('idperfil')==1):?>
              <button type="button" class="btn btn-default pull-left" id="btn_del_parada">Excluir</button>
            <?php endif;?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>

        </div><!-- /.modal-content -->

    </form>

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->