<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php $this->load->view("layout/head"); ?> 
	<link href="<?php echo base_url('assets/bootstrap/css/bootstrap_o.css')?>" rel="stylesheet">
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
	<?php $this->load->view("layout/nav_bar"); ?>

	<div class="row">
		<div class="col-sm-12">			
			<h1 class="page-header"><i class="<?=$main['icon']?>"></i> <?=$main['name']?></h1>
			<p class="text-muted">Tempo calculado entre: Enconste na Linha e Faturamento ALL.</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<!-- LAYOUT DE MENSAGENS -->
			<?php $this->load->view("layout/message"); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
		</div>
		<div class="col-sm-6">
      		<canvas id="canvas" style="background-color:#FFF"></canvas>
      	</div>
  	</div>

	<?php $this->load->view("layout/rodape"); ?>
	
	<script>
        var randomScalingFactor = function() {
            return (Math.random() > 0.5 ? 1.0 : 1.0) * Math.round(Math.random() * 100);
        };

        var barChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
            {
                type: 'line',
                label: 'Meta Operação',
                //backgroundColor: "rgba(151,187,205,0.5)",
                data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()],                
                borderColor: 'blue',
                borderWidth: 2
            },
            {
                type: 'line',
                label: 'Meta Operação ALL',
                //backgroundColor: "rgba(151,187,205,0.5)",
                data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()],                
                borderColor: 'red',
                borderWidth: 2
            }, 
            {
                type: 'bar',
                label: 'Operações',
                backgroundColor: "rgba(0,255,0,0.5)",
                data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]              
            }, ]

        };

        window.onload = function() {
          var ctx = document.getElementById("canvas").getContext("2d");
          window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
              //responsive: true,
              title: {
                  display: true,
                  fontColor: 'rgb(255, 255, 255)',
                  text: "Tempo de Permanência"
              },              
            }
          });
        };
  	</script>
	
	</div>    
</body>
</html>