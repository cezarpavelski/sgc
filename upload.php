<?php

include_once("extra/Thumbnail.class.php");
function upload($campo, $arquivo, $maximo = 15242880, $permitidos = array()){
	$arquivo=explode("|",$arquivo);
	$tmp_name = $campo['tmp_name'];
	$error    = $campo['error'];
	$size     = $campo['size'];
	$type     = $campo['type'];

	if ((!is_uploaded_file($tmp_name)) || ($error != 0) || ($size == 0) || ($size > $maximo))
		return false; // Não passou pela validação básica

	if ((is_array($permitidos)) && (!empty($permitidos))) {
		if (!in_array($type, $permitidos))
			return false; // tipo de arquivo nÃ£o permitido
	}

	// faz upload
	while (move_uploaded_file($tmp_name, $arquivo[2])) {
		// aguarda
	}
	
	/*$thumbnail=new Thumbnail();
	$thumbnail->createThumb($arquivo[2]);*/
	if($arquivo[0]==1){
		$thumbnail->setLogoFile($arquivo[1]);
		$thumbnail->insertLogo($arquivo[2]);
	}
	
	return true;
}

$marcaDagua=$_GET['m'];
$logoMarcaDagua=$_GET['l'];
$campo   = $_FILES['Filedata'];
$path_parts = pathinfo($campo['name']);
$extension = $path_parts['extension'];
$novo_nome=strtolower(md5(uniqid(time())).".".$extension);
$arquivo = $marcaDagua."|".$logoMarcaDagua."|uploads/".$_GET[tabela].$_GET[id]."/".$novo_nome;

echo upload($campo, $arquivo); 
?>
