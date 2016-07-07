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
          <div class="well well-sm">
              <canvas id="chart1" height="100"></canvas>
          </div>
          
          <div class="well">
            <div class="table-responsive">
              <p>Período de Apuração: de <?= date("d/m/Y",strtotime($inicio))?> a <?= date("d/m/Y",strtotime($fim))?>.</p>
              <p>Trens Operados: <?=count($relatorio["labels"])?> Trens.</p>
              <table class="table">
                <thead>
                  <tr>
                    <th>Trem</th>
                    <th>Data Chegada</th>
                    <th>Qtd. Vagões</th>
                    <th>Tempo de Operação</th>
                  </tr>
                </thead>
                <tbody>
                  <?php for($i = 0; $i < count($relatorio["labels"]); $i++) { ?>
                    <tr>
                      <td><?=$relatorio["prefixo_trem"][$i]?></td>
                      <td><?=$relatorio["chegada_trem"][$i]?></td>
                      <td><?=$relatorio["qtd_vagoes"][$i]?></td>
                      <td><?=str_replace(".", ":", $relatorio["tempo_operacao"][$i])?></td>
                    </tr>
                  <?php } ?>
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
    
    <?php if($relatorio): ?>
    	<script>

        var colunas = {
            labels: <?= json_encode($relatorio["labels"])?>,            
            datasets: [
            {
                type: 'line',
                label: 'Quantidade de Vagões',
                backgroundColor: "transparent",
                data: <?= json_encode($relatorio["qtd_vagoes"])?>,
                borderColor: 'rgba(0,0,255,0.8)',
                borderWidth: 2
            },            
            {
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
    <?php endif;?>

    <!-- ?="<pre>".print_r($relatorio,1)."</pre>"? -->
  </div>    
</body>
</html>