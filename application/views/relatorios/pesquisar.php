<div class="modal fade" tabindex="-1" role="dialog" id="modal_pesquisar">
  <div class="modal-dialog modal-sm">
    
    <form class="form-horizontal" method="post" action="<?=base_url('relatorios/'.$tipo_relatorio)?>">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-calendar"></i> Período</h4>
          </div>
          <div class="modal-body">

           <!-- Text input-->
            <div class="form-group">
              <label class="col-sm-3 control-label" for="inicio">Início:</label>  
              <div class="col-sm-9">
              <input value="<?= $inicio > $fim ?'':$inicio?>" id="inicio" name="inicio" type="date" placeholder="placeholder" class="form-control">
              <span class="help-block">Data início do período.</span>  
              </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
              <label class="col-sm-3 control-label" for="fim">Término:</label>  
              <div class="col-sm-9">
              <input value="<?= $inicio > $fim ?'':$fim?>" id="fim" name="fim" type="date" placeholder="placeholder" class="form-control">
              <span class="help-block">Data término do período.</span>  
              </div>
            </div>

            <!-- Text input-->
            <!-- div class="form-group">
              <label class="col-sm-3 control-label" for="fim">Mês:</label>  
              <div class="col-sm-9">
              <select name="mes" class="form-control">
                <?php for($i=1;$i<date("m");$i++): ?>
                  <option value="<?=$i?>"><?=$i?></option>
                <?php endfor; ?>
              </select>
              <span class="help-block">Mês do período.</span>  
              </div>
            </div -->


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Pesquisar</button>
          </div>

        </div><!-- /.modal-content -->

    </form>

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
