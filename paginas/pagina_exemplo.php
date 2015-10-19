<?php
	//TITULO DA PAGINA
	$tituloDaPagina = "quem somos";
	
	//TABELA NO BANCO DE DADOS
	$tabela = "empresa";
	
    //GALERIA DE IMAGENS
	$galeria = 0; /*1 para ativo ou 0 para inativo*/ 

	//INFORMACOES PARA EDICAO E VISUALIZACAO DOS REGISTROS ******************************************
		
	$cadastro = array(
					labels=>array("ID","Nome","Descriчуo","Imagem"),
					campos=>array("id","nome","descricao","imagem"),
					tipo=>array("titulo","titulo","texto","imagem"),
					complemento=>array("","","","")
					); 
	
	//INFORMACOES PARA LISTAGEM DOS REGISTROS *******************************************************

	$listagem = array(
					labels=>array("ID","Nome","Descriчуo","Imagem"),
					campos=>array("id","nome","descricao","imagem"),
					tipo=>array("titulo","titulo","texto","imagem"),
					complemento=>array("","","300","")
					); 

	//ARQUIVO CONSTRUTOR RESPONSAVEL PELA CONSTRUCAO DA PAGINA
 	include_once "construtor.php";
 	
 	//LEGENDA****************************************************************************************
	/*
		TIPOS PARA CADASTRO:
				calendario => Coloca calendсrio na frente do input e formata a data no formato dd/mm/aaaa
				data => cria um input text e formata a data no formato dd/mm/aaaa e valida a data
				telefone => cria um input text e formata o telefone no formato (44) 9999-9999
				cpf => cria um input text e formata o cpf no formato 044.156.999-65 e valida o cpf
				cnpj => cria um input text e formata o cnpj no formato 01.679.152/0001-25 e valida o cnpj
				hora => cria um input text e formata a hora no formato hh:mm:ss
				moeda => cria um input text e formata a moeda no formato 1.234,34
				cep => cria um input text e formata o cep no formato 88999-000
				campoObrigatorio => cria um input text e deixa o campo obrigatorio
				email => cria um input text e valida o email Ex.: email valido cezarpavelski@yahoo.com.br
				url => cria um input text e valida a url Ex.: url valida http://www.pavelski.net
				titulo => cria um input text sem validacao
				texto => cria um textarea	
				imagem => cria um input file com validacao para somente arquivos jpg, jpeg, gif, png
				youtube => cria um input text para url do youtube e mostra o video se tiver
				
				arquivo => cria um input file sem validacao de arquivos
					|=>COMPLEMENTO => utilizado para validar os arquivos permitidos Ex.: doc|pdf|txt	
					
				selecao => cria um select de campos vindos de outra tabela
					|=>COMPLEMENTO => uso obrigatorio para o tipo selecao Ex.: tabela|campo	
				
				checkBox => cria campos check box com campos vindos de outras tabelas
					|=>COMPLEMENTO => uso obrigatorio para o tipo checkBox Ex.: tabela|campo	
					
				radio => cria campos radio buttom com campos vindos de outras tabelas
					|=>COMPLEMENTO => uso obrigatorio para o tipo checkBox Ex.: tabela|campo	
				
		TIPOS PARA LISTAGEM:
				data => imprime a data na tela no formato dd/mm/aaaa
				moeda => imprime o valor na tela no formato R$ 1.234,34
				titulo => imprime o texto na tela utilizado para varchar
				
				texto => imprime o texto na tela utilizado para text
					|=>COMPLEMENTO => imprime na tela a quantidade de caracteres desejado Ex.: 500,
									  senao passado nenhum valor imprime o texto todo	
				
				arquivo => mostra o icone da extensуo do arquivo ou o flash se a extensao for swf
				imagem => mostra a miniatura da imagem na tela
				
				youtube => mostra a miniatura do video ou o video dependendo do COMPLEMENTO
					|=>COMPLEMENTO => Nomenclatura: tipo|largura|altura => tipo: video ou imagem, se o tipo
									  for IMAGEM mostra a miniatura do video. Se o tipo for VIDEO mostra o video	
									  do tamanho passado, senуo possuir tamanho o video virс do tamanho padrao 450X300	
					
				selecao => imprime na tela o campo de outra tabela
					|=>COMPLEMENTO => uso obrigatorio Ex.: tabela|campo
					
				checkBox => imprime uma lista numerada de campos de outras tabelas
					|=>COMPLEMENTO => uso obrigatorio Ex.: tabela|campo
					
				radio => imprime na tela o campo de outra tabela
					|=>COMPLEMENTO => uso obrigatorio Ex.: tabela|campo
		
	*/ 

?>