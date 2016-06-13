<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_operacao">
  <div class="modal-dialog modal-lg">
    
        <form class="form-horizontal" method="post" action="<?=base_url('operacao/insert')?>">
          <input name="idtrem" type="hidden" value="<?=$trem['idtrem']?>" required="">
          <input name="linha" type="hidden" value="2" required="">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-plus"></i> Adicionar Operação</h4>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-sm-4">
                <div class="well well-sm">
                  <h4>Início</h4>
                  <hr></hr>
                  <div class="form-group">
                    <label class="col-md-12" for="quantidade">Qtde. Vagões:</label>  
                    <div class="col-md-6">
                      <input name="quantidade" type="number" placeholder="00" value="" class="form-control input-md" pattern="[0-9]{2}" required="" min="0" max="99">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-12" for="encoste">Encoste na Linha:</label>  
                    <div class="col-md-9">
                      <input name="encoste" type="datetime-local" value="" class="form-control input-md">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-12" for="inicio">Início Operação:</label>  
                    <div class="col-md-9">
                      <input name="inicio" type="datetime-local" value="" class="form-control input-md">
                    </div>
                  </div>
                </div>
              </div>
 
              <div class="col-sm-4">
                <div class="well well-sm">
                  <h4>Paradas</h4>
                  <hr></hr>

                  <div class="form-group">
                    <label class="col-md-6" for="inversao">Inversão:</label>  
                    <div class="col-md-6">
                      <input name="inversao" type="time" value="" class="form-control input-md">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-6" for="manobra">Manobras:</label>  
                    <div class="col-md-6">
                      <input name="manobra" type="time" value="" class="form-control input-md">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-6" for="rodoviaria">Rodoviária:</label>  
                    <div class="col-md-6">
                      <input name="rodoviaria" type="time" value="" class="form-control input-md">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-6" for="diverso">Diversos:</label>  
                    <div class="col-md-6">
                      <input name="diverso" type="time" value="" class="form-control input-md">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-6" for="troca_turno">Troca Turno:</label>  
                    <div class="col-md-6">
                      <input name="troca_turno" type="time" value="" class="form-control input-md">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-6" for="refeicao">Refeição:</label>  
                    <div class="col-md-6">
                      <input name="refeicao" type="time" value="" class="form-control input-md">
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="well well-sm">
                  <h4>Encerramento</h4>
                  <hr></hr>

                  <div class="form-group">
                    <label class="col-md-12" for="termino">Término da Operação:</label>  
                    <div class="col-md-10">
                      <input name="termino" type="datetime-local" value="" class="form-control input-md">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-md-12" for="manifesto">Envio do Manifesto:</label>  
                    <div class="col-md-10">
                      <input name="manifesto" type="datetime-local" value="" class="form-control input-md">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-12" for="all">Faturamento ALL:</label>  
                    <div class="col-md-10">
                      <input name="all" type="datetime-local" value="" class="form-control input-md">
                    </div>
                  </div>
                </div>
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


          

        

      

    