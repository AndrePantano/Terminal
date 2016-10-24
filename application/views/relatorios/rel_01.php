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
  table{
    font-size: 14;
  }
  /*
  table tbody tr:hover{
    cursor:default;
  }
  */
	</style>
	<script src="<?= base_url('assets/jquery/charts.js')?>"></script>

	<title><?=$main['name']?></title>

  <script type="text/javascript">
    $(document).ready(function(){
      $("tr").click(function(){
        var caminho = $(this).data("caminho");
        window.open(caminho,"_blank");
      });
    });
  </script>

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
            <!-- p class="text-muted">Tempo calculado entre o Enconste na Linha e Faturamento ALL em horas (hs).</p -->
              <canvas id="chart1" height="100"></canvas>
          </div>
        
          <div class="well well-sm">
            <div class="table-responsive">
              <p>Período de Apuração: de <?= date("d/m/Y",strtotime($inicio))?> a <?= date("d/m/Y",strtotime($fim))?>.</p>
              
              <table class="table table-hover table-condensed table-striped">
                <thead>
                  <tr>
                    <th title="Operação" width="120px">Operação</th>
                    <th title="Chegada">Chegada</th>
                    <th title="Quantidade de Vagões" width="80px">Vagões</th>
                    <th title="Tempo Útil">T. Útil</th>
                    <th title="Tempo Total da Operação">T. Oper.</th>
                    <th title="Parada de Manobra ou Inversão">P. Man. / Inv.</th>
                    <th title="Parada Rodoviária">P. Rodo.</th>
                    <th title="Tempo de B.O.">T. B.O.</th>

                    <?php if($this->session->userdata("idterminal") == 1):?>
                      <th title="A Cobrar TERLOC" width="110px">AC. TERLOG</th>
                      <th title="Estadia de Vagão" width="110px">Est.Vagão</th>
                    <?php endif;?>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    
                    $total_vagoes = $soma_act = $soma_tev = 0;

                    for($i = 0; $i< count($relatorio["labels"]);$i++){?>
                    <tr data-caminho="<?=base_url('trem/trem/'.$relatorio['idtrem'][$i])?>" >
                      <td title="<?=$relatorio['prefixo_trem'][$i]. ' Chegada em: '.$relatorio['chegada_trem'][$i]?>" ><?=$relatorio["prefixo_trem"][$i]?></td>
                      <td><?=$relatorio["chegada_trem"][$i]?></td>
                      <td><?=$relatorio["qtd_vagoes"][$i]?></td>
                      <td <?=$relatorio["tu_valores"][$i] == 0?"class='text-muted'":""?> ><?= str_replace(".", ":", $relatorio["tu_valores"][$i])?></td>
                      <td <?=$relatorio["op_valores"][$i] == 0?"class='text-muted'":""?> ><?= str_replace(".", ":", $relatorio["op_valores"][$i])?></td>
                      <td <?=$relatorio["mi_valores"][$i] == 0?"class='text-muted'":""?> ><?= str_replace(".", ":", $relatorio["mi_valores"][$i])?></td>
                      <td <?=$relatorio["pr_valores"][$i] == 0?"class='text-muted'":""?> ><?= str_replace(".", ":", $relatorio["pr_valores"][$i])?></td>
                      <td <?=$relatorio["bo_valores"][$i] == 0?"class='text-muted'":""?> ><?= str_replace(".", ":", $relatorio["bo_valores"][$i])?></td>
                      <?php if($this->session->userdata("idterminal") == 1):?>
                        <td <?=$relatorio["a_cobrar_terloc"][$i] == 0?"class='text-muted'":""?> >R$<span class="pull-right"><?= number_format($relatorio["a_cobrar_terloc"][$i],2,",",".")?></span></td>
                        <td <?=$relatorio["estadia_vagoes"][$i] == 0?"class='text-muted'":""?> >R$<span class="pull-right"><?= number_format($relatorio["estadia_vagoes"][$i],2,",",".")?></span></td>
                      <?php endif; ?>
                    </tr>
                  <?php

                    $total_vagoes += $relatorio["qtd_vagoes"][$i];
                    $soma_act += $relatorio["a_cobrar_terloc"][$i];
                    $soma_tev += $relatorio["estadia_vagoes"][$i];
                  }?>
                </tbody>
                <tfoot>
                  <tr>
                    <th><?=count($relatorio["labels"])?> Operações</th>
                    <th>&nbsp;</th>
                    <th><?= $total_vagoes ?></th>
                    <?php if($this->session->userdata("idterminal") == 1):?>
                      <th colspan="5">&nbsp;</th>
                      <th>R$<span class="pull-right"><?= number_format($soma_act,2,",",".")?></span></th>
                      <th>R$<span class="pull-right"><?= number_format($soma_tev,2,",",".")?></span></th>
                    <?php else: ?>
                      <th colspan="7">&nbsp;</th>
                    <?php endif; ?>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
              
            
            

        <div class="col-sm-6">
          <div class="well well-sm">
              <p>Período de Apuração: de <?= date("d/m/Y",strtotime($inicio))?> a <?= date("d/m/Y",strtotime($fim))?>.</p>
              <canvas id="chart2" style="background-color:#FFF"></canvas>
          </div>
          
          <div class="well well-sm">
            <div class="table-responsive">
              <table class="table text-center">
                <thead>
                  <tr>
                    <th> Acima Meta Brado 12h</th>
                    <th>Assertividades</th>
                    <th>Total Realizadas</th>
                  </tr>                
                </thead>
                <tbody>
                  <tr>
                    <td><?=$relatorio["excedidas_all"]?></td>
                    <td><?=$relatorio["assertividade"]?></td>
                    <td><?=count($relatorio["labels"])?></td>
                  </tr>
                  <tr>
                    <td><?=$relatorio["margem_all"]?>%</td>
                    <td><?=$relatorio["margem_assertividade"]?>%</td>
                    <td>-</td>
                  </tr>
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
                label: 'Meta Operação',
                //backgroundColor: "rgba(151,187,205,0.5)",
                backgroundColor: "transparent",
                data: <?= json_encode($relatorio["meta_operacao"])?>,
                borderColor: 'rgba(0,0,255,0.8)',
                borderWidth: 2
            },
            {
                type: 'line',
                label: 'Meta ALL',
                //backgroundColor: "rgba(151,187,205,0.5)",
                backgroundColor: "transparent",
                data: <?= json_encode($relatorio["meta_all"])?>,
                borderColor: 'rgba(255,0,0,0.8)',
                borderWidth: 2
            }, 
            {
                type: 'bar',
                label: 'Tempo Útil',
                backgroundColor: "rgba(210,105,30,0.8)",
                data:<?= json_encode($relatorio["tu_valores"])?>
            },
            {
                type: 'bar',
                label: 'Total Operação',
                backgroundColor: "rgba(255,0,32,0.8)",
                data:<?= json_encode($relatorio["op_valores"])?>
            },
            {
                type: 'bar',
                label: 'P. Manobra e Inversão',
                backgroundColor: "rgba(50,205,50,0.8)",
                data:<?= json_encode($relatorio["mi_valores"])?>
            },
            {
                type: 'bar',
                label: 'Parada Rodoviária',
                backgroundColor: "rgba(128,0,255,0.8)",
                data:<?= json_encode($relatorio["pr_valores"])?>
            },
            {
                type: 'bar',
                label: 'Tempo do BO',
                backgroundColor: "rgba(100,149,237,0.8)",
                data:<?= json_encode($relatorio["bo_valores"])?>                
            }
          ]

        };
        
          var pizza = {
              labels: ["Acima Meta Brado 12h","Assertividade"],
              datasets: [{
                data: [<?=$relatorio["excedidas_all"]?>,<?=$relatorio["assertividade"]?>],
                backgroundColor: [
                    //"rgba(0,0,255,0.7)",
                    "rgba(255,0,0,1)",
                    "rgba(0,128,0,1)"
                ],
                hoverBackgroundColor: [
                    //"rgba(0,0,255,0.7)",
                     "rgba(255,0,0,0.9)",
                    "rgba(0,128,0,0.9)"
                ]
              }]
          };
        
        window.onload = function() {
          var ctx = document.getElementById("chart1").getContext("2d");
          window.myBar = new Chart(ctx, {
            type: 'bar',
            data: colunas,
            options: {
              responsive: true,
              title: {
                  display: true,
                  fontColor: 'rgb(0, 0, 0)',
                  fontSize:14,
                  text: "Resultado por Operação em Horas (hs) - Período: de <?= date('d/m/Y',strtotime($inicio))?> a <?= date('d/m/Y',strtotime($fim))?>"
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
                  yLabel: String,
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
                    fontSize:14,
                    text: "Resultado de Metas Operacionais"
                },
                legend: {
                  display: true,
                  position:"bottom",
                  labels: {
                      //fontColor: 'rgb(255, 99, 132)'
                  }
                  
                }
              }
            });
          
        };
      </script>
    <?php endif;?>

    <!-- ?="<pre>".print_r($relatorio[""],1)."</pre>"? -->
  </div>    
</body>
</html>