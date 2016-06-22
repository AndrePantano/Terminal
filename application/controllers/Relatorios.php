<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorios extends CI_Controller {

  public function __construct(){  

    parent::__construct();  

  }
     
  public function permanencia(){

  	$dados = array(
      "main" => array(
      	"name" => "Tempo de Permanência",
      	"icon" => "fa fa-line-chart"
      ),
      "titulo" => "Permanência"
    );

    $this->load->view("relatorios/permanencia",$dados);
  }

}