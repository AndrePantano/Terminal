<div class="modal fade" tabindex="-1" role="dialog" id="modal_del">
  <div class="modal-dialog">
    
        <form class="form-horizontal" method="post" action="<?=base_url('avariaconteiner/delete')?>">
          <input type="hidden" name="idtrem" value="<?=$trem['idtrem']?>">
          <input type="hidden" name="idavaria" class="idavaria" value="">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close close-del" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-trash"></i> Excluir Avaria de Conteiner?</h4>
          </div>
          <div class="modal-body">

            <div class="form-group">
              <span class="col-sm-3">Conteiner:</span>  
              <span class="col-sm-9 del_conteiner"></span>  
            </div>

            <div class="form-group">
              <span class="col-sm-3">Grupo Avaria:</span>  
              <span class="col-sm-9 del_grupo_avaria"></span>  
            </div>

            <div class="form-group">
              <span class="col-sm-3">Observação:</span>  
              <span class="col-sm-9 del_observacao"></span>  
            </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default close-del" data-dismiss="modal">Não</button>
            <button type="submit" class="btn btn-primary">Sim</button>
          </div>

        </div><!-- /.modal-content -->

    </form>

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


          

        

      

    