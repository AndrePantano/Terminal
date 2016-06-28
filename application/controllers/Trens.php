<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trens extends CI_Controller {

  private $main = array();

  public function __construct(){  

    parent::__construct();

    // SE NÃO HOUVER SESSÃO O USUARIO É REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario")){
      redirect("auth/entrar");
    }

    $this->load->model("Trem_Model");    
  }
  
  public function em_transito(){
    
    // RETORNA TODOS OS DADOS CADASTRADOS
    $trens = null;
    $query = $this->Trem_Model->em_transito();
    
    if($query)
      $trens = $query;
    
    $dados = array(
      "main" => array("name" => "Trens em Trânsito","icon" => "fa fa-train"),
      "trens" => $trens
    );

    // CARREGA A VIEW
    $this->load->view('trens/em_transito',$dados);
  }

  public function em_operacao(){
    
    // RETORNA TODOS OS DADOS CADASTRADOS
    $trens = null;
    $query = $this->Trem_Model->em_operacao();
    
    if($query)
      $trens = $query;
    
    $dados = array(      
      "main" => array("name" => "Trens em Operação","icon" => "fa fa-train"),
      "trens" => $trens
    );
    
    // CARREGA A VIEW
    $this->load->view('trens/em_operacao',$dados);

  }
  public function operados(){
    
    // RETORNA TODOS OS DADOS CADASTRADOS
    $trens = null;
    $query = $this->Trem_Model->operados();
    
    if($query)
      $trens = $query;
    
    $dados = array(
      "main" => array("name" => "Trens Operados","icon" => "fa fa-train"),
      "trens" => $trens
    );
    
    // CARREGA A VIEW
    $this->load->view('trens/operados',$dados);
  }
}

