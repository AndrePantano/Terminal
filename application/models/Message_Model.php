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

}