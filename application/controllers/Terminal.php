<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terminal extends CI_Controller {

  public function __construct(){  

    parent::__construct();

      $this->load->model("Terminal_Model");
      $this->load->model("Message_Model");

    // SE NÃO HOUVER SESSÃO OU O USUARIO FOR DIFERENTE DE ADMINISTRADOR
    // ELE SERÁ REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario") || $this->session->userdata("idperfil") != 1)
      redirect("/");
  }
     
  public function index(){
  
    // RETORNA TODOS OS DADOS CADASTRADOS
    $terminais = $this->Terminal_Model->all(); 

    $dados = array(
      "main" => array("name" => "Terminais","icon" => "fa fa-industry"),
      "terminais" => $terminais      
    );
    //echo "<pre>".print_r($dados,1)."</pre>";
    // CARREGA A VIEW
    $this->load->view('terminal/index',$dados);
  
  }

  public function create(){
    
    $this->validar_formulario('create');

    $dados = $this->montar_dados();
    
    $this->Terminal_Model->create($dados);
    
    $this->Message_Model->message('success','Terminal adicionado com sucesso');
           
    $this->redireciona();
    
  }

  public function update(){
    
    $this->validar_formulario('update');

    $dados = $this->montar_dados();

    $this->Terminal_Model->update($dados);
    
    $this->Message_Model->message('success','Dados atualizados com sucesso');
    
    $this->redireciona();
    
  }

  public function delete(){
    
    $this->validar_formulario('delete');
    
    $this->checar_historico($this->input->post("idterminal"));

    $dados = array("idterminal" => $this->input->post("idterminal"));
    
    $this->Terminal_Model->delete($dados);

    $this->Message_Model->message( 'success','Terminal excluído com sucesso');        
           
    $this->redireciona();
  }

  public function validar_formulario($tipo){
    
    $this->check_post();

    switch ($tipo) {
      case 'create':
        $this->form_validation->set_rules('nome','Nome','required');    
        $this->form_validation->set_rules('sigla','Sigla','required');     
        $this->form_validation->set_rules('meta','Meta','required');     
        $this->form_validation->set_rules('tarifa','Tarifa','required');     
        break;
      case 'update':
        $this->form_validation->set_rules('idterminal','Id do Terminal','required');    
        $this->form_validation->set_rules('nome','Nome','required');    
        $this->form_validation->set_rules('sigla','Sigla','required');       
        $this->form_validation->set_rules('meta','Meta','required');     
        $this->form_validation->set_rules('tarifa','Tarifa','required');     
        break;
      case 'delete':
        $this->form_validation->set_rules('idterminal','Id do Terminal','required');    
        break;
    }

    if(!$this->form_validation->run()){

      $this->Message_Model->message('danger','Ocorreum erro na validação dos dados.<br/>'.validation_errors());

      $this->redireciona();
    }

  }

  public function montar_dados(){

    $dados = array(
      "nome_terminal" => strtoupper($this->input->post("nome")),
      "sigla_terminal" => strtoupper($this->input->post("sigla")),
      "meta_operacao" => strtoupper($this->input->post("meta")),
      "valor_tarifa" => str_replace(",",".",strtoupper($this->input->post("tarifa"))),
    );
    
    if($this->input->post("idterminal")) $dados["idterminal"] = $this->input->post("idterminal");
    
    return $dados;
  }

  public function check_post(){

    if(!$this->input->post()){
      $this->Message_Model->message('danger','Nenhum formulário foi recebido!'); 
      $this->redireciona();
    }

  }

  public function redireciona(){

    redirect("terminal/");
  }

  public function checar_historico($idterminal){
    
    // CHECA A QUANTIDADE DE TRENS QUE O TERMINAL POSSUI CADASTRADO
    $this->load->model("Trem_Model");
    $qtd = $this->Trem_Model->contar_registros_do_terminal($idterminal);

    if($qtd > 0){
       $this->Message_Model->message( 'danger','Não é possível excluir este terminal, existem registros vinculados a ele.');
       $this->redireciona();
    }

  }

}
