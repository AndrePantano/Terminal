<?php 
  if($operacoes && count($operacoes) > 1):
  foreach ($operacoes as $linha => $operacao): 
  $linha = $linha + 1;
?>

<!-- MODAL EXCLUIR -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_del_operacao<?=$operacao['idoperacao']?>">
  <div class="modal-dialog modal-md">
    
        <form class="form-horizontal" method="post" action="<?=base_url('operacao/delete')?>">
          <input name="idoperacao" type="hidden" value="<?=$operacao['idoperacao']?>" required="">
          <input name="idtrem" type="hidden" value="<?=$operacao['idtrem']?>" required="">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close close-del" data-id="<?=$operacao['idoperacao']?>" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-trash"></i> Excluir Operação da Linha <?=$linha?>?</h4>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-sm-12">
                <div class="well well-sm">
                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pull-right">Qtde. Vagões:</span>
                    </div>
                    <div class="col-sm-6">
                      <span><?=$operacao['qtd_vagoes']?></span>
                    </div>
                  </div>                 

                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pull-right">Encoste na Linha:</span>  
                    </div>
                    <div class="col-sm-6">
                      <span><?=is_null($operacao['encoste_linha'])?'':date('d/m/Y H:i', strtotime($operacao['encoste_linha']))?></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pull-right">Início Operação:</span>  
                    </div>
                    <div class="col-sm-6">
                      <span><?=is_null($operacao['inicio_operacao'])?'':date('d/m/Y H:i', strtotime($operacao['inicio_operacao']))?></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pull-right">Término da Operação:</span>
                    </div>
                    <div class="col-sm-6">
                      <span><?=is_null($operacao['termino_operacao'])?'':date('d/m/Y H:i', strtotime($operacao['termino_operacao']))?></span>
                    </div>
                  </div>
                        
                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pull-right">Envio do Manifesto:</span>
                    </div>
                    <div class="col-sm-6">
                      <span><?=is_null($operacao['envio_manifesto'])?'':date('d/m/Y H:i', strtotime($operacao['envio_manifesto']))?></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <span class="pull-right">Faturamento ALL:</span>
                    </div>
                    <div class="col-sm-6">
                      <span><?=is_null($operacao['faturamento_all'])?'':date('d/m/Y H:i', strtotime($operacao['faturamento_all']))?></span>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <h4>Atenção!</h4>
                <p>Ao remover esta operação, todos os <span class="text-danger">Tempos de Paradas</span> associadas a ela serão removidas também.</p>
                <p>Deseja continuar a exclusão desta operação?</p>
              </div>              
            </div>

          </div>
          <div class="modal-footer">      
            <button type="button" class="btn btn-default close-del" data-id="<?=$operacao['idoperacao']?>" data-dismiss="modal">Não</button>
            <button type="submit" class="btn btn-primary">Sim</button>
          </div>

        </div><!-- /.modal-content -->

    </form>

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php 
endforeach;
endif;
?>