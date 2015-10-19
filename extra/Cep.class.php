<?php
class Cep{
	private $cep;
	
	public function Cep(){
		
	}
	
	public function __construct($cep){
		$cep=explode("-",$cep);
		$this->cep = $cep[0].$cep[1];
	}
	
	public function buscarCep(){   
		$resultado = @file_get_contents('http://www.buscarcep.com.br/index.php?cep='.urlencode($this->getCep()).'&formato=string');
		if(!$resultado){
			$resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
			//echo "<script>\n alert(\"Web service de busca de CEP temporariamente indisponível!\"); \n</script>";
		}
		@parse_str($resultado, $retorno);
		print_r($retorno);
		return $retorno;
	}

	
	public function getCep() {
		return $this->cep;
	}

	public function setCep($cep) {
		$cep=explode("-",$cep);
		$this->cep = $cep[0].$cep[1];
	}

	
}

?>