<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avaria_Vagao extends CI_Controller {

  public function __construct(){  

    parent::__construct();
    
    // SE NÃO HOUVER SESSÃO O USUARIO É REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario")){
      redirect("auth/entrar");
    }

    $this->load->model("Trem_Model");
    $this->load->model("Avaria_Vagao_Model");
    
  }
     
  public function create(){

    $this->validar_formulario('create');

    $avaria = $this->montar_dados();

    $this->Avaria_Vagao_Model->create($avaria);

    $this->session->set_flashdata([
      'class' => 'success',
      'content' => 'Avaria adicionada com sucesso'
    ]);        
           
    $this->redireciona();
    
  }

  public function montar_dados(){

    $dados = array(
      "idtrem" => $this->input->post("idtrem"),
      "vagao" => strtoupper($this->input->post("vagao")),
      "idusuario" => $this->session->userdata("idusuario"),
      "descricao" => $this->input->post("descricao")
    );
    
    if($this->input->post("idavaria")){ 
      $dados["idavaria"] = $this->input->post("idavaria");
      $dados["atualizado_em"] = date("Y-m-d H:i:s");
    }else{
      $dados["criado_em"] = date("Y-m-d H:i:s");
    }

    
    return $dados;    
  }

  public function update(){
    
    $this->validar_formulario('update');

    $avaria = $this->montar_dados();
    
    $this->Avaria_Vagao_Model->update($avaria);

    $this->session->set_flashdata([
      'class' => 'success',
      'content' => 'Avaria atualizada com sucesso'
    ]);        
           
    $this->redireciona();

  }

  public function delete(){
    
    $this->validar_formulario('delete');

    $dados = array("idavaria" => $this->input->post("idavaria"));
    
    $this->Avaria_Vagao_Model->delete($dados);

    $this->session->set_flashdata([
      'class' => 'success',
      'content' => 'Avaria excluída com sucesso'
    ]);        
           
    $this->redireciona();
    
  }

  public function trem($id){
    
    $dados = array();
    $trem = $this->Trem_Model->trem($id);
    
    if($trem){

      $this->load->model("Avaria_Vagao_Model");
      $avarias = $this->Avaria_Vagao_Model->avarias("idtrem",$trem["idtrem"]);
      
      $dados = array(
        "main" => array("name" => "Trem ".$trem["prefixo_trem"],"icon" => "fa fa-train"),
        "trem" => $trem,
        "avarias" => $avarias
        //"grupos" => $grupos
      );
      $this->load->view('avaria_vagao/trem',$dados);
    }else{
      $dados["heading"] = "Registro Inexistente.";
      $dados["message"] = "Este registro não se encontra em nossa base de dados!";
      $this->load->view('errors/cli/error_404',$dados);
    }   
    
  }

  public function check_post(){
    if(!$this->input->post()){
      $this->session->set_flashdata([
        'class' => 'danger',
        'content' => 'Nenhum formulário foi recebido!'
      ]); 
      $this->redireciona();
    }
  }

  public function validar_formulario($tipo){

    $this->check_post();

    switch ($tipo) {
      case 'create':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        $this->form_validation->set_rules('vagao','Vagão','required');   
        $this->form_validation->set_rules('descricao','Descrição','required');   
        break;
      case 'update':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        $this->form_validation->set_rules('idavaria','Avaria','required');    
        $this->form_validation->set_rules('vagao','Vagão','required');   
        $this->form_validation->set_rules('descricao','Descrição','required');   
        break;
      case 'delete':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        $this->form_validation->set_rules('idavaria','Avaria','required');
        break;
    }

    if(!$this->form_validation->run()){

      $this->session->set_flashdata([
        'class' => 'danger',
        'content' => 'Ocorreum erro na validação dos dados.<br/>'.validation_errors()
      ]);

      $this->redireciona();
    }
  }

  public function redireciona(){

    redirect("avaria_vagao/trem/".$this->input->post("idtrem"));
  }

}

