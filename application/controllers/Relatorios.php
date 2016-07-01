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
     
  // RELATÓRIO DE OPERAÇÕES
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
      	"name" => "Rel. Painel Operações",
      	"icon" => "fa fa-bar-chart"
      ),
      "titulo" => "Rel. Painel Operações",
      "relatorio" => $relatorio,
      "tipo_relatorio" => "rel_01",
      "inicio" => $inicio,
      "fim" => $fim
    );

    $this->load->view("relatorios/rel_01",$dados);
  }

  // RELATÓRIO DE TRENS
  public function rel_02(){

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
      $relatorio = $this->Relatorio_Model->rel_02($inicio,$fim);
    }

    $dados = array(
      "main" => array(
        "name" => "Rel. Painel Trens",
        "icon" => "fa fa-bar-chart"
      ),
      "titulo" => "Rel. Painel Trens",
      "relatorio" => $relatorio,
      "tipo_relatorio" => "rel_02",
      "inicio" => $inicio,
      "fim" => $fim
    );

    $this->load->view("relatorios/rel_02",$dados);
  }

  public function message($class,$text){
    $this->session->set_flashdata([
      'class' => $class,
      'content' => $text
    ]);
  }
}