<?php 
/*
 	MODO DE UTLIZAÇÃO
 	key para testes=ABQIAAAAnfs7bKE82qgb3Zc2YyS-oBT2yXp_ZAY8_ufC3CFXhHIE1NvwkxSySz_REpPq-4WZA27OwgbtyR3VcA
 	echo $mapa=new GoogleMaps('Rua teste,30 - Maringá, PR',500, 500, 'foto.jpg'); 
 	
 	key Acerte WEB = ABQIAAAAbv-3xKC064QeM5z07ug6HxTA4pID4O-oCjgVsP1mxCIE9QuZxBR7Me6qchRz_0exVC6jN2fJN6zhzw
  
*/

class GoogleMaps{
	private $endereco;
	private $altura;
	private $largura;
	private $imagem;
	private $key="ABQIAAAAoTVXk96OHvppH6M3_-TksxRMILXzjB5AdflenB4ahNh45E1vghTvlgy61AqWCcUAdlquuIykzsizJA";
	
	public function __construct($endereco="",$largura="",$altura="",$imagem=""){
		$this->endereco = $endereco;
		$this->largura = $largura;
		$this->altura = $altura;
		$this->imagem = $imagem;
	}
	
	public function GoogleMaps(){
		
	}
	public function gerarLocalizacao(){
		$script='
			<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key='.$this->key.'" type="text/javascript"></script>
			<script type="text/javascript">
			var mapaobj;
			var geocoder; 
			var nivelZoom = [];
			    nivelZoom[0] = 2;
			    nivelZoom[1] = 8;
			    nivelZoom[2] = 9;
			    nivelZoom[3] = 10;
			    nivelZoom[4] = 12;
			    nivelZoom[5] = 13;
			    nivelZoom[6] = 14;
			    nivelZoom[7] = 15;
			    nivelZoom[8] = 16;
			    
			function inicializa() {
			    mapaobj = new GMap2(document.getElementById("mapa"));
			    mapaobj.setCenter(new GLatLng(34, 0), 3);
			    geocoder = new GClientGeocoder();
			}
			
			function realizaConsulta() {
			    var endereco = "'.$this->endereco.'";
			    geocoder.getLocations(endereco, resolverEnderecos);
			}
			
			function resolverEnderecos(resposta) {
			    mapaobj.clearOverlays(); 
			    if (!resposta || resposta.Status.code != G_GEO_SUCCESS) {
			        alert("Nao foi possivel localizar o endereco solicitado");
			        alert("Código de erro: " +  resposta.Status.code);
			
			    } else {
			        var num_resultados = resposta.Placemark.length;
			        var alvo = document.getElementById("locais");
			        listarLocais(alvo, resposta.Placemark);           
			        if (num_resultados > 1) {
			              alert("A sua consulta retornou resultados ambíguos." +
			                    "\nEscolha a localidade mais adequada à consulta.");
			        } else {
			          var local = resposta.Placemark[0];
			          var ponto = local.Point.coordinates;
			          var acc = resposta.Placemark[0].AddressDetails.Accuracy;
			          centralizaMapa(ponto[1],ponto[0],resposta.Placemark[0].address, acc);
			       }
			    }
			}
			
			function listarLocais(alvo, placemark) {
				for (var i=0; i<placemark.length; ++i) {
					var uf = placemark[i].AddressDetails.Country.AdministrativeArea.AdministrativeAreaName; 
					var acc = placemark[i].AddressDetails.Accuracy;
					var p = placemark[i].Point.coordinates;
					var info = placemark[i].address;   
				}
			}
			
			function centralizaMapa(x, y, info, acc) {
			    var p = new GLatLng(x,y);
			    var zoom = nivelZoom[acc];
			    mapaobj.setCenter(p,zoom);
			    marcador = new GMarker(p);
			    mapaobj.addOverlay(marcador);
			    marcador.openInfoWindowHtml("<img src=\"'.$this->imagem.'\" style=\"float:left; padding-right:10px; padding-bottom:10px\"><span style=\"font-family:Arial; font-size:12px\"> " + info + "</span>");    
			  }
			</script>
		';	
		$body ='
			<body onLoad="inicializa();realizaConsulta();return false;" topmargin="0" leftmargin="0">
			  <div id="locais"></div>
			  <div id="mapa" style="width:'.$this->largura.'px; height:'.$this->altura.'px"></div>
			</body>
		';
		return $script.$body;
	}
	
	public function getEndereco() {
		return $this->endereco;
	}

	public function getAltura() {
		return $this->altura;
	}

	public function getLargura() {
		return $this->largura;
	}

	public function setEndereco($endereco) {
		$this->endereco = $endereco;
	}

	public function setAltura($altura) {
		$this->altura = $altura;
	}

	public function setLargura($largura) {
		$this->largura = $largura;
	}
	
	public function setImagem($imagem) {
		$this->imagem = $imagem;
	}

	public function getImagem() {
		return $this->imagem;
	}

	public function setKey($key) {
		$this->key = $key;
	}

	public function getKey() {
		return $this->key;
	}
	
	public function __toString(){
		return $this->gerarLocalizacao();;
	}
}

?>
