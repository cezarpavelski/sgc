<?php

class Feed{
	private $url;
	private $numeroDeNoticias;
	
	public function __construct($url="",$numeroDeNoticias=""){
		$this->url = $url;
		$this->numeroDeNoticias = $numeroDeNoticias;
	}
	
	public function criarFeed(){
		if (!($fp = fopen($this->url, "r"))) {
		   return "false";
		}else{
				$n=$this->getNumeroDeNoticias();
				$xml_parse="";
				while ($data = fread($fp, $n)){ 
				        $xml_parse.=$data;
				}
				$arrayNoticias = self::xml_rss_reader($xml_parse, ($n-1)); 
		}
		return $arrayNoticias;
	}
	
	public function xml_rss_reader($xml_parse,$tamanho){
		$xml = simplexml_load_string($xml_parse);
		for($i=0;$i<=$tamanho;$i++){
			$noticias[$i]["titulo"]=utf8_decode($xml->channel[0]->item[$i]->title[0]);
			$noticias[$i]["link"]=utf8_decode($xml->channel[0]->item[$i]->link[0]);
			$noticias[$i]["noticia"]=utf8_decode($xml->channel[0]->item[$i]->description[0]);
			$noticias[$i]["data"]= utf8_decode(date("d/m/Y",strtotime($xml->channel[0]->item[$i]->pubDate[0])));
		}
	return $noticias;
	}
	
	public function setURL($url){
		$this->url = $url;
	}
	public function getURL(){
		return $this->url;
	}
	
	public function setNumeroDeNoticias($numeroDeNoticias){
		$this->numerosDeNoticias = $numeroDeNoticias;
	}
	public function getNumeroDeNoticias(){
		return $this->numeroDeNoticias;
	}
}

?>