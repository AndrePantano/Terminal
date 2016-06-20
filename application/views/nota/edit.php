<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_nota">
  <div class="modal-dialog">
    
        <form class="form-horizontal" method="post" action="<?=base_url('nota/update')?>">
          <input type="hidden" name="idtrem" value="<?=$trem['idtrem']?>">
          <input type="hidden" name="idnota" class="idnota" value="">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-edit"></i> Nota de atividade</h4>
          </div>
          <div class="modal-body">

            <div class="form-group">
              <label class="col-md-2 control-label" for="texto">Texto:</label>  
              <div class="col-md-10">
                <textarea name="texto" required="" class="form-control input-md" id="edit_texto_nota"></textarea>
                <span class="help-block">Informe o conteúdo da nota de atividade.</span>  
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


          

        

      

    