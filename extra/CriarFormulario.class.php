<?php
include_once("Formulario.class.php");
include_once("model/DAO.class.php");
class CriarFormulario extends Formulario{
	public function montarFormulario($name,$value,$tabela,$tipo,$complemento){
		switch ($tipo){
			//necessita ter id para utilizar
			case "autoComplete":				
				$retorno = $this->criarTag(null,$name,$value,array(type=>"text", "class"=>"caixa", id=>$name."_busca", tabela=>array(tabela=>$tabela,value=>$name)),"autoComplete");
				break;
			
			case "calendario":
				if($value){
					$value=explode("-",$value);
					$value=$value[2]."/".$value[1]."/".$value[0];
				}
				$retorno = $this->criarTag(null,$name,$value,array(type=>"text", "class"=>"caixa", id=>$name),"calendario");				
				break;

			case "data":
					if($value){
						$value=explode("-",$value);
						$value=$value[2]."/".$value[1]."/".$value[0];
					}
					$retorno = $this->criarTag(null,$name,$value,array(type=>"text", "class"=>"caixa"),"data");
					$retorno .= " <b>Formato: dd/mm/aaaa</b>";
					break;

			case "telefone":
					$retorno = $this->criarTag(null,$name,$value,array(type=>"text", "class"=>"caixa"),"telefone");
					$retorno .= " <b>Formato: (ddd)0000-0000</b>";
					break;

			case "cpf":
					$retorno = $this->criarTag(null,$name,$value,array(type=>"text", "class"=>"caixa"),"cpf");
					$retorno .= " <b>Formato: 055.927.533-14</b>";
					break;

			case "cnpj":
					$retorno = $this->criarTag(null,$name,$value,array(type=>"text", "class"=>"caixa"),"cnpj");
					$retorno .= " <b>Formato: 17.542.180/0001-36</b>";
					break;

			case "hora":
					$retorno = $this->criarTag(null,$name,$value,array(type=>"text", "class"=>"caixa"),"hora");
					$retorno .= " <b>Formato: hh:mm:ss</b>";
					break;

			case "moeda":
					$retorno = $this->criarTag(null,$name,number_format($value,2,",","."),array(type=>"text", "class"=>"caixa"),"moeda");
					$retorno .= " <b>Formato: 1.222,90</b>";
					break;

			case "cep":
					$retorno = $this->criarTag(null,$name,$value,array(type=>"text", "class"=>"caixa"),"cep");
					$retorno .= " <b>Formato: 87320-010</b>";
					break;

			case "campoObrigatorio":
					$retorno = $this->criarTag(null,$name,$value,array(type=>"text", "class"=>"caixa"),"campoObrigatorio");
					$retorno .= " <b>* Campo Obrigatório</b>";
					//$retorno .="<span class='formInfo'><a href='ajax2.htm?width=475' class='jTip' id='1' name='Campo Obrigatório'>?</a></span>";
					break;

			case "email":
					$retorno = $this->criarTag(null,$name,$value,array(type=>"text", "class"=>"caixa"),"email");
					$retorno .= " <b>Formato: email@dominio.com.br</b>";
					break;

			case "url":
					$retorno = $this->criarTag(null,$name,$value,array(type=>"text", "class"=>"caixa"),"url");
					$retorno .= " <b>Formato: http://www.dominio.com.br</b>";
					break;
			
			case "titulo":
					$retorno = $this->criarTag(null,$name,$value,array(type=>"text", "class"=>"caixa"));
					break;
			
			case "admin":
					if($value){
						$dao=new DAO();
						$dados=explode("|",$complemento);
						$selecao=$dao->selectFree("select id, $dados[1] as label from $dados[0] where id=$value order by $dados[1] asc");
						$user=$selecao[0]['label'];
						$idUser=$selecao[0]['id'];
					}else{
						$user=$_SESSION['user'];
						$idUser=$_SESSION['idUser'];
					}
					$retorno = $this->criarTag(null,'',$user,array(type=>"text", "class"=>"caixa",readonly=>"readonly"));
					$retorno .= $this->criarTag(null,$name,$idUser,array(type=>"hidden", "class"=>"caixa"));
					break;
				
			case "senha":
					$retorno = $this->criarTag(null,$name,$value,array(type=>"password", "class"=>"caixa", style=>"float:left"));
					if($value){
						$retorno .= "&nbsp;&nbsp;<a href='verSenha.php?campo=$name&valor=$value&tabela=$tabela' rel='shadowbox;height=100;width=300' style='color:#666666'><img src='imagens/descobrirSenha.png' alt='Ver Senha' title='Ver Senha' border='0' style='padding:inline'/></a>";
					}
					break;
					
			case "texto":
					$retorno = $this->criarTag(null,$name,$value,array(type=>"textarea", "class"=>"textarea", style=>"height:350px; width:800px; overflow:auto;"));
					break;
			
			case "arquivo":
					if($value){
						$extension=explode(".",$value);
						switch ($extension[1]) {
							case "swf":
									$retorno = "<div id='swf' style='width:300px; margin:0'><script type='text/javascript'>conteudo('uploads/$value','300','100','swf');</script></div>"; 
									break;
							default:
								if(file_exists("imagens/file_icons/".$extension[1].".png")){
									$retorno = "<a href='uploads/$campo' target='_blank'><img src='imagens/file_icons/".$extension[1].".png' border='0' alt='".$campo."' title='".$campo."'/></a>";
								}else{
									$retorno = "<a href='uploads/$value' target='_blank'><img src='imagens/file_icons/semextensao.png' border='0' alt='".$value."' title='".$value."'/></a>";
								}
								break;
						}
						$retorno .= "<a href='deletarArquivo.php?arquivo=".$value."&tabela=".$tabela."&campo=".$name."' class='confirm'><img src='imagens/del.png' border='0' alt='Deletar Arquivo' title='Deletar Arquivo'/></a><br/><br/>";
						$retorno .= "<input type='hidden' name='hidden_$name' value='$value'/>";
					}
					$retorno .= $this->criarTag(null,$name,$value,array(type=>"file", "class"=>"caixa", accept=>"$complemento"));
					if($complemento){
						$this->setMensagens("$name: {accept: 'Somente $complemento'},");
						$retorno .= "&nbsp;&nbsp;&nbsp;&nbsp;<b>* Somente $complemento</b>";
					}
					break;
					
			case "imagem":
					if($value){
						$retorno = "<a href='uploads/".$value."' rel='shadowbox'>";
						$retorno .= "<img src='thumb.php?end=uploads/".$value."&largura=300' border='0' alt='".$value."' title='".$value."'/>";
						$retorno .= "</a>";
						$retorno .= "<a href='deletarArquivo.php?arquivo=".$value."&tabela=".$tabela."&campo=".$name."' class='confirm'><img src='imagens/del.png' border='0' alt='Deletar Arquivo' title='Deletar Arquivo'/></a><br/><br/>";
						$retorno .= "<input type='hidden' name='hidden_$name' value='$value'/>";
					}
					$this->setMensagens("$name: {accept: 'Somente jpg|jpeg|png|gif'},");
					$retorno .= $this->criarTag(null,$name,$value,array(type=>"file", "class"=>"caixa", accept=>"jpg|jpeg|png|gif"));
					$retorno .= "&nbsp;&nbsp;&nbsp;&nbsp;<b>* Somente jpg|jpeg|png|gif</b>";
					break;
			
			case "youtube":
					if($value){
						echo $video=new Video($value,450,300)."<br/>";
					}
					$retorno .= $this->criarTag(null,$name,$value,array(type=>"text", "class"=>"caixa"),"url");
					$retorno .= "&nbsp;<b>* URL do Youtube - Formato: http://www.dominio.com.br</b>";
					break;
					
			case "selecao":
				    $dao=new DAO();
					$dados=explode("|",$complemento);
					$selecao=$dao->selectFree("select id, $dados[1] as label from $dados[0] order by $dados[1] asc");
					if($value){
						$options['selected']=$value;
					}
					$options[null]="SELECIONE UM REGISTRO";
					foreach($selecao as $s){
						$options[$s[id]]=ucwords($s[label]);
					}
					$retorno= $this->criarTag(null,$name,"",array(type=>"select","class"=>"caixa", option=>$options))."&nbsp;&nbsp;";
					break;
			
		    case "checkBox":
				    $dao=new DAO();
				    $value=explode(",",$value);
					$dados=explode("|",$complemento);
					if($dados[0]=="permissao"){
						$i=0;
						$keys = array_keys($_SESSION['menu']);
						foreach ($keys as $k) {
							$checkBox[$i]['id']=$i;
							$checkBox[$i]['label']=$k;
							$i++;
						}
					}else{
						$checkBox=$dao->selectFree("select id, $dados[1] as label from $dados[0] order by $dados[1] asc");
					}
					$i=1;
					foreach($checkBox as $CB){
						if (in_array($CB[id], $value)) { 
							$checked=true;
						}else{
							$checked=false;
						}
						$retorno .= $this->criarTag(ucwords($CB[label]),"check_".$dados[0].$i++,$CB[id],array(type=>"checkbox",checked=>$checked))."<br/>";
					}
					break;
			
			case "radio":
				    $dao=new DAO();
					$dados=explode("|",$complemento);
					$radio=$dao->selectFree("select id, $dados[1] as label from $dados[0] order by $dados[1] asc");
					foreach($radio as $r){
						if ($r[id]==$value) { 
							$checked=true;
						}else{
							$checked=false;
						}
						$retorno .= $this->criarTag(ucwords($r[label]),"radio_".$dados[0],$r[id],array(type=>"radio", checked=>$checked))."<br/>";
					}
					break;
			case "selecaoAjax":
					$dao=new DAO();
					$dados=explode("|",$complemento);//nome do outro select|campo id na tabela|nome da tabela|campo result
					$retorno='<script type="text/javascript">
								$().ready(function() {
									$("select[name='.$dados[0].']").change(function(){
										$(\'select[name='.$name.']\').html(\'<option value="">Procurando...</option>\');
										$.post(\'extra/BuscarRegistros.php\',
											{ valor : $(this).val(),
											  campoid : "'.$dados[1].'",
											  camporesult : "'.$dados[3].'",
											  tabela: "'.$dados[2].'"},
											function(resposta){
												$(\'select[name='.$name.']\').html(resposta);
											}
										);
									});
								});
							  </script>';
					if($value){
						$idOutraTabela=$dao->selectFree("select $dados[1] as idTabela from $dados[2] where id=$value order by $dados[3] asc");
						$selecao=$dao->selectFree("select id, $dados[3] as nome from $dados[2] where $dados[1]=".$idOutraTabela[0][idTabela]." order by $dados[3] asc");
						$options['selected']=$value;
						$options[null]="SELECIONE UM(A) ".strtoupper($name);
						foreach($selecao as $s){
							$options[$s[id]]=ucwords($s[nome]);
						}
						$retorno.= $this->criarTag(null,$name,"",array(type=>"select","class"=>"caixa", option=>$options));
					}else{
						$retorno .='<select name="'.$name.'" class="caixa">
									<option value="0">SELECIONE UM(A) '.strtoupper($dados[0]).'</option>
								</select>';
					}
					
					break;
			case "enum":
				    $dao=new DAO();
					$enum=$dao->selectFree("describe $tabela");
					foreach($enum as $e){
						if(strstr($e['Type'],"enum")){
							$arrayBusca=array("enum(",")","'",'"');
							$arrayTroca=array("","","","");
							$registros=explode(",",str_replace($arrayBusca,$arrayTroca,$e[Type]));
						}
					}
					if($value){
						$options['selected']=$value;
					}
					$options[null]="SELECIONE UM REGISTRO";
					for($i=0; $i<count($registros); $i++){
						$options[$registros[$i]]=ucwords($registros[$i]);
					}
					$retorno= $this->criarTag(null,$name,"",array(type=>"select","class"=>"caixa", option=>$options))."&nbsp;&nbsp;";
					break;

		}
		return $retorno;
	}
}
?>