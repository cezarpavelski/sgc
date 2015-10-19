<?php  @header("Content-Type: text/html; charset=iso-8859-1",true);?>
<script type="text/javascript" src="extra/mask.js"></script>
<script type="text/javascript" src="extra/autocomplete/js/autocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="extra/autocomplete/css/autocomplete.css">
<script type="text/javascript" src="extra/jquery/jquery.validate.js"></script>
<link href="extra/calendario/jquery.click-calendario-1.0.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="extra/calendario/jquery.click-calendario-1.0.js"></script>		

<style type="text/css">

.clear{
   clear:both;
}

label.error{ 
	color:#990000; 
	display:block; 
	font-family: Verdana; 
	font-size:10px;
	height:30px; 
	background: url('extra/warning.png') no-repeat 2px;
	padding:17px 0 0 30px;
	text-align:left;
}



</style>



<?php 

class Formulario{

	private $id;
	
	private $name;

	private $value;

	private $opcoes;

	private $label;

	private $action;

	private $method;

	private $mascara;

	private $rules=null;

	private $mensagens=null;

	private $script;

	

	/*action="String", method="post", opcoes=array() */

	public function criarCabecalhoForm($action="",$id="meuForm", $method="post",$opcoes=array()){

		$this->action = $action;

		$this->method = $method;

		$this->opcoes = $opcoes;
		
		$this->id = $id;

		

		$tag="<form action='$action' method='$method' id='$this->id' style='margin: 0' ";

		if($opcoes){
			
			while (current($this->opcoes)) {

				$key = key($this->opcoes);

		        $todasOpcoes .= $key."='".$opcoes[$key]."' ";

				next($this->opcoes);

			}

		}

		$tag.= $todasOpcoes.">";

		return $tag;

	}

		

	/* label:String, name=String, value=String, opcoes=array()*/

	public function criarTag($label="",$name="",$value="",$opcoes=array(),$mascara=null){

		$this->name = $name;

		$this->value = $value;

		$this->opcoes = $opcoes;

		$this->label = $label;

		$this->mascara = $mascara;

		$onFocus = array(onfocus=>"this.style.backgroundColor=\"#f9f2cb\";", onblur=>"this.style.backgroundColor=\"#FFFFFF\"");
		$opcoes = array_merge($onFocus,$opcoes);
		$this->opcoes=$opcoes;
		

		$existe = array_key_exists('type', $this->opcoes);

		if($existe){

			$todasOpcoes=null;

			while (current($this->opcoes)) {

				$key = key($this->opcoes);

				if($key!="type" && $key!="option"){

		        	$todasOpcoes .= $key."='".$opcoes[$key]."' ";

				}

				next($this->opcoes);

			}

			$todasOpcoes .= self::colocarMascaraInput();

			switch ($opcoes["type"]){

				case "submit":

					$tag="<input type='submit' name='$this->name' value='$label' $todasOpcoes";

					break;
				
				case "text":

					$tag="$this->label<input type='text' name='$this->name' value='$this->value' $todasOpcoes";

					break;
				
				case "hidden":

					$tag="$this->label<input type='hidden' name='$this->name' value='$this->value' $todasOpcoes";

					break;

				case "password":

					$tag="$this->label<input type='password' name='$this->name' value='$this->value' $todasOpcoes";

					break;

				case "file":

					$tag="$this->label<input type='file' name='$this->name' $todasOpcoes";

					break;

				case "textarea":
					
					$tag="$this->label<textarea name='$this->name' $todasOpcoes$this->value</textarea>";
					$tag=str_replace("<span class='clear'></span>","$this->value</textarea><span class='clear'></span>",$tag);
					

					break;

				case "select":

					$existeOption = array_key_exists('option', $this->opcoes);

					if($existeOption){

						$valoresOption=null;

						$arrayOption=$opcoes["option"];
						
						$selected = $opcoes["option"]["selected"];

						while (current($arrayOption)) {

							$key = key($arrayOption);
							
							if($key!="selected"){
								
						        $valoresOption .= "<option value='$key'";
						        
						        if ($selected==$key){
						        	$valoresOption .= " selected='true'";
						        }
						        
						        $valoresOption .= ">".$arrayOption[$key]."</option>";
							}
							next($arrayOption);

						}

					}

					$tag="$this->label<select name='$this->name' $todasOpcoes";

					$tag.=$valoresOption;

					$tag.="</select>";

					break;

				case "checkbox":

					$tag="<input type='checkbox' name='$this->name' value='$this->value' $todasOpcoes $this->label";

					break;

				case "radio":

					$tag="<input type='radio' name='$this->name' value='$this->value' $todasOpcoes $this->label";

					break;

			}

		}

		return $tag;

	}


                                                                       
	public function colocarMascaraInput(){
		$opcao=$this->opcoes;
        $idigm = "icon".$this->name;
		switch ($this->mascara){
			//necessita ter id para utilizar
			case "autoComplete":				
				$mascara=" />
				        <input type='hidden' id='".$opcao[id]."_val' name='id_".$this->name."' value=''/>
					    <script>
						    $(document).ready(function(){
							new Autocomplete('".$this->name."', function() {
								this.setValue = function(id) {
									$('#".$opcao[id]."_val').val(id);
								}
								if ( this.isModified )
									this.setValue('');
								if ( this.value.length < 1 && this.isNotClick ) 
									return ;
								return 'extra/autocomplete/ajax.php?tabela=".$opcao[tabela][tabela]."&campo=".$opcao[tabela][campo]."&q=' + this.value;
							});
						
						});
						</script";
			
				break;
			
			//necessita ter id para utilizar
			case "calendario":
				$mascara=" maxlength='10' readonly>&nbsp;<img src='extra/calendario/icon_calendario.png' id='".$idigm."' border='0' style='cursor:pointer'>
					    <script>
					    $(document).ready(function(){
							$('#".$opcao[id]."').focus(function(){	
								$(this).calendario({		
									target:'#".$opcao[id]."',
									top:0,		
									left:465
								});
							});	
						});
						$(document).ready(function(){
							$('#".$idigm."').click(function(){
								$(this).calendario({
									target:'#".$opcao[id]."',
									top:0,		
									left:0	
								});
							});	
						});
						</script";
				
				break;

			case "data":

					$mascara="onkeypress='javascript:return mascaraEntrada(this,\"99/99/9999\",event);' maxlength='10'><span class='clear'></span";

					self::setRules("$this->name: {dateBR: true},");

					self::setMensagens("$this->name: {dateBR: 'Digite uma data válida'},");

					break;

			case "telefone":

					$mascara="onkeypress='javascript:return mascaraEntrada(this,\"(99)9999-9999\",event);' maxlength='13'";

					break;

			case "cpf":

					$mascara="onkeypress='javascript:return mascaraEntrada(this,\"999.999.999-99\",event);' maxlength='14'> <span class='clear'></span";

					self::setRules("$this->name: {cpf: true},");

					self::setMensagens("$this->name: {cpf: 'CPF Inválido'},");

					break;

			case "cnpj":

					$mascara="onkeypress='javascript:return mascaraEntrada(this,\"99.999.999/9999-99\",event);' maxlength='18'> <span class='clear'></span";

					self::setRules("$this->name: {cnpj: true},");

					self::setMensagens("$this->name: {cnpj: 'CNPJ Inválido'},");

					break;

			case "hora":

					$mascara="onkeypress='javascript:return mascaraEntrada(this,\"99:99:99\",event);' maxlength='8'";

					break;

			case "moeda":

					$mascara="onkeypress='javascript:return MascaraMoeda(this,\".\",\",\",event)'";

					break;

			case "cep":

					$mascara="onkeypress='javascript:return mascaraEntrada(this,\"99999-999\",event);' maxlength='9'";

					break;

			case "campoObrigatorio":

					$mascara="><span class='clear'></span";

					self::setRules("$this->name: {required: true},");

					self::setMensagens("$this->name: {required: 'Campo Obrigatório'},");

					break;

			case "email":

					$mascara="id='email'><span class='clear'></span";

					self::setRules("$this->name: {email: true},");

					self::setMensagens("$this->name: {email: 'E-mail inválido'},");

					break;

			case "url":

					$mascara="id='url'><span class='clear'></span";

					self::setRules("$this->name: {url: true},");

					self::setMensagens("$this->name: {url: 'URL Inválida'},");

					break;

		}

		return $mascara.">";

	}

   /* valueButton="String" */

	public function fecharCabecalhoForm(){

		$tag = self::mostrarScript();

		return $tag."</form>";

	}

	

	public function mostrarScript(){
		$novoId=$this->id;
		$script= "<script type='text/javascript'>

					$(document).ready(function(){

					   $('#".$novoId."').validate({

					      rules: {";

		$script.= self::getRules();

		$script.="},

      			  messages: {";

		$script.= self::getMensagens();

		$script.= "}

				   });

				});

				</script>";

		return $script;

	}


	public function getScript() {

		return $this->script;

	}

	

	public function setMensagens($mensagens) {

		$this->mensagens .= $mensagens;

	}



	public function setRules($rules) {

		$this->rules .= $rules;

	}



	public function getMensagens() {

		return substr($this->mensagens,0,-1);

	}



	public function getRules() {

		return substr($this->rules,0,-1);

	}



	public function getName() {

		return $this->type;

	}

	public function setLabel($label) {

		$this->label = $label;

	}



	public function getLabel() {

		return $this->label;

	}





	public function getValue() {

		return $this->value;

	}



	public function getOpcoes() {

		return $this->opcoes;

	}



	public function setName($type) {

		$this->type = $type;

	}



	public function setValue($value) {

		$this->value = $value;

	}



	public function setOpcoes($opcoes) {

		$this->opcoes = $opcoes;

	}

	

	public function setMascara($mascara) {

		$this->mascara = $mascara;

	}



	public function setMethod($method) {

		$this->method = $method;

	}



	public function setAction($action) {

		$this->action = $action;

	}
	
	public function setId($id) {

		$this->id = $id;

	}


	public function getMascara() {

		return $this->mascara;

	}



	public function getMethod() {

		return $this->method;

	}



	public function getAction() {

		return $this->action;

	}
	
	public function getId() {

		return $this->id;

	}

}



?>