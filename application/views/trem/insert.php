<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_trem">
  <div class="modal-dialog">
    
        <form class="form-horizontal" method="post" action="<?=base_url('trem/create')?>">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-plus"></i> Adicionar Trem</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
            <label class="col-md-4 control-label" for="trem">Prefixo do Trem</label>  
            <div class="col-md-8">
              <input id="trem" name="trem" type="text" placeholder="Trem" class="form-control input-md" pattern="[A-Z a-z]{1}[0-9]{2}" required="" minlength="3" maxlength="3">
              <span class="help-block">Informe o prefixo do Trem, contendo um letra e dois números, ex: "C62"</span>  
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-4 control-label" for="quantidade">Qtde. Vagões</label>  
            <div class="col-md-8">
              <input id="quantidade" name="quantidade" type="number" placeholder="0"  class="form-control input-md" required="" maxlength="2" min="0" max="99">
              <span class="help-block">Informe a quantidade de vagões deste Trem.</span>  
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-4 control-label" for="previsao">Previsão de Chegada</label>  
            <div class="col-md-8">
              <input id="previsao" name="previsao" type="datetime-local" class="form-control input-md" required="">
              <span class="help-block">Informe a data de chegada prevista deste Trem.</span>  
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


          

        

      

    