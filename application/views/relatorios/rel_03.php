<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php $this->load->view("layout/head"); ?> 
	<!-- link href="<?php echo base_url('assets/bootstrap/css/bootstrap_o.css')?>" rel="stylesheet" -->
	<style type="text/css">
	body{
		margin-top: 70px;
	}
  canvas{
    background-color: #FFF;
  }
	</style>
	<script src="<?= base_url('assets/jquery/charts.js')?>"></script>

	<title><?=$main['name']?></title>
</head>
<body>
	<div class="container">

    <?php $this->load->view("relatorios/pesquisar"); ?> 

  	<div class="row">
  		<div class="col-sm-12">
  			<!-- LAYOUT DE MENSAGENS -->
  			<?php $this->load->view("layout/message"); ?>
  		</div>
  	</div>
  
    <?php $this->load->view("layout/nav_bar"); ?>
    
    <!-- CABECALHO DA PÁGINA -->
    <div class="row">
      <div class="col-sm-12">     
        <h1 class="page-header">
          <i class="<?=$main['icon']?>"></i> <?=$main['name']?>
          <button class="btn btn-default pull-right" data-target="#modal_pesquisar" data-toggle="modal"><i class="fa fa-search"></i> Pesquisar Período</button>
        </h1>
      </div>
    </div>

    <!-- AREA DOS GRAFICOS -->    
    <div class="row">       
      <?php if($relatorio): ?>
        <div class="col-sm-12">
          <!-- div class="well well-sm">
              <canvas id="chart1" height="100"></canvas>
          </div -->
          
          <div class="well">
            <div class="table-responsive">
              <p>
                Período de Apuração: de <?= date("d/m/Y",strtotime($inicio))?> a <?= date("d/m/Y",strtotime($fim))?>.
                <span class="pull-right"> &Delta;hs até 10hs <span style="color:#0F0;">&block;</span>, acima de 10hs para + ou - <span style="color:#FF7417;">&block;</span></span>
              </p>
              <p>
                Trens Operados: <?=count($relatorio)?> Trens.
                <span class="pull-right"> &Delta; Final até 3hs <span style="color:#0F0;">&block;</span>, acima de 3hs para + ou - <span style="color:#FF7417;">&block;</span></span>
              </p>              
              <table class="table" style="text-align:center;">
                <thead>
                  <tr>
                    <th style="text-align:center;">Trem</th>
                    <th style="text-align:center;">Anterior</th>
                    <th style="text-align:center;">&Delta; Hs</th>
                    <th style="text-align:center;">Antepen. Prev.</th>
                    <th style="text-align:center;">&Delta; Hs</th>
                    <th style="text-align:center;">Penúltima Prev.</th>
                    <th style="text-align:center;">&Delta; Hs</th>
                    <th style="text-align:center;">Última Prev.</th>
                    <th style="text-align:center;">Data Chegada</th>
                    <th style="text-align:center;">&Delta; Final</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($relatorio as $trem):?>
                    <tr>
                      <td><?=$trem["prefixo"]?></td>
                      <?php foreach($trem["previsoes"] as $k => $previsao):?>                        
                        <td><?= $previsao != "null"? $previsao : "---------------" ?></td>
                        <?php if($k < 3): ?>
                          <td style="color:<?= $trem['deltas_color'][$k] != 'null' ? $trem['deltas_color'][$k] : '' ?>;" ><?= $trem["deltas"][$k] != "null" && $trem["deltas"][$k] != "00" ? $trem["deltas"][$k] : "----" ?></td>
                        <?php endif; ?>
                      <?php endforeach; ?>
                      <td><?=$trem["chegada"]?></td>
                      <td style="color:<?=$trem['color']?>;"><?=$trem["delta_f"]?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>      
        </div>

      <?php else: ?>

        <div class="jumbotron">
          <h1>Sem resultados!</h1>
          <p>Não há dados para gerar o relatório, tente outro período.</p>              
        </div>

      <?php endif;?>

    </div>

    <?php $this->load->view("layout/rodape"); ?>
    
    <?php /* if($relatorio): ?>
    	<script>

        var colunas = {
            labels: <?= json_encode($relatorio["labels"])?>,            
            datasets: [{
                type: 'bar',
                label: 'Tempo Total do Trem',
                backgroundColor: "rgba(127,127,0,0.8)",
                data:<?= json_encode($relatorio["tempo_operacao"])?>
            }]
        };

        var options =  {
          responsive: true,
          title: {
              display: true,
              fontColor: 'rgb(0, 0, 0)',
              fontSize:14,
              text: "Resultado por Trens em Horas (hs) - Período de Apuração: de <?= date('d/m/Y',strtotime($inicio))?> a <?= date('d/m/Y',strtotime($fim))?>"
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              }
            }]
          },
          legend: {
              display: true,
              position:"top"
          },
          tooltip:{  
              yLabel: String              
          },          
        }
      
        window.onload = function() {

          var ctx = document.getElementById("chart1").getContext("2d");
          window.myBar = new Chart(ctx, {
            type: 'bar',
            data: colunas,
            options: options
          });
    
        };
      </script>
    <?php endif; */?>

    <!-- ?="<pre>".print_r($relatorio,1)."</pre>"? -->
  </div>    
</body>
</html>