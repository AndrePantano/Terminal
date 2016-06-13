<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_nota">
  <div class="modal-dialog">
    
        <form class="form-horizontal" method="post" action="<?=base_url('nota/create')?>">
          <input type="hidden" name="idtrem" value="<?=$trem['idtrem']?>">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-plus"></i> Adicionar Nota</h4>
          </div>
          <div class="modal-body">

            <div class="form-group">
              <label class="col-md-2 control-label" for="motivo">Texto:</label>  
              <div class="col-md-10">
                <textarea name="texto" required="" class="form-control input-md"></textarea>
                <span class="help-block">Informe o conteúdo da nota de atividade.</span>  
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


          

        

      

    