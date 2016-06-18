<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

  private $main = array();

  public function __construct(){  

    parent::__construct();  

  }
     
  public function index(){

    return $this->load->view("index");
  }

}

