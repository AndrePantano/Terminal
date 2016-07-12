<div class="modal fade" tabindex="-1" role="dialog" id="modal_add">
  <div class="modal-dialog">
    
        <form class="form-horizontal" method="post" action="<?=base_url('usuario/create')?>">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-plus"></i> Adicionar Usuário</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
            <label class="col-md-3 control-label" for="nome">Nome:</label>  
            <div class="col-md-6">
              <input name="nome" type="text" placeholder="Nome" class="form-control input-md" required minlength="5" maxlength="40">
              <span class="help-block">Informe o nome o sobrenome do usuário</span>  
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="email">Email:</label>  
            <div class="col-md-6">
              <input name="email" type="email" placeholder="email@site.com"  class="form-control input-md" required >
              <span class="help-block">Informe o email do usuário</span>  
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="quantidade">Perfil:</label>  
            <div class="col-md-6">
              <select name="idperfil" class="form-control input-md" required>
              <option value="">Selecione uma opção</option>
              <?php foreach($perfis as $perfil):?>
                <option value="<?=$perfil['idperfil']?>"><?=strtoupper($perfil['nome_perfil'])?></option>
              <?php endforeach; ?>
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


          

        

      

    