<?php
@header("Content-Type: text/html; charset=iso-8859-1",true);
include("../../_setadmin/conecte.php");

$q = mysql_real_escape_string( $_GET['q'] );
$tabela = mysql_real_escape_string( $_GET['tabela'] );
$campoID = mysql_real_escape_string( $_GET['campo'] );

$sql = "SELECT * FROM $tabela where $campoID like '%$q%' order by nome limit 10";

$res = mysql_query( $sql );

while( $campo = mysql_fetch_array( $res ) )
{
	$nome = $campo['nome'];
	$id = $campo['id'];
	$html = preg_replace("/(" . $q . ")/i", "<span style=\"font-weight:bold\">\$1</span>", strtoupper($nome));
	echo "<li onselect=\"this.setText('$nome').setValue('$id');\">$html</li>\n";
}

?>