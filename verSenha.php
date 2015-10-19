<?php
	include("model/DAO.class.php");
	$dao=new DAO();
	$campo=$_GET[campo];
	$valor=$_GET[valor];
	$tabela=$_GET[tabela];
	$senha=$dao->selectFree("select $campo as senha from $tabela where $campo='$valor' limit 1");
	echo "<div style='font-size:30px;widht:300px;height:100px;background-color:#FFFFFF;font-family:Verdana';text-align:center; color:#666666; vertical-align:center><center><br/>".$senha[0][senha]."</center></div>";
?>