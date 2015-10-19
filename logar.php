<?php 
	session_start();
	header("Content-Type: text/html; charset=iso-8859-1",true);
	include('model/DAO.class.php');
	$dao=new DAO();
	$login=$_POST[login];
	$senha=$_POST[senha];
	$dados=$dao->selectAll("admin where login='$login' and senha='$senha'");
	if($dados){
		$_SESSION['menu']="";
		$_SESSION['idUser'] = $dados[0][id];
		$_SESSION['user'] = $dados[0][nome];
		$_SESSION['tipoAdm'] = $dados[0][tipo];
		$_SESSION['permissao']=explode(",",$dados[0][permissao]);
		$_SESSION['admSGC'] = "OK";
		echo "Validação aceita";
	}else{
		echo "* Dados Inválidos!";
	}
?>