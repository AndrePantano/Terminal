<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorios extends CI_Controller {

  public function __construct(){  

    parent::__construct();

    // SE NÃO HOUVER SESSÃO O USUARIO É REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario")){
      redirect("auth/entrar");
    }
    $this->load->model("Relatorio_Model");
  }
     
  // RELATÓRIO DE ENCONTE X FATURAMENTO ALL
  public function rel_01(){

    $relatorio = array();
    
    $inicio = date("Y-m-")."01";
    $fim = date("Y-m-d");

    if($this->input->post("inicio") && $this->input->post("fim")){
      $inicio =  $this->input->post("inicio");
      $fim = $this->input->post("fim");
    }

    // VERIFICA SE A DATA INICIO É MAIOR QUE A DATA FIM;
    if(strtotime($inicio) > strtotime($fim)){
      $this->message("danger","A data início do período não pode ser maior que a data término!");
    }else{
      // REALIZA DA PESQUISA
      $relatorio = $this->Relatorio_Model->rel_01($inicio,$fim);
    }

    $dados = array(
      "main" => array(
      	"name" => "Rel. Encoste X Faturamento ALL",
      	"icon" => "fa fa-line-chart"
      ),
      "titulo" => "Rel. Encoste X Faturamento ALL",
      "relatorio" => $relatorio,
      "inicio" => $inicio,
      "fim" => $fim
    );

    $this->load->view("relatorios/rel_01",$dados);
  }

  public function message($class,$text){
    $this->session->set_flashdata([
      'class' => $class,
      'content' => $text
    ]);
  }
}