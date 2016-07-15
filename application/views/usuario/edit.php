<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit">
  <div class="modal-dialog">
    
        <form class="form-horizontal" method="post" action="<?=base_url('usuario/update')?>">
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
              <!-- div class="input-group" -->
                <input name="email" type="email" placeholder="email@site.com"  class="form-control input-md email" required >
                <!-- span class="input-group-addon">
                  @brado.com.br
                </span>
              </div-->
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label">Ativo</label>
            <div class="col-md-6"> 
              <label class="radio-inline">
                <input type="radio" class="ativo-sim" name="ativo" value="sim">Sim
              </label> 
              <label class="radio-inline">
                <input type="radio" class="ativo-nao" name="ativo" value="não">Não
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
            <?php if($this->session->userdata('idperfil')==1):?>
              <button type="button" class="btn btn-default pull-left" id="btn_del">Excluir</button>
              <button type="button" class="btn btn-default pull-left" id="btn_reset">Resetar Senha</button>              
            <?php endif;?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>

        </div><!-- /.modal-content -->

    </form>

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


          

        

      

    