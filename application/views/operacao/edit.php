<?php 
  if($operacoes && count($operacoes) > 0):
  foreach ($operacoes as $linha => $operacao): 
    $linha = $linha + 1;    
?>

<!-- MODAL EDITAR -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_operacao<?=$operacao['idoperacao']?>">
  <div class="modal-dialog modal-md">
    
        <form class="form-horizontal" method="post" action="<?=base_url('operacao/update')?>">
          <input name="idoperacao" type="hidden" value="<?=$operacao['idoperacao']?>" required="">
          <input name="idtrem" type="hidden" value="<?=$operacao['idtrem']?>" required="">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Dados da Operação da Linha <?=$linha?></h4>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-sm-6">
                <div class="well well-sm">
                  <h4>Início</h4>
                  <hr></hr>
                  <div class="form-group">
                    <label class="col-md-12" for="quantidade">Qtde. Vagões:</label>  
                    <div class="col-md-6">
                      <input name="quantidade" type="number" placeholder="00" value="<?=$operacao['qtd_vagoes']?>" class="form-control input-md" pattern="[0-9]{2}" required="" min="1" max="99">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-12" for="encoste">Encoste na Linha:</label>  
                    <div class="col-md-10">
                      <input name="encoste" type="datetime-local" value="<?=is_null($operacao['encoste_linha'])?'':date('Y-m-d\TH:i:s', strtotime($operacao['encoste_linha']))?>" class="form-control input-md">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-12" for="inicio">Início Operação:</label>  
                    <div class="col-md-10">
                      <input name="inicio" type="datetime-local" value="<?=is_null($operacao['inicio_operacao'])?'':date('Y-m-d\TH:i:s', strtotime($operacao['inicio_operacao']))?>" class="form-control input-md">
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="well well-sm">
                  <h4>Encerramento</h4>
                  <hr></hr>

                  <div class="form-group">
                    <label class="col-md-12" for="termino">Término da Operação:</label>  
                    <div class="col-md-10">
                      <input name="termino" type="datetime-local" value="<?=is_null($operacao['termino_operacao'])?'':date('Y-m-d\TH:i:s', strtotime($operacao['termino_operacao']))?>" class="form-control input-md">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-md-12" for="manifesto">Envio do Manifesto:</label>  
                    <div class="col-md-10">
                      <input name="manifesto" type="datetime-local" value="<?=is_null($operacao['envio_manifesto'])?'':date('Y-m-d\TH:i:s', strtotime($operacao['envio_manifesto']))?>" class="form-control input-md">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-12" for="all">Faturamento ALL:</label>  
                    <div class="col-md-10">
                      <input name="all" type="datetime-local" value="<?=is_null($operacao['faturamento_all'])?'':date('Y-m-d\TH:i:s', strtotime($operacao['faturamento_all']))?>" class="form-control input-md">
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <?php if(count($operacoes) == 2): ?>
              <button type="button" class="btn btn-default pull-left btn-del" data-id="<?=$operacao['idoperacao']?>">Excluir</button>
            <?php endif; ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>

        </div><!-- /.modal-content -->

    </form>

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php 
endforeach;
endif;
?>