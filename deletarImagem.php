<?php
$arquivo=$_GET["arquivo"];
$diretorio=$_GET["diretorio"];
unlink($diretorio."/".$arquivo); 
unlink($diretorio."/thumb_".$arquivo);
?>
<script>history.go(-1);</script>