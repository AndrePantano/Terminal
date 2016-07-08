<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit">
  <div class="modal-dialog">
    
    <form class="form-horizontal" method="post" action="<?=base_url('avariavagao/update')?>">
      <input type="hidden" name="idtrem" value="<?=$trem['idtrem']?>">
      <input type="hidden" name="idavaria" class="idavaria" value="">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-edit"></i> Atualizar Avaria de Vagao</h4>
          </div>
          <div class="modal-body">
  
            <div class="form-group">
              <label class="col-md-3 control-label">Vagão:</label>  
              <div class="col-md-6">
                <input type="text" name="vagao" required class="form-control input-md vagao" placeholder="PCT1234567" pattern="[a-z A-Z]{3}[0-9]{7}" maxlength="10"/>
                <span class="help-block">Informe o prefixo do vagão.</span>  
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">Descrição:</label>  
              <div class="col-md-9">
                <textarea name="descricao" class="form-control input-md descricao" required></textarea>
                <span class="help-block">Informe a descrição da avaria.</span>  
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <?php if($this->session->userdata('idperfil')==1):?>
              <button type="button" class="btn btn-default pull-left" id="btn_del">Excluir</button>
            <?php endif;?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>

        </div><!-- /.modal-content -->

    </form>

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


          

        

      

    