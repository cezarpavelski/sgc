<?php 
	@header("Content-Type: text/html; charset=iso-8859-1",true);
	include("../model/DAO.class.php");
	$tabela=$_POST['tabela'];
	$valor=$_POST['valor'];
	$campoId=$_POST['campoid'];
	$campoResult=$_POST['camporesult'];
	$dao=new DAO();
	$sql="select id,".$campoResult." as nome from ".$tabela." where ".$campoId."=".$valor." order by ".$campoResult." asc";
	$campos=$dao->selectFree($sql);
	if(count($campos)>0){
		echo "<option value=''>SELECIONE UM REGISTRO</option>";
		foreach ($campos as $c){
			echo "<option value='$c[id]'>".ucwords($c[nome])."</option>";
		}
	}else{
		echo "<option value=''>NENHUM REGISTRO ENCONTRADO</option>";
	}

?>
