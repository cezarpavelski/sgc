<?php 
	if(!$_SESSION['menu']){
		$menu= array(
					  "PÁGINA INICIAL"=>array(
									links=>array("home"),
									target=>array("_self")
									),
					  "USUÁRIOS"=>array(
									links=>array("usuarios"),
									target=>array("_self")
									),
					  "MENU"=>array(
									labels=>array("Imagens Home","Quem Somos", "Nossos Serviços", "MP3"), 
									links=>array("imagens_home","quem_somos","servicos", "mp3"),
									target=>array("_self","_self","_self","_self")
									),
					  "EVENTOS"=>array(
									labels=>array("Categoria","Eventos"), 
								    links=>array("cat_eventos","eventos"),
								    target=>array("_self","_self")
								    )
					   );
		$keys = array_keys($menu);
		for($j=0; $j<count($_SESSION['permissao']);$j++) {
			for($i=0; $i<count($menu);$i++) {
				if($_SESSION['permissao'][$j]==$i){
					$_SESSION['menu'][$keys[$i]]=$menu[$keys[$i]];
				}
			}
		}	
	}		
	//Esta classe monta o menu	
	include_once("extra/MenuDropDown.class.php");		   
	echo new MenuDropDown($_SESSION['menu'],'#333333','#f8f8f8','#e4e4e4','#e4e4e4');
?>
