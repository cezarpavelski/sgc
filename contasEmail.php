<?php
	//TITULO DA PAGINA
	$tituloDaPagina = "gerenciamento de emails";
	
	//TABELA NO BANCO DE DADOS
	$tabela = "contas_email";
	
    //GALERIA DE IMAGENS
	$galeria = 0; /*1 para ativo ou 0 para inativo*/ 
	
	//INFORMACOES PARA EDICAO E VISUALIZACAO DOS REGISTROS ******************************************
		
	$cadastro = array(
					labels=>array("ID","Email","Senha","Quota (MB)"),
					campos=>array("id","email","senha","quota"),
					tipo=>array("titulo","email","senha","enum"),
					complemento=>array("","","","","")
					); 
	
	//INFORMACOES PARA LISTAGEM DOS REGISTROS *******************************************************

	$listagem = array(
					labels=>array("ID","Email","Senha","Quota (MB)"),
					campos=>array("id","email","senha","quota"),
					tipo=>array("titulo","email","senha","enum"),
					complemento=>array("","","","","")
					); 

	//ARQUIVO CONSTRUTOR RESPONSAVEL PELA CONSTRUCAO DA PAGINA
 	include_once "construtor.php";
?>