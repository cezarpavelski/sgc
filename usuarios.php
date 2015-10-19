<?php
	//TITULO DA PAGINA
	$tituloDaPagina = "usuários";
	
	//TABELA NO BANCO DE DADOS
	$tabela = "admin";
	
    //GALERIA DE IMAGENS
	$galeria = 0; /*1 para ativo ou 0 para inativo*/ 
	
	//INFORMACOES PARA EDICAO E VISUALIZACAO DOS REGISTROS ******************************************
		
	$cadastro = array(
					labels=>array("ID","Apelido","Nome","Login","Senha","Permissão","Tipo do Usuário"),
					campos=>array("id","apelido","nome","login","senha","permissao","tipo"),
					tipo=>array("titulo","campoObrigatorio","titulo","campoObrigatorio","senha","checkBox","enum"),
					complemento=>array("","","","","","permissao")
					); 
	
	//INFORMACOES PARA LISTAGEM DOS REGISTROS *******************************************************

	$listagem = array(
					labels=>array("ID","Nome","Login", "Tipo do Usuário"),
					campos=>array("id","nome","login","tipo"),
					tipo=>array("titulo","titulo","titulo","enum"),
					complemento=>array("","","")
					); 

	//ARQUIVO CONSTRUTOR RESPONSAVEL PELA CONSTRUCAO DA PAGINA
 	include_once "construtor.php";
?>