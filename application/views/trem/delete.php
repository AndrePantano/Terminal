<!-- MODAL EXCLUIR -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_del_trem">
  <div class="modal-dialog">
    
    <form class="form-horizontal" method="post" action="<?=base_url('trem/delete')?>">
          <input name="idtrem" type="hidden" value="<?=$trem['idtrem']?>" required="">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-trash"></i> Excluir Trem</h4>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-sm-12">

                <div class="well well-sm">

                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pull-right">Prefixo do Trem</span>  
                     </div>
                    <div class="col-sm-6">
                      <span><?=$trem['prefixo_trem']?></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pull-right">Chegada do trem:</span>
                    </div> 
                    <div class="col-sm-6">
                      <span><?=is_null($trem['chegada_trem'])?"":date("Y-m-d\TH:i:s", strtotime($trem['chegada_trem']))?></span>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pull-right">Partida do trem:</span>
                    </div>
                    <div class="col-sm-6">
                      <span><?=is_null($trem['partida_trem'])?"":date("Y-m-d\TH:i:s", strtotime($trem['partida_trem']))?></span>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <h4>Atenção!</h4>
                <p>Ao remover o trem, todos os dados como: Previsões, Operações, Paradas e Notas de Atividades associadas a ele serão removidas também.</p>
                <p>Deseja continuar a exclusão deste trem?</p>
              </div>              
            </div>
          </div>
          <div class="modal-footer">      
            <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
            <button type="submit" class="btn btn-primary">Sim</button>
          </div>

        </div><!-- /.modal-content -->
    </form>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
