$subject = "Teste 123";
$from = "noreply@cdv.pe.hu";
$to = "violeirodabaixada@msn.com";
$body = "Isso é apenas um teste";

$this->load->library('email');
 
$this->email->initialize(); // Aqui carrega todo config criado anteriormente
$this->email->subject($subject); //assunto
$this->email->from($from); //quem mandou
$this->email->to($to); //quem recebe
$this->email->message($body); //corpo da mensagem
 
$this->email->send(); // Envia o email