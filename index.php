<?php 
	include_once('configuracao.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  	<title>SGC - Sistema de Gerenciamento de Conteúdo</title>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<script type="text/javascript" src="extra/autocomplete/js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/jModal/jModal.js"></script>
	<script type="text/javascript" src="js/flash.js"></script>
	<link rel="stylesheet" type="text/css" href="js/shadowbox/shadowbox.css">
	<script type="text/javascript" src="js/shadowbox/shadowbox.js"></script>
	<script type="text/javascript">
		Shadowbox.init({ language: 'pt-BR', players:  ['img', 'html', 'iframe', 'qt', 'wmp', 'swf', 'flv', 'php', 'htm'] });
	</script>
	<?php include('editorDeTexto.html');?>
	<link rel="stylesheet" type="text/css" href="css/estilos.css" />
</head>
<body style="margin: 0 0 0 0">
<table cellpadding="0" cellspacing="0" width="100%" border="0" style="height:100%; background-color:#ffffff">
	<tr>
		<td style="height:70px; background:url('imagens/bg.jpg') repeat-x; text-align: left; width:80%">	
			<?php include('confirmaDelete.html');?>
			<?php include('alert.html');?>
			<a href="index.php">
				<img src="imagens/logo.png" alt="Pavelski.net" title="Pavelski.net" border="0"/>
			</a>
		</td>
		<td style="width:20%; color:#7f8a94; text-align: right; background:url('imagens/bg.jpg') repeat-x; padding:15px 15px 0 0" align="right">
			Olá, <b><?php echo $_SESSION[user];?></b> | <a href="logout.php" style="color:#7f8a94">Sair</a><br/><br/>
		</td>
	</tr>
	<tr>
		<td style="background-color:#f8f8f8; border:1px solid #e4e4e4; text-align: left; padding:5px; height:45px" colspan="2">
			<?php include_once("menu.php");?>
		</td>
	</tr>
	<tr>
		<td style="text-align: left; padding:15px 5px 5px 5px;" colspan="2" valign="top">
			<?php
			   $pg=$_GET['pg'];
			   if(!$pg){
			      include('home.php');
			   }else{
			   	  if($pg!="galeria" && $pg!="home" && $pg!="usuarios" && $pg!="analytics" && $pg!="contasEmail" && $pg!="newsletter" && $pg!="enviarNewsletter" && $pg!="visualizarNewsletter"){
		       	  	include("paginas/".$pg.".php");
		       	  	//ARQUIVO CONSTRUTOR RESPONSAVEL PELA CONSTRUCAO DA PAGINA
 			   		include_once "construtor.php";
			   	  }else{
		       	  	include($pg.".php");
			   	  }
			   }
		    ?>
		</td>
	</tr>
</table>
<br/><br/>
<div style="text-align:center; font-size:12px; padding:10px 0 5px 0; margin:0; background:url('imagens/bg.jpg') repeat-x; color:#FFFFFF; width:100%; height:20px; bottom:0; position:fixed">
	<center><a href="http://www.pavelski.net" target="_blank">Pavelski.net</a> © Todos os direitos reservados</center>
</div>
</body>
</html>
