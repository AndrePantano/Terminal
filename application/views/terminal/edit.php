<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit">
  <div class="modal-dialog">
    
        <form class="form-horizontal" method="post" action="<?=base_url('terminal/update')?>">
          <input name="idterminal" type="hidden" class="idterminal">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Dados do Terminal</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
            <label class="col-md-3 control-label" for="nome">Nome:</label>  
            <div class="col-md-6">
              <input name="nome" type="text" placeholder="Nome" class="form-control input-md nome" required minlength="5" maxlength="40">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="sigla">Sigla:</label>  
            <div class="col-md-2">
              <!-- div class="input-group" -->
                <input name="sigla" type="text" placeholder="Sigla" maxlength="3" minlength="3" class="form-control input-md sigla" required >
                <!-- span class="input-group-addon">
                  @brado.com.br
                </span>
              </div-->
            </div>
          </div>
          
           <div class="form-group">
            <label class="col-md-3 control-label" for="meta">Meta:</label>  
            <div class="col-md-3">
              <div class="input-group">
                <input name="meta" type="text" placeholder="0"  class="form-control input-md meta" required>
                <span class="input-group-addon">hs</span>
              </div>
            </div>
          </div>

           <div class="form-group">
            <label class="col-md-3 control-label" for="sigla">Tarifa:</label>  
            <div class="col-md-3">
              <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input name="tarifa" type="text" placeholder="0"  class="form-control input-md tarifa" required>
              </div>
            </div>
          </div>

          </div>
          <div class="modal-footer">
            <?php if($this->session->userdata('idperfil')==1):?>
              <button type="button" class="btn btn-default pull-left" id="btn_del">Excluir</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <?php endif;?>
          </div>

        </div><!-- /.modal-content -->

    </form>

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


          

        

      

    