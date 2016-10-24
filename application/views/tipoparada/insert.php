<div class="modal fade" tabindex="-1" role="dialog" id="modal_add">
  <div class="modal-dialog">
    
        <form class="form-horizontal" method="post" action="<?=base_url('tipoparada/create')?>">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-plus"></i> Adicionar Tipo de Parada</h4>
          </div>
          <div class="modal-body">

            <div class="form-group">
              <label class="col-md-3 control-label" for="nome">Nome do Tipo:</label>  
              <div class="col-md-6">
                <input name="nome" type="text" placeholder="Nome" class="form-control input-md" required minlength="5" maxlength="20">
                <span class="help-block">Informe o nome do tipo da parada</span>  
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="idterminal">Disponível em:</label>  
              <div class="col-md-6">
                <select name="idterminal" class="form-control input-md" required>
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
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>

        </div><!-- /.modal-content -->

    </form>

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


          

        

      

    