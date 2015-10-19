<?php
	class Contato{
		private $nome;
		private $email;
		private $telefone;
		private $mensagem;
		private $assunto;
		private $emailDestinatario;
		
		public function Contato($emailDestinatario="",$assunto="",$nome="",$email="",$telefone="",$mensagem=""){
			$this->nome = $nome;
			$this->email = $email;
			$this->telefone = $telefone;
			$this->mensagem = $mensagem;
			$this->emailDestinatario= $emailDestinatario;
			$this->assunto= $assunto;
		}

		public function setEmailDestinatario($emailDestinatario) {
			$this->emailDestinatario = $emailDestinatario;
		}

		public function getEmailDestinatario() {
			return $this->emailDestinatario;
		}

		public function setAssunto($assunto) {
			$this->assunto = $assunto;
		}
	
		public function getAssunto() {
			return $this->assunto;
		}

		public function getNome() {
			return $this->nome;
		}
	
		public function getEmail() {
			return $this->email;
		}
	
		public function getTelefone() {
			return $this->telefone;
		}
	
		public function getMensagem() {
			return $this->mensagem;
		}
	
		public function setNome($nome) {
			$this->nome = $nome;
		}
	
		public function setEmail($email) {
			$this->email = $email;
		}
	
		public function setTelefone($telefone) {
			$this->telefone = $telefone;
		}
	
		public function setMensagem($mensagem) {
			$this->mensagem = $mensagem;
		}
		
		public function enviarEmail(){
				$mens  =   "<table width='300'><tr><td style='font-family: Trebuchet MS; font-size:12px; background-color:#A6DBFF; color:#333333; padding:10px;'>";
				$mens  .=  "<center><b style='font-size:16px;'>Contato</b></center>";
				$mens  .=  "<br><b>Nome:</b> ".$this->getNome()."\n";
				$mens  .=  "<br><b>Telefone:</b> ".$this->getTelefone()."\n";
				$mens  .=  "<br><b>E-mail:</b> ".$this->getEmail()."\n";
				$mens  .=  "<br><b>Mensagem:</b> <br>".nl2br($this->getMensagem())."\n\n\n\n\n\n\n\n\n\n";
				$mens  .=  "</td></tr></table>";
				
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .= "From: ".$this->getEmail()."\r\n";
				
				if(mail($this->getEmailDestinatario(), $this->getAssunto(), $mens, $headers)){
					return ("E-mail enviado com Sucesso!");
				}else{
					return ("E-mail não enviado com Sucesso!");
				}
		}
	}
	
?>