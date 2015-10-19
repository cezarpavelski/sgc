<?php 
	class Upload{
		private $arquivo;
		private $diretorio;
		private $novoNome;
		private $resposta;
		
		public function Upload(){
			
		}
		
		public function __construct($arquivo="",$diretorio=""){
			$this->arquivo = $arquivo;
			$this->diretorio = $diretorio;
			$this->gravarArquivo();
		}
		
		public function gravarArquivo(){
			$arquivo = $this->arquivo;
			@mkdir($this->diretorio,0777);
			@chmod($this->diretorio,0777);
			$f_name = $arquivo['name'];
			$f_tmp  = $arquivo['tmp_name'];
			$f_type = $arquivo['type'];		
			$infoAnexo = pathinfo($f_name);
			$extensao = $infoAnexo['extension'];
			$nome = strtolower(md5(uniqid(time())).".".$extensao);
			$this->novoNome = $nome;
			$respostaUpload=copy($f_tmp, $this->diretorio."/".$nome);
			if($respostaUpload){
				$this->resposta="1";
			}else{
				$this->resposta="0";
			}
		}
		
		public function getNovoNome(){
			return $this->novoNome;
		}
		
		public function getResposta(){
			return $this->resposta;
		}
		
		public function getArquivo() {
			return $this->arquivo;
		}
	
		public function getDiretorio() {
			return $this->diretorio;
		}
	
		public function setArquivo($arquivo) {
			$this->arquivo = $arquivo;
		}
	
		public function setDiretorio($diretorio) {
			$this->diretorio = $diretorio;
		}
	
	}

?>