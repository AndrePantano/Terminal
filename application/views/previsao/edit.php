<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_previsao">
  <div class="modal-dialog">
    
    <form class="form-horizontal" method="post" action="<?=base_url('previsao/update')?>">
      <input type="hidden" name="idtrem" value="<?=$trem['idtrem']?>">
      <input type="hidden" name="idprevisao" class="idprevisao" value="">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-edit"></i> Previsão de Chegada</h4>
          </div>
          <div class="modal-body">

            <div class="form-group">
              <label class="col-md-4 control-label" for="previsao">Previsão:</label>  
              <div class="col-md-8">
                <input name="previsao" id="edit_previsao" type="datetime-local" class="form-control input-md" required="">
                <span class="help-block">Informe a data de chegada prevista deste Trem.</span>  
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label" for="motivo">Motivo:</label>  
              <div class="col-md-8">
                <textarea name="motivo" id="edit_motivo" required class="form-control input-md" ></textarea>
                <span class="help-block">Informe o motivo da nova previsão.</span>  
              </div>
            </div>


          </div>
          <div class="modal-footer">            
            <button type="button" class="btn btn-default pull-left" id="btn-excluir">Excluir</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>

        </div><!-- /.modal-content -->

    </form>

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


          

        

      

    