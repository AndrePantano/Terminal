<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function message($class,$text){
    $msg = array(
      'class' => $class,
      'content' => $text
    );
    $this->session->set_flashdata($msg);
  }

  public function trem_inexistente(){
    $this->message('danger','Não existe este registro no banco de dados,<br/> ou este resgistro não pertence ao terminal atual.');
    redirect('/');
  }

}