<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipoparada extends CI_Controller {

  public function __construct(){  

    parent::__construct();
      $this->load->model("Terminal_Model");
      $this->load->model("TipoParada_Model");
      $this->load->model("Message_Model");

    // SE NÃO HOUVER SESSÃO OU O USUARIO FOR DIFERENTE DE ADMINISTRADOR
    // ELE SERÁ REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario") || $this->session->userdata("idperfil") != 1)
      redirect("/");
  }
     
  public function index(){
  
    // RETORNA TODOS OS DADOS CADASTRADOS
    $terminais = $this->Terminal_Model->all();
    $tipos = $this->TipoParada_Model->select_all(); 

    $dados = array(
      "main" => array("name" => "Tipos de Paradas","icon" => "fa fa-hand-paper-o"),
      "tipos" => $tipos,
      "terminais" => $terminais
    );

    // CARREGA A VIEW
    $this->load->view('tipoparada/index',$dados);
  
  }

  public function create(){
    
    $this->validar_formulario('create');

    $dados = $this->montar_dados();
    
    $this->TipoParada_Model->create($dados);
    
    $this->Message_Model->message('success','Tipo de Parada adicionado com sucesso');
           
    $this->redireciona();
    
  }

  public function update(){
    
    $this->validar_formulario('update');

    $dados = $this->montar_dados();

    $this->TipoParada_Model->update($dados);
    
    $this->Message_Model->message('success','Dados atualizados com sucesso');
    
    $this->redireciona();
    
  }

  public function delete(){
    
    $this->validar_formulario('delete');
    
    $this->checar_historico($this->input->post("idtipo_parada"));

    $dados = array("idtipo_parada" => $this->input->post("idtipo_parada"));
    
    $this->TipoParada_Model->delete($dados);

    $this->Message_Model->message( 'success','Tipo de Parada excluído com sucesso');        
           
    $this->redireciona();
  }

  public function validar_formulario($tipo){
    
    $this->check_post();

    switch ($tipo) {
      case 'create':
        $this->form_validation->set_rules('nome','Nome','required');    
        $this->form_validation->set_rules('idterminal','Disponivel em','required');       
        break;
      case 'update':
        $this->form_validation->set_rules('idtipo_parada','Id do Tipo Parada','required');
        $this->form_validation->set_rules('nome','Nome','required');
        $this->form_validation->set_rules('idterminal','Id do Terminal','required');
        break;
      case 'delete':
        $this->form_validation->set_rules('idtipo_parada','Id do Terminal','required');    
        break;
    }

    if(!$this->form_validation->run()){

      $this->Message_Model->message('danger','Ocorreum erro na validação dos dados.<br/>'.validation_errors());

      $this->redireciona();
    }

  }

  public function montar_dados(){

    $dados = array(
      "nome_tipo_parada" => strtolower($this->input->post("nome")),
      "idterminal" => $this->input->post("idterminal"),
    );
    
    if($this->input->post("idtipo_parada")) $dados["idtipo_parada"] = $this->input->post("idtipo_parada");
    
    return $dados;
  }

  public function check_post(){

    if(!$this->input->post()){
      $this->Message_Model->message('danger','Nenhum formulário foi recebido!'); 
      $this->redireciona();
    }

  }

  public function redireciona(){

    redirect("tipoparada/");
  }

  public function checar_historico($idtipo_parada){
    
    // CHECA A QUANTIDADE DE PARADAS QUE ESTE TIPO DE PARADA POSSUI NO SISTEMA
    $this->load->model("Parada_Model");
    $qtd = $this->Parada_Model->contar_registros_tipo_parada($idtipo_parada);

    if($qtd > 0){
       $this->Message_Model->message( 'danger','Não é possível excluir este tipo de parada, existem registros vinculados a ele.');
       $this->redireciona();
    }

  }

}
