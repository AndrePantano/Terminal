<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit">
  <div class="modal-dialog">
    
        <form class="form-horizontal" method="post" action="<?=base_url('tipoparada/update')?>">
          <input name="idtipo_parada" type="hidden" class="idtipo_parada">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Dados do Terminal</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="col-md-3 control-label" for="nome">Nome do Tipo:</label>  
              <div class="col-md-6">
                <input name="nome" type="text" placeholder="Nome" class="form-control input-md nome" required minlength="5" maxlength="40">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="quantidade">Disponível em:</label>  
              <div class="col-md-6">
                <select name="idterminal" class="form-control input-md terminal" required>
                  <option value="">Selecione uma opção</option>
                  <?php foreach($terminais as $terminal):?>
                    <option value="<?=$terminal['idterminal']?>"><?=strtoupper($terminal['nome_terminal'])?></option>
                  <?php endforeach; ?>
                  <option value="0">Todos Terminais</option>
                </select>
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


          

        

      

    