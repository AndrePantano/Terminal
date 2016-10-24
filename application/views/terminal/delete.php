<div class="modal fade" tabindex="-1" role="dialog" id="modal_del">
  <div class="modal-dialog">
    
        <form class="form-horizontal" method="post" action="<?=base_url('terminal/delete')?>">
          <input name="idterminal" type="hidden" class="idterminal">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close close-del" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-trash"></i> Excluir Terminal</h4>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-sm-12">
                <div class="well well-sm">
            
                  <div class="row">
                    <div class="col-sm-3">
                      <span class="pull-right">Nome:</span>
                    </div>
                    <div class="col-sm-6">
                      <span class="nome_del"></span>
                    </div>
                  </div> 

                  <div class="row">
                    <div class="col-sm-3">
                      <span class="pull-right">Sigla:</span>
                    </div>
                    <div class="col-sm-6">
                      <span class="sigla_del"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-3">
                      <span class="pull-right">Meta:</span>
                    </div>
                    <div class="col-sm-6">
                      <span class="meta_del"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-3">
                      <span class="pull-right">Tarifa:</span>
                    </div>
                    <div class="col-sm-6">
                      <span class="tarifa_del"></span>
                    </div>
                  </div>

                </div>
              </div>

            </div>

            <div class="row">
              <div class="col-sm-12">
                <p>Os Terminais somente serão excluídos quando não houver vínculos com o sistema.</p>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default close-del" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Excluir</button>
          </div>

        </div><!-- /.modal-content -->

    </form>

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


          

        

      

    