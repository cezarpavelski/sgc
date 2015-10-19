<?php 
	session_start();
	include_once("model/DAO.class.php");
	include_once("configuracao.php");
	$dao=new DAO();
	$id=$_REQUEST['id'];
	$tabela=$_REQUEST['tabela'];
	
	if($tabela=="contas_email"){
		$campos=$dao->selectUnique("id",$id,$tabela);
		//Deleta email no cpanel
		include("extra/cPanel.php");
		$cpanel=new emailAccount($hostCpanel,$userCpanel,$passCpanel,"2082",false,"x3",$campos[0][email]);
		$cpanel->delete();
	}
	$delete=$dao->selectFree("DELETE FROM $tabela WHERE id='$id'");
	header("Location: $_SESSION[paginaAtual]");
?>