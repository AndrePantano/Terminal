<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

  public function __construct(){  

    parent::__construct();  

  }
     
  public function index(){

    if($this->session->has_userdata("idusuario")){
    	return $this->load->view("index");
    }else{
	  	redirect("auth/entrar");
    }

  }

}

