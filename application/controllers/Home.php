<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

  private $terminais;

  public function __construct(){  

    parent::__construct(); 
    // RETORNA TODOS OS DADOS DOS TERMINAIS
    $this->load->model("Terminal_Model");   
    $this->terminais = $this->Terminal_Model->all();

  }
     
  public function index(){

    // SE NÃO HOUVER SESSÃO O USUARIO É REDIRECIONADO PARA A ÁREA DE LOGIN
    if($this->session->has_userdata("idusuario")){
             
      $dados = array(
        "main" => array("name" => "Terminais","icon" => "fa fa-industry")
      );
      $this->session->set_userdata("terminais",$this->terminais);
      $this->load->view("index",$dados);
    }else{
      redirect("auth/entrar");
    }

  }

  public function terminal($idterminal){

    $this->load->model("Message_Model");
    
    $k = 0;
    $achou = false;

    foreach ($this->terminais as $key => $value) {

      if($value["idterminal"] == $idterminal){                
          // TUDO CERTO, ARMAZENA DADOS NA SESSAO E VOLTA PARA A HOME
          $this->session->set_userdata("idterminal",$value["idterminal"]);
          $this->session->set_userdata("nome_terminal",$value["nome_terminal"]);
          $this->session->set_userdata("sigla_terminal",$value["sigla_terminal"]); 
          $this->session->set_userdata("terminais",$this->terminais);
          break;
      }else{
        unset($_SESSION["idterminal"]);
        unset($_SESSION["nome_terminal"]);
        unset($_SESSION["sigla_terminal"]);
        unset($_SESSION["terminais"]);
      }
    }
    
    if(!$this->session->has_userdata("idterminal")){
        $this->Message_Model->message('danger','Este terminal não está disponível.');    
    }
    
    redirect("/");
  }

}

