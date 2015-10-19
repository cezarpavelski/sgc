<?php 
	session_start();
	include_once("model/DAO.class.php");
	$dao=new DAO();
	$arquivo=$_REQUEST['arquivo'];
	$tabela=$_REQUEST['tabela'];
	$campo=$_REQUEST['campo'];
	$update=$dao->selectFree("UPDATE $tabela SET $campo='' WHERE $campo='$arquivo'");
	@unlink('uploads/'.$arquivo);
	@unlink('uploads/thumb_'.$arquivo);
	header("Location: $_SESSION[paginaAtual]");
?>