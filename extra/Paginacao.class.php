<?php 

class Paginacao{
	private $registros;
	private $linkPagina;
	private $totalRegistrosPaginas;
	private $limite=0;

	public function __construct($registros=array(),$linkPagina="",$totalRegistrosPaginas="",$limite=0){
		$this->registros = $registros;
		$this->linkPagina = $linkPagina;
		$this->totalRegistrosPaginas = $totalRegistrosPaginas;
		$this->limite = $limite;
	}

	public function Paginacao(){
	
	}

	public function getRegistros() {
		return $this->registros;
	}

	public function getLinkPagina() {
		return $this->linkPagina;
	}

	public function setRegistros($registros) {
		$this->registros = $registros;
	}

	public function setLinkPagina($linkPagina) {
		$this->linkPagina = $linkPagina;
	}

	public function setLimite($limite) {
		$this->limite = $limite;
	}

	public function getLimite() {
		return $this->limite;
	}

	public function setTotalRegistrosPaginas($totalRegistrosPaginas) {
		$this->totalRegistrosPaginas = $totalRegistrosPaginas;
	}

	public function getTotalRegistrosPaginas() {
		return $this->totalRegistrosPaginas;
	}

	
	public function criarPaginacao(){
		$quantidadeRegistros = count($this->registros);
		if($quantidadeRegistros==0){
			return false;
		}else{
			$registroMarcado = $this->limite+1;
			$registroFinal=($registroMarcado+$this->totalRegistrosPaginas)-1;
			$total_pg = ceil($quantidadeRegistros/$this->totalRegistrosPaginas);
			if($registroFinal>$quantidadeRegistros){
				$registroFinal=$quantidadeRegistros;
			}
			if($total_pg>=2){
			 $string = "Mostrando <b>$registroMarcado - $registroFinal </b> de <b>$quantidadeRegistros</b> registros(s) encontrados em <b>$total_pg página(s)</b><br><br>";
			 $i=1;
          	 $n=0;
		  	 $cont =0; 
			  	 if($this->limite!=0){
			  	 	 $string.= '<a href="'.$this->linkPagina.'&limite='.($this->limite-$this->totalRegistrosPaginas).'" style="color:#666666">&laquo; Anterior</a>&nbsp&nbsp;&nbsp;';
			  	 }
			  	 for($i;$i<=$total_pg;$i++){
				  	 $n=$cont*$this->totalRegistrosPaginas;
		           	 $string .= '<a href="'.$this->linkPagina.'&limite='.$n.'"'; 
		           	 if($i==($this->limite/$this->totalRegistrosPaginas)+1){	
		           	 	$string .= ' class="texto" style="background-color:#868686; color:#FFFFFF; font-weight:bold; padding:3px"';
	
		           	 }else{
		           	 	$string .= ' class="texto" style="color:#666666; font-weight:bold;"';
		           	 }
		           	 $string .= '>&nbsp;&nbsp;'.$i.'&nbsp;&nbsp;</a>&nbsp';
				  	 $cont=$cont+1;
	          	}  
	          	if($i==30) echo "<br />";
	          	if($this->limite!=$n){
	          	  $string .= '&nbsp;&nbsp;<a href="'.$this->linkPagina.'&limite='.($this->limite+$this->totalRegistrosPaginas).'" style="color:#666666" >Próxima &raquo;</a>&nbsp';
	          	}
		  	}else{
		  		$string="";
		  	}
			return $string;
		}	
	}
	
	
	public function __toString(){
		return $this->criarPaginacao();;
	}
}	



?>