<?php
//<img src='thumb.php?end=uploads/...&largura=...&altura=...'>

$largura = $_GET['largura'];
$altura = $_GET['altura'];

$jpeg = $_GET['end'];
$jpeg=strtolower($jpeg);
$tam=strlen($jpeg);
$tipo=substr($jpeg,-3);
//echo $tipo;

if($d=getimagesize($jpeg)){
	if (!$largura or $largura==0) $largura = ($altura*$d[0])/$d[1];
	if (!$altura or $altura==0) $altura = ($largura*$d[1])/$d[0];
	$p_final = $largura/$altura;
	$p_orig = $d[0]/$d[1];

	if ($p_orig >= $p_final) {
		$nova_largura = ($d[0]-(($largura*$d[1])/$altura))/2;
		$x_i = $nova_largura;
		$x_f = $d[0]-$nova_largura*2;
		
		$y_i = 0;
		$y_f = $d[1];
	} else {
		$x_i = 0;
		$x_f = $d[0];
		
		$nova_altura = ($d[1]-(($altura*$d[0])/$largura))/2;
		$y_i = $nova_altura;
		$y_f = $d[1]-$nova_altura*2;
	}
	if($tipo=="jpg"):
	header('Content-type: image/jpeg');
	$src = imagecreatefromjpeg($jpeg);
	$dst = ImageCreateTrueColor($largura, $altura);
	$white = imagecolorallocate($dst,255,255,255);  
	imagefill($dst,0,0,$white);
	imagecopyresampled($dst,$src,0,0,$x_i,$y_i,$largura,$altura,$x_f,$y_f);
	imagejpeg($dst, null, 98);
	imagedestroy($dst);
	imagedestroy($src);
	
	elseif($tipo=="png"):
	header('Content-type: image/png');
	$src = imagecreatefrompng($jpeg);
	$dst = ImageCreateTrueColor($largura, $altura);
	$white = imagecolorallocatealpha($dst,0,0,0,127);  
	imagefill($dst,0,0,$white);

	imagecopyresampled($dst,$src,0,0,$x_i,$y_i,$largura,$altura,$x_f,$y_f);
	imagepng($dst);
	imagedestroy($dst);
	imagedestroy($src);
	
	elseif($tipo=="gif"):
	header('Content-type: image/gif');
	$src = imagecreatefromgif($jpeg);
	$dst = imagecreatetruecolor($largura, $altura);
	$white = imagecolorallocatealpha($dst,0,0,0,127);  
	imagefill($dst,0,0,$white);

	imagecopyresampled($dst,$src,0,0,$x_i,$y_i,$largura,$altura,$x_f,$y_f);
	imagegif($dst, null, 98);
	imagedestroy($dst);
	imagedestroy($src);

	endif;
}
?>