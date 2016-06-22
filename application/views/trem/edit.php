<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_trem">
  <div class="modal-dialog">
    
        <form class="form-horizontal" method="post" action="<?=base_url('trem/update')?>">
          <input name="idtrem" type="hidden" value="<?=$trem['idtrem']?>" required="">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Dados</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
            <label class="col-md-4 control-label" for="trem">Prefixo do Trem</label>  
            <div class="col-md-8">
              <input id="trem" name="trem" type="text" placeholder="Trem" value="<?=$trem['prefixo_trem']?>" class="form-control input-md" pattern="[A-Z a-z]{1}[0-9]{2}" required="" minlength="3" maxlength="3">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-4 control-label" for="previsao">Chegada do trem:</label>  
            <div class="col-md-8">
              <input name="chegada" type="datetime-local" value="<?=is_null($trem['chegada_trem'])?"":date("Y-m-d\TH:i:s", strtotime($trem['chegada_trem']))?>" class="form-control input-md">
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-md-4 control-label" for="previsao">Partida do trem:</label>  
            <div class="col-md-8">
              <input name="partida" type="datetime-local" value="<?=is_null($trem['partida_trem'])?"":date("Y-m-d\TH:i:s", strtotime($trem['partida_trem']))?>" class="form-control input-md">
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


          

        

      

    