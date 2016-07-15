<div class="modal fade" tabindex="-1" role="dialog" id="modal_reset">
  <div class="modal-dialog">
    
        <form class="form-horizontal" method="post" action="<?=base_url('usuario/reset')?>">
          <input name="idusuario" type="hidden" class="idusuario">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close close-del" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-lock"></i> Resetar Senha do Usuário</h4>
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
                      <span class="pull-right">Email:</span>
                    </div>
                    <div class="col-sm-6">
                      <span class="email_del"></span>
                    </div>
                  </div>

                </div>
              </div>

              <div class="col-sm-12">
                <p>A senha padrão atríbuida a este usuário será "brado".</p>
                <p>Dá próxima vez que este usuário acessar o sistema será pedido que o mesmo cadastre uma nova senha.</p>
                <p>Deseja resetar a senha deste usuário?</p>
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


          

        

      

    