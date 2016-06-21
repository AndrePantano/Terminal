<div class="modal fade" tabindex="-1" role="dialog" id="modal_del_parada">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" method="post" action="<?=base_url('parada/delete')?>">
      <input name="idparada" class="idparada" type="hidden" value="" required="">
      <input name="idtrem" type="hidden" value="<?=$trem['idtrem']?>" required>
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-trash"></i> Excluir Parada <span class="ordem_parada"></span> da Linha <span class="linha_operacao"></span></h4>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-sm-12">
                <div class="well well-sm">
                  <div class="row">
                      <div class="col-sm-6">
                        <span class="pull-right">Tipo da Parada:</span>
                      </div>
                      <div class="col-sm-6">
                        <span id="del_tipo_parada"></span>
                      </div>
                  </div>                  
                  <div class="row">
                      <div class="col-sm-6">
                        <span class="pull-right">Início da Parada:</span>
                      </div>
                      <div class="col-sm-6">
                        <span id="del_inicio_parada"></span>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                        <span class="pull-right">Fim da Parada:</span>                  
                      </div>
                      <div class="col-sm-6">
                        <span id="del_fim_parada"></span>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <p>Deseja excluir essa parada?</p>
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