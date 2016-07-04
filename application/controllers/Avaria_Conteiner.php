<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avaria_Conteiner extends CI_Controller {

  public function __construct(){  

    parent::__construct();
    
    // SE NÃO HOUVER SESSÃO O USUARIO É REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario")){
      redirect("auth/entrar");
    }

    $this->load->model("Trem_Model");
    $this->load->model("Avaria_Conteiner_Model");
    $this->load->model("Grupo_Avaria_Conteiner_Model");

    
  }
     
  public function create(){

    $this->validar_formulario('create');

    $avaria = $this->montar_dados();

    $this->Avaria_Conteiner_Model->create($avaria);

    $this->session->set_flashdata([
      'class' => 'success',
      'content' => 'Avaria adicionada com sucesso'
    ]);        
           
    $this->redireciona();
    
  }

  public function montar_dados(){
    
    $this->validar_conteiner();

    $dados = array(
      "idtrem" => $this->input->post("idtrem"),
      "idgrupo_avaria_conteiner" => $this->input->post("grupo"),
      "conteiner" => $this->input->post("conteiner"),
      "idusuario" => $this->session->userdata("idusuario")
    );
    
    if($this->input->post("idavaria")){ 
      $dados["idavaria"] = $this->input->post("idavaria");
      $dados["atualizado_em"] = date("Y-m-d H:i:s");
    }else{
      $dados["criado_em"] = date("Y-m-d H:i:s");
    }

    if(!empty($this->input->post("observacao"))){ 
      $dados["observacao"] = $this->input->post("observacao");
    }
    
    return $dados;    
  }

  public function update(){
    
    $this->validar_formulario('update');
    
    $this->validar_conteiner();

    $avaria = $this->montar_dados();
    
    $this->Avaria_Conteiner_Model->update($avaria);

    $this->session->set_flashdata([
      'class' => 'success',
      'content' => 'Avaria atualizada com sucesso'
    ]);        
           
    $this->redireciona();

  }

  public function delete(){
    
    $this->validar_formulario('delete');

    $dados = array("idavaria" => $this->input->post("idavaria"));
    
    $this->Avaria_Conteiner_Model->delete($dados);

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

      $this->load->model("Avaria_Conteiner_Model");
      $avarias = $this->Avaria_Conteiner_Model->avarias("idtrem",$trem["idtrem"]);
      
      $this->load->model("Grupo_Avaria_Conteiner_Model");
      $grupos = $this->Grupo_Avaria_Conteiner_Model->all();

      $dados = array(
        "main" => array("name" => "Trem ".$trem["prefixo_trem"],"icon" => "fa fa-train"),
        "trem" => $trem,
        "avarias" => $avarias,
        "grupos" => $grupos
      );
      $this->load->view('avaria_conteiner/trem',$dados);
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
        $this->form_validation->set_rules('grupo','Grupo','required');   
        $this->form_validation->set_rules('conteiner','Conteiner','required');   
        break;
      case 'update':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        $this->form_validation->set_rules('idavaria','Avaria','required');    
        $this->form_validation->set_rules('grupo','Grupo','required');   
        $this->form_validation->set_rules('conteiner','Conteiner','required');   
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

    redirect("avaria_conteiner/trem/".$this->input->post("idtrem"));
  }

  public function validar_conteiner(){

    // TRANSFORMA O INPUT NUM ARRAY
    $conteiner = str_split($this->input->post("conteiner"));
    $valores = 0;

    for($i = 0; $i < 10; $i++){
      
      if($i < 4){
        $valores += $this->valor_letra($conteiner[$i]) * (2 ** $i); 
      }else{
        $valores += $conteiner[$i] * (2 ** $i);        
      }

    }
    
    // ENCONTRA O DIGITO VERIFICADOR
    $digito = $valores % 11;
    if($digito == 10){
      $digito = 0;
    }

    //echo "digito = ".$digito."<br/>";

    // REMOVE O ULTIMO INDICE DO ARRAY
    array_pop($conteiner);
    // ADICIONA O DIGITO VALIDADO NA ULTIMA POSICAO DO ARRAY
    array_push($conteiner,$digito);
    // TRANSFORMA O ARRAY E STRING
    $verificado = implode($conteiner);

    //echo "post = ".$this->input->post("conteiner")."<br/>";
    //echo "verificado = ".$verificado;

    if($this->input->post("conteiner") !== $verificado){
     $this->session->set_flashdata([
        'class' => 'danger',
        'content' => 'Número de conteiner inválido.<br/>'
      ]);

      $this->redireciona();
    }
  }

  public function valor_letra($indice){
    $letras = array(
      'A'=>10, 
      'B'=>12, 
      'C'=>13, 
      'D'=>14, 
      'E'=>15, 
      'F'=>16, 
      'G'=>17, 
      'H'=>18, 
      'I'=>19, 
      'J'=>20, 
      'K'=>21, 
      'L'=>23, 
      'M'=>24, 
      'N'=>25, 
      'O'=>26, 
      'P'=>27, 
      'Q'=>28, 
      'R'=>29, 
      'S'=>30, 
      'T'=>31, 
      'U'=>32, 
      'V'=>34, 
      'W'=>35, 
      'X'=>36, 
      'Y'=>37, 
      'Z'=>38
    );

    return $letras[$indice];
  }

}

