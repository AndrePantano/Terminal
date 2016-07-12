<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit">
  <div class="modal-dialog">
    
        <form class="form-horizontal" method="post" action="<?=base_url('usuario/edit')?>">
          <input name="idusuario" type="hidden" class="idusuario">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Dados Usuário</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
            <label class="col-md-3 control-label" for="nome">Nome:</label>  
            <div class="col-md-6">
              <input name="nome" type="text" placeholder="Nome" class="form-control input-md nome" required minlength="5" maxlength="40">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="email">Email:</label>  
            <div class="col-md-6">
              <input name="email" type="email" placeholder="email@site.com"  class="form-control input-md email" required >
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="ativo">Ativo</label>
            <div class="col-md-6"> 
              <label class="radio-inline" for="ativo-0">
                <input type="radio" class="ativo-sim" name="ativo" value="1">
                Sim
              </label> 
              <label class="radio-inline" for="ativo-1">
                <input type="radio" class="ativo-nao" name="ativo" value="0">
                Não
              </label>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="quantidade">Perfil:</label>  
            <div class="col-md-6">
              <select name="idperfil" class="form-control input-md perfil" required>
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


          

        

      

    