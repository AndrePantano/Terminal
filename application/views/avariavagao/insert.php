<div class="modal fade" tabindex="-1" role="dialog" id="modal_add">
  <div class="modal-dialog">
    
    <form class="form-horizontal" method="post" action="<?=base_url('avariavagao/create')?>">
      <input type="hidden" name="idtrem" value="<?=$trem['idtrem']?>">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-plus"></i> Adicionar Avaria de Vagão</h4>
          </div>
          <div class="modal-body">
  
            <div class="form-group">
              <label class="col-md-3 control-label">Vagão:</label>  
              <div class="col-md-6">
                <input type="text" name="vagao" required class="form-control input-md" placeholder="PCT1234567" pattern="[a-z A-Z]{3}[0-9]{7}" maxlength="10"/>
                <span class="help-block">Informe o prefixo do vagão.</span>  
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">Descrição:</label>  
              <div class="col-md-9">
                <textarea name="descricao" class="form-control input-md" required></textarea>
                <span class="help-block">Informe a descrição da avaria.</span>  
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>

        </div><!-- /.modal-content -->

    </form>

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


          

        

      

    