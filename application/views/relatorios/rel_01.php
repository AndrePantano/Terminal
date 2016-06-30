<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php $this->load->view("layout/head"); ?> 
	<!-- link href="<?php echo base_url('assets/bootstrap/css/bootstrap_o.css')?>" rel="stylesheet" -->
	<style type="text/css">
	body{
		margin-top: 70px;
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
      <div class="col-sm-8">
        <div class="well well-sm">
          <p class="text-muted">Tempo calculado entre o Enconste na Linha e Faturamento ALL em horas (hs).</p>
          <?php if($relatorio): ?>
            <canvas id="chart1" style="background-color:#FFF"></canvas>
            <br>

            <p>Período de Apuração: de <?= date("d/m/Y",strtotime($inicio))?> a <?= date("d/m/Y",strtotime($fim))?>.</p>
            <p>Operações Realizadas: <?=count($relatorio["labels"])?> Operações.</p>
            <p>Operações Excedidas: <?=$relatorio["excedidas_operacao"]?> Operações - <?=$relatorio["margem_total"]?>%.</p>
            <p>Operações Excedidas (Time ALL): <?=$relatorio["excedidas_all"]?> Operações - <?=$relatorio["margem_all"]?>%.</p>
            <p>Assertividade: <?=$relatorio["assertividade"]?> Operações - <?=$relatorio["margem_assertividade"]?>%</p>
          <?php else: ?>
            <div class="jumbotron">
              <h1>Sem resultados!</h1>
              <p>Não há dados para gerar o relatório, tente outro período.</p>              
            </div>
          <?php endif;?>
        </div>
      </div>
      
       <div class="col-sm-4">
        <div class="well well-sm">
          <p class="text-muted">Calculado em quantidade de Operações.</p>
          <?php if($relatorio): ?>
            <canvas id="chart2" style="background-color:#FFF"></canvas>
            <?php else: ?>
            <div class="jumbotron">
              <h1>Sem resultados!</h1>
              <p>Não há dados para gerar o relatório, tente outro período.</p>              
            </div>
          <?php endif;?>
        </div>
      </div>

    </div>

    <?php $this->load->view("layout/rodape"); ?>
    
    <?php if($relatorio): ?>
    	<script>

        var colunas = {
            labels: <?= json_encode($relatorio["labels"])?>,
            datasets: [
            {
                type: 'line',
                label: 'Meta Operação',
                //backgroundColor: "rgba(151,187,205,0.5)",
                data: <?= json_encode($relatorio["meta_operacao"])?>,
                borderColor: 'blue',
                borderWidth: 2
            },
            {
                type: 'line',
                label: 'Meta Operação ALL',
                //backgroundColor: "rgba(151,187,205,0.5)",
                data: <?= json_encode($relatorio["meta_all"])?>,
                borderColor: 'red',
                borderWidth: 2
            }, 
            {
                type: 'bar',
                label: 'Operações',
                backgroundColor: "rgba(0,255,0,0.5)",
                data:<?= json_encode($relatorio["duracao"])?>
            }]

        };

        var pizza = {
            labels: ["Operação","ALL","Assertividade"],
            datasets: [{
              data: [<?=$relatorio["excedidas_operacao"]?>,<?=$relatorio["excedidas_all"]?>,<?=$relatorio["assertividade"]?>],
              backgroundColor: [
                  "rgba(0,0,255,0.8)",
                  "rgba(255,0,0,0.8)",
                  "rgba(0,255,0,0.8)"
              ],
              hoverBackgroundColor: [
                  "rgba(0,0,255,0.7)",
                  "rgba(255,0,0,0.7)",
                   "rgba(0,255,0,0.7)"
              ]
            }]
        };

        window.onload = function() {
          var ctx = document.getElementById("chart1").getContext("2d");
          window.myBar = new Chart(ctx, {
            type: 'bar',
            data: colunas,            
          
            options: {
              //responsive: true,
              title: {
                  display: true,
                  fontColor: 'rgb(0, 0, 0)',
                  text: "Resultado por Operação"
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
              }
            }
          });

          var ctw = document.getElementById("chart2").getContext("2d");
          var myPieChart = new Chart(ctw,{
              type: 'pie',
              data: pizza,
              options: {
                //responsive: true,
                title: {
                    display: true,
                    fontColor: 'rgb(0, 0, 0)',
                    text: "Resultado do Período em Operações"
                },
                legend: {
                  display: true,
                  position:"bottom"
                  /*,
                  labels: {
                      fontColor: 'rgb(255, 99, 132)'
                  }
                  */
                }
              }
          });
        };
      </script>
    <?php endif;?>
  </div>    
</body>
</html>