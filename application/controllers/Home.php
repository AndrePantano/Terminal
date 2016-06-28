<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

  public function __construct(){  

    parent::__construct();  

  }
     
  public function index(){

    // SE NÃO HOUVER SESSÃO O USUARIO É REDIRECIONADO PARA A ÁREA DE LOGIN
    if($this->session->has_userdata("idusuario")){
    	$this->load->view("index");
    }else{
      redirect("auth/entrar");
    }

  }

}

