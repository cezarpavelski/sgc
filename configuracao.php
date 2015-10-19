<?php 
	include_once('validar.php');
	
	//Marca D´agua
	$marcaDagua=0;/*1 para ativo ou 0 para inativo*/ 
	$logoMarcaDagua='imagens/logo.png';
	/*$posicaoMarcaDagua= IMGHANDLER_LOGO_BOTTOM_RIGHT;
	 Opcoes de Posicoes
		IMGHANDLER_LOGO_TOP_LEFT
		IMGHANDLER_LOGO_TOP_RIGHT
		IMGHANDLER_LOGO_TOP_CENTER
		IMGHANDLER_LOGO_BOTTOM_LEFT
		IMGHANDLER_LOGO_BOTTOM_RIGHT
		IMGHANDLER_LOGO_BOTTOM_CENTER
		IMGHANDLER_LOGO_MIDDLE_LEFT
		IMGHANDLER_LOGO_MIDDLE_RIGHT
		IMGHANDLER_LOGO_MIDDLE_CENTER
	*/
	
	
	//Tamanho da miniatura da imagem
	$thumbWidth=170;
	$thumbHeight=110;
	
	//Máximo de páginas para listar
	$maxPaginas=20;
	
	//Caminho para salvar os arquivos 
	$diretorio="uploads";
	
	//Configuracao para o CPanel
	$hostCpanel="";
	$userCpanel="";
	$passCpanel="";
	
	//Configuracao para a Newsletter
	$nomeDoRemetente="Pavelski.net";
	$emailDoRemetente="acerteweb@yahoo.com.br";
	$senhaDoEmail="acerte@12369";
	$hostDoEmail="smtp.mail.yahoo.com.br";
	$tabelaDeEmails=array("newsletter"=>"Newsletter");
	
	//Login e senha para o google analytics
	$login_analytics="google@deumio.com.br";	
	$senha_analytics="xxx";
	
	//Configuracao padrão dos botoes
	$botaoGaleria = 0; /*1 para ativo ou 0 para inativo*/ 
	$botaoVisualizar = 1; /*1 para ativo ou 0 para inativo*/
	$botaoEditar = 1; /*1 para ativo ou 0 para inativo*/
	$botaoExcluir = 1; /*1 para ativo ou 0 para inativo*/
	$botaoAdicionar = 1; /*1 para ativo ou 0 para inativo*/
	
?>