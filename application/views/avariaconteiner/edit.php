<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit">
  <div class="modal-dialog">
    
    <form class="form-horizontal" method="post" action="<?=base_url('avariaconteiner/update')?>">
      <input type="hidden" name="idtrem" value="<?=$trem['idtrem']?>">
      <input type="hidden" name="idavaria" class="idavaria" value="">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-edit"></i> Atualizar Avaria de Conteiner</h4>
          </div>
          <div class="modal-body">
  
            <div class="form-group">
              <label class="col-md-3 control-label">Conteiner:</label>  
              <div class="col-md-6">
                <input type="text" name="conteiner" required class="form-control input-md conteiner" placeholder="ABCD1234567" pattern="[a-z A-Z]{4}[0-9]{7}" maxlength="11"/>
                <span class="help-block">Informe o número do conteiner.</span>  
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">Grupo da Avaria:</label>  
              <div class="col-md-8">
                <select name="grupo" class="form-control input-md edit_grupo_avaria" required>
                  <option value="">Selecione uma opção</option>
                  <?php foreach($grupos as $grupo):?>
                    <option value="<?=$grupo['idgrupo_avaria_conteiner']?>"><?=strtoupper($grupo['nome_avaria'])?></option>
                  <?php endforeach; ?>
                </select>
                <span class="help-block">Informe o grupo da avaria do conteiner.</span>  
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">Observação:</label>  
              <div class="col-md-9">
                <textarea name="observacao" class="form-control input-md observacao"></textarea>
                <span class="help-block">Se precisar, use este campo para acrescentar uma observação.</span>  
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <?php if($this->session->userdata('idperfil')==1):?>
              <button type="button" class="btn btn-default pull-left" id="btn_del">Excluir</button>
            <?php endif;?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>

        </div><!-- /.modal-content -->

    </form>

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


          

        

      

    