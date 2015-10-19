<?php /*MODO DE UTILIZAÇÃO	echo $videos = new Video($campos[$i][video],300,300); ||Para colocar o video do youtube	$videos->getImagem(); ||Para pegar a thumb do video do youtube*/
class Video{
	private $video;
	private $largura;
	private $altura;
		
	public function Video(){}
	public function __construct($video,$largura,$altura){
		$txt_troca= array("watch?v="); 
		$txt_vira= array("v/");
		$video = str_replace($txt_troca,$txt_vira,$video);
		$this->video = $video;
		$this->largura = $largura;
		$this->altura = $altura;
	}
	
	public function getVideo() {
		return $this->video;
	}

	public function getLargura() {
		return $this->largura;
	}

	public function getAltura() {
		return $this->altura;
	}

	public function setVideo($video) {
		$txt_troca= array("watch?v="); 
		$txt_vira= array("v/");
		$video = str_replace($txt_troca,$txt_vira,$video);
		$this->video = $video;
	}

	public function setLargura($largura) {
		$this->largura = $largura;
	}

	public function setAltura($altura) {
		$this->altura = $altura;
	}
	public function getImagem(){	
		$txt_vira= array("watch?v="); 
		$txt_troca= array("v/");   
		$video = str_replace($txt_troca,$txt_vira,$this->getVideo());
		$v1 = explode("?v=",$video);	   
		$v2 = explode("&",$v1[1]);	   
		return "http://img.youtube.com/vi/".$v2[0]."/default.jpg";	
	}
	
	public function inserirVideo(){
		$cont = substr_count($this->getVideo(), 'http://www.youtube.com');
		if($cont>0){
			$url = '<object width="'.$this->getLargura().'" height="'.$this->getAltura().'" style="z-index:1">
						<param name="movie" value="'.$this->getVideo().'"></param>
						<param name="allowFullScreen" value="true"></param>
						<param name="allowscriptaccess" value="always"></param>
						<param name="wmode" value="transparent">
						<embed src="'.$this->getVideo().'" type="application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" allowfullscreen="true" width="'.$this->getLargura().'" height="'.$this->getAltura().'"></embed>
					</object>';
		}else{
			$url="<b style='color:#990000'>VÍDEO NÃO ENCONTRADO!</b>";
			//$url="";
		}
		return $url;
	}	
	public function __toString(){		return $this->inserirVideo();;	}
}

?>