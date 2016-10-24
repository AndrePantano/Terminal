<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

  public function __construct(){  

    parent::__construct();

      $this->load->model("Usuario_Model");
      $this->load->model("Message_Model");
      $this->load->model("Perfil_Model");

    // SE NÃO HOUVER SESSÃO OU O USUARIO FOR DIFERENTE DE ADMINISTRADOR
    // ELE SERÁ REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario") || $this->session->userdata("idperfil") != 1)
      redirect("/");
  }
     
  public function index(){
  
    // RETORNA TODOS OS DADOS CADASTRADOS
    $usuarios = $this->Usuario_Model->all();
    $perfis = $this->Perfil_Model->all();

    $dados = array(
      "main" => array("name" => "Usuários","icon" => "fa fa-users"),
      "usuarios" => $usuarios,
      "perfis" => $perfis
    );

    // CARREGA A VIEW
    $this->load->view('usuario/index',$dados);
  
  }

  public function create(){
    
    $this->validar_formulario('create');

    $dados = $this->montar_dados();
    
    $this->Usuario_Model->create($dados);
    
    $this->Message_Model->message('success','Usuário adicionado com sucesso');
           
    $this->redireciona();
    
  }

  public function update(){
    
    $this->validar_formulario('update');

    $dados = $this->montar_dados();

    $this->Usuario_Model->update($dados);
    
    $this->Message_Model->message('success','Dados atualizados com sucesso');
    
    $this->redireciona();
    
  }

  public function delete(){
    
    $this->validar_formulario('delete');

    $this->checar_historico($this->input->post("idusuario"));

    $dados = array("idusuario" => $this->input->post("idusuario"));
    
    $this->Usuario_Model->delete($dados);

    $this->Message_Model->message( 'success','Usuário excluído com sucesso');        
           
    $this->redireciona();
  }

  public function reset(){
    
    $this->validar_formulario('reset');

    $dados = array(
      "idusuario" => $this->input->post("idusuario"),
      "senha" => md5("brado")
      );
    
    $this->Usuario_Model->update($dados);

    $this->Message_Model->message( 'success','Senha resetada com sucesso');        
           
    $this->redireciona();
  }

  public function validar_formulario($tipo){
    
    $this->check_post();

    switch ($tipo) {
      case 'create':
        $this->form_validation->set_rules('nome','Nome','required');    
        $this->form_validation->set_rules('email','Email','valid_email|required');       
        $this->form_validation->set_rules('idperfil','Perfil','required');       
        break;
      case 'update':
        $this->form_validation->set_rules('idusuario','Id do Usuario','required');    
        $this->form_validation->set_rules('nome','Nome','required');    
        $this->form_validation->set_rules('email','Email','valid_email|required');       
        $this->form_validation->set_rules('ativo','Ativo','required');      
        $this->form_validation->set_rules('ver_relatorios','Ver Relatórios','required');      
        $this->form_validation->set_rules('idperfil','Perfil','required');       
        break;
      case 'delete':
        $this->form_validation->set_rules('idusuario','Id do Usuario','required');    
        break;
      case 'reset':
        $this->form_validation->set_rules('idusuario','Id do Usuario','required');    
        break;
    }

    if(!$this->form_validation->run()){

      $this->Message_Model->message('danger','Ocorreum erro na validação dos dados.<br/>'.validation_errors());

      $this->redireciona();
    }

  }

  public function montar_dados(){

    $dados = array(
      "nome" => $this->input->post("nome"),
      "email" => $this->input->post("email"),
      "idperfil" => $this->input->post("idperfil"),
      "ver_relatorios" => "sim",
      "ativo" => "sim"
    );
    
    if($this->input->post("idusuario")) $dados["idusuario"] = $this->input->post("idusuario");
    
    //if($this->input->post("reset_senha")) $dados["senha"] = md5("brado");

    if($this->input->post("ativo") && $this->input->post("ativo") == "não") $dados["ativo"] = $this->input->post("ativo");
    if($this->input->post("ver_relatorios") && $this->input->post("ver_relatorios") == "não") $dados["ver_relatorios"] = $this->input->post("ver_relatorios");

    return $dados;
  }

  public function check_post(){

    if(!$this->input->post()){
      $this->Message_Model->message('danger','Nenhum formulário foi recebido!'); 
      $this->redireciona();
    }

  }

  public function redireciona(){

    redirect("usuario/");
  }

  public function checar_historico($idusuario){
    
    $qtd = 0;

    // CHECA O HISTÓRICO DA AVARIA DE CONTEINER
    $this->load->model("Avaria_Conteiner_Model");
    $qtd += $this->Avaria_Conteiner_Model->contar_registros_do_usuario($idusuario);
    
    // CHECA O HISTÓRICO DA AVARIA DE VAGAO
    $this->load->model("Avaria_Vagao_Model");
    $qtd += $this->Avaria_Vagao_Model->contar_registros_do_usuario($idusuario);

    // CHECA O HISTÓRICO DA NOTA
    $this->load->model("Nota_Model");
    $qtd += $this->Nota_Model->contar_registros_do_usuario($idusuario);

    // CHECA O HISTÓRICO DA OPERACAO
    $this->load->model("Operacao_Model");
    $qtd += $this->Operacao_Model->contar_registros_do_usuario($idusuario);

    // CHECA O HISTÓRICO DA PARADA
    $this->load->model("Parada_Model");
    $qtd += $this->Parada_Model->contar_registros_do_usuario($idusuario);

    // CHECA O HISTÓRICO DA PREVISAO CHEGADA
    $this->load->model("Previsao_Chegada_Model");
    $qtd += $this->Previsao_Chegada_Model->contar_registros_do_usuario($idusuario);

    // CHECA O HISTÓRICO DA PREVISAO SAÍDA
    $this->load->model("Previsao_Saida_Model");
    $qtd += $this->Previsao_Saida_Model->contar_registros_do_usuario($idusuario);

    // CHECA O HISTÓRICO DO TREM
    $this->load->model("Trem_Model");
    $qtd += $this->Trem_Model->contar_registros_do_usuario($idusuario);


    if($qtd > 0){
       $this->Message_Model->message( 'danger','Não é possível excluir este usuário, existem registros vinculados a ele.');
       $this->redireciona();
    }

  }

}
