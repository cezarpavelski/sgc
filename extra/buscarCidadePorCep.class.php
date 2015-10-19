<?php	class buscarCidadePorCep{
		private $dadosCidade="";
		private $cidade="";
		private $uf="";
		private $bairro="";
		private $tipoLogradouro="";
		private $logradouro="";
		private $validaCep="";		
		public function __construct($cep){
			 $cep = preg_replace("@[./-]@", "", $cep);			 		  	 $ch = curl_init();	         curl_setopt ($ch, CURLOPT_URL, 'http://republicavirtual.com.br/web_cep.php');	         curl_setopt ($ch, CURLOPT_HEADER, 1);	         curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);	         curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0);	         $data = array('cep' => urlencode($cep), 'formato' => 'query_string');			 curl_setopt($ch, CURLOPT_GET, true);			 curl_setopt($ch, CURLOPT_GETFIELDS, $data);	         $conteudo = curl_exec($ch);	         curl_close($ch);			
			 //$resultado = file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');  						 echo $resultado=$conteudo;			 
		     if(!$resultado){  
		         $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";  
		     }  
		     parse_str($resultado, $retorno); 
		     $this->dadosCidade= $retorno; 
		}
		public function getCidade(){
			return $this->cidade= $this->dadosCidade['cidade'];
		}
		
		public function getUf(){
			return $this->cidade= $this->dadosCidade['uf'];
		}
		
		public function getBairro(){
			return $this->cidade= $this->dadosCidade['bairro'];
		}
		
		public function getTipoLogradouro(){
			return $this->cidade= $this->dadosCidade['tipo_logradouro'];
		}
		
		public function getLogradouro(){
			return $this->cidade= $this->dadosCidade['logradouro'];
		}
		
		public function getValidaCep(){
			return $this->validaCep = $this->dadosCidade['resultado'];
		}
		
		public function getDadosCidade(){
			return $this->dadosCidade;
		}
	}

?>