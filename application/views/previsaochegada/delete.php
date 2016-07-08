<?php if(count($previsoes_chegada) > 1):?>
<div class="modal fade" tabindex="-1" role="dialog" id="modal_del_previsao">
  <div class="modal-dialog modal-md">
    
    <form class="form-horizontal" method="post" action="<?=base_url('previsaochegada/delete')?>">
      <input type="hidden" name="idtrem" value="<?=$trem['idtrem']?>">
      <input type="hidden" name="idprevisao" class="idprevisao" value="">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close close-del" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-trash"></i> Excluir Previsão de Chegada?</h4>
          </div>
          <div class="modal-body">
            
            <div class="row">
              <div class="col-sm-12">
                <div class="well well-sm">
                  <div class="row">
                    <div class="col-sm-2">
                      <span class="pull-right">Previsão:</span>
                    </div>
                    <div class="col-sm-10">
                      <span id="del_previsao"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-2">
                      <span class="pull-right">Motivo:</span>
                    </div>
                    <div class="col-sm-10">
                      <span id="del_motivo"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <p>Deseja continuar a exclusão?</p>
              </div>
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
<?php endif; ?>
