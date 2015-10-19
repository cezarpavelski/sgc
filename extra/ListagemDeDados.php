<?php
	function ListagemDeDados($campo,$tipo,$complemento){
		switch ($tipo) {
			case "texto":
					if($complemento)
						$retorno= nl2br(strip_tags((substr($campo,0,$complemento))))."...";
					else
						$retorno= nl2br($campo);
					break;
			case "titulo":
					$retorno= $campo;
					break;
			
			case "campoObrigatorio":
					$retorno= $campo;
					break;
			
			case "url":
					$retorno= $campo;
					break;
					
			case "email":
					$retorno= $campo;
					break;
					
			case "enum":
					$retorno= $campo;
					break;
					
			case "senha":
					$quantidadeCaracteres=strlen($campo);
					$retorno= "<b>".str_pad("*", ($quantidadeCaracteres), "*", STR_PAD_LEFT)."</b>";
					break;

			case "data":
					$retorno = date("d/m/Y",strtotime($campo));	
					break;
					
			case "calendario":
					$retorno = date("d/m/Y",strtotime($campo));	
					break;

			case "moeda":
					$retorno= "R$ ".number_format($campo,2,",",".");
					break;
						
			case "arquivo":
					if($campo){
						$extension=explode(".",$campo);
						switch ($extension[1]) {
							case "swf":
									$retorno = "<center><div id='$campo' style='width:300px; margin:0' align='center'><script type='text/javascript'>conteudo('uploads/$campo','300','100','$campo');</script></div></center>"; 
									break;
							default:
								if(file_exists("imagens/file_icons/".$extension[1].".png")){
									$retorno = "<a href='uploads/$campo' target='_blank'><img src='imagens/file_icons/".$extension[1].".png' border='0' alt='".$campo."' title='".$campo."'/></a>";
								}else{
									$retorno = "<a href='uploads/$campo' target='_blank'><img src='imagens/file_icons/semextensao.png' border='0' alt='".$campo."' title='".$campo."'/></a>";
								}
								break;
						}
					}
				
					break;
					
			case "imagem":
					if($campo){
						$retorno = "<a href='uploads/".$campo."' rel='shadowbox;'>";
						$retorno .= "<img src='thumb.php?end=uploads/".$campo."&largura=120&altura=90' border='0' alt='".$campo."' title='".$campo."'/>";
						$retorno .= "</a>";
					}
					break;
					
			case "youtube":
					if($campo){
						$video=new Video($campo,450,300);
						$retorno = "<a href='".$video->getVideo()."' rel='shadowbox;width=550;height=350'>";
						$retorno .= "<img src='".$video->getImagem()."' border='0' alt='".$campo."' title='".$campo."'/>";
						$retorno .= "</a>";
					}
					break;
					
			case "selecao":
					include_once("model/DAO.class.php");
				    $dao=new DAO();
					$dados=explode("|",$complemento);
					$selecao=$dao->selectFree("select id, $dados[1] as label from $dados[0] where id=$campo order by $dados[1] asc");
					$retorno= $selecao[0][label];
					break;

			case "admin":
					include_once("model/DAO.class.php");
				    $dao=new DAO();
					$dados=explode("|",$complemento);
					$selecao=$dao->selectFree("select id, $dados[1] as label from $dados[0] where id=$campo order by $dados[1] asc");
					$retorno= $selecao[0][label];
					break;
					
			case "radio":
					include_once("model/DAO.class.php");
				    $dao=new DAO();
					$dados=explode("|",$complemento);
					$selecao=$dao->selectFree("select id, $dados[1] as label from $dados[0] where id=$campo order by $dados[1] asc");
					$retorno= $selecao[0][label];
					break;
					
			case "checkBox":
					include_once("model/DAO.class.php");
				    $dao=new DAO();
					$dados=explode("|",$complemento);
					$checkBox=$dao->selectFree("select id, $dados[1] as label from $dados[0] where id in($campo) order by $dados[1] asc");
					if($checkBox){
						$retorno="<span style='text-align:justify'><ol>";
						foreach($checkBox as $c){
							$retorno.= "<li>".$c[label];
						}
						$retorno.="</ol></span>";
					}
					break;

		}
		return $retorno;
	}
?>