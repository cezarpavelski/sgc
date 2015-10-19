<table cellpadding="0" cellspacing="0" style="width:100%; text-align: left;" align="center" border="0">
	<tr>
		<td style="padding:10px; color:#7f8a94; text-align: left; font-size:26px; font-family:'Century Gothic', Verdana">
			<b>GALERIA DE IMAGENS</b>
		</td>
	</tr>
	<tr>
		<td align='center'>
		<?php
		$diretorio="uploads";
		include("model/DAO.class.php");
		$dao=new DAO();
		$cod=$_GET['id'];
		$nometabela=$dao->selectFree("select nome from $_GET[tabela] where id=$cod limit 1");      				
		?>  
		<b style="font-size:16px"><?php echo $nometabela[0]['nome'];?></b><br><br>
		<table width="100%">
			<tr>
				<?php		
			    $path = $diretorio."/".$_GET[tabela].$_GET[id]; 
				$dh = @opendir($path);
				if($dh){
				while ($file = readdir($dh)){
					$pathdata = pathinfo($file); 
					if(eregi(".*\.(jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG){1}", $file))
    				{  
						$thumb=explode("_",$file);
						if($thumb[0]!="thumb"){
	    					echo "<td width='20%' align='center'>";  
							echo '<a href="'.$path."/".$file.'" rel="shadowbox[Vacation]">';   
							echo "<img src='thumb.php?end=".$path."/".$file."&altura=80&largura=80' border='0'><br>";
							echo "</a>";
							echo "<a href='deletarImagem.php?diretorio=".$diretorio."/".$_GET[tabela].$_GET[id]."&arquivo=".$file."' class='confirm'>";
							echo "<img src='imagens/del.png' border='0' alt='Deletar Imagem' title='Deletar Imagem'><br><br>";
							echo "</a>";
							echo "</td>";
							$cont=$cont+1;
							if($cont==5){
								echo "</tr><tr>";
								$cont=0;
							}
							$flag=1;
						}
    				}
				}
				closedir($dh);
				}
				if(!$flag){
					@mkdir($path, 0777);
					@chmod($path, 0777);    
					echo "<td align='center'><b>Nenhuma foto cadastrada!</b><br><br></td>";
				}
				?>
			</tr>
		</table>
        <?php $url=explode('index.php',$_SERVER['SCRIPT_NAME']);?>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			<script type="text/javascript">
				// Script de upload - Sempre muda o endereco do site
				var url = "http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $url[0]?>upload.php?id=<?php echo $_GET[id]?>&tabela=<?php echo $_GET[tabela]?>&m=<?php echo $marcaDagua?>&l=<?php echo $logoMarcaDagua;?>"; 
			</script>
		
			<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
			<script type="text/javascript" src="_js/jquery.progressbar.js"></script>
			<script type="text/javascript" src="_js/comum.js"></script>
		
			<style type="text/css">
				#arquivos { display:none; }
				.c30p { width:30%; float:left; }
				.c100 { width:100px; float:left; }
				.bold { font-weight:700; }
				.ac { text-align:center; }
				.sep { background-color:#EEE; height:1px; line-height:1px; clear:both; margin:1px; }
				#totais_arquivos { display:none; }
			</style>
		
			<div>
				<script type="text/javascript">
					// Para M$ IE
					if (document.all){
						
						document.write('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="137" height="27" id="uploader" align="middle">');
						document.write('<param name="allowScriptAccess" value="sameDomain" />');
						document.write('<param name="allowFullScreen" value="false" />');
						document.write('<param name="menu" value="false" />');
						document.write('<param name="movie" value="_swf/upload.swf" />');
						document.write('<param name="quality" value="high" />');
						document.write('<param name="bgcolor" value="#ffffff" />');
						document.write('<embed src="_swf/upload.swf" quality="high" bgcolor="#ffffff" width="137" height="27" name="uploader" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" menu="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />');
						document.write('</object>');
					}
					else // Outros navegadores
						document.write('<embed type="application/x-shockwave-flash" src="_swf/upload.swf" id="uploader" name="uploader" bgcolor="#ffffff" quality="high" allowscriptaccess="always" menu="false" width="137" height="27" />');
				</script>
			</div>
		
			<div id="arquivos">
				<div>
					<div class="c30p bold">Foto</div>
					<div class="c100 ac bold">Tamanho</div>
					<div class="c100 ac bold">Remover</div>
					<div class="c30p bold">Andamento</div>
				</div>
				<div id="lista_arquivos"></div>
				<div id="totais_arquivos">
					<span class="bold">
						Total de fotos: <span id="total_arquivos"></span>.
						Tamanho total: <span id="total_tamanho"></span>.
					</span>
					<br /><br />
					<input type='image' id="btUpload" src='imagens/enviar.png'>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td align="center" style="padding-top:20px">
			<a href="javascript:history.go(-1);">
				<img src="imagens/voltar.png" alt="Voltar" title="Voltar" border="0"/>
			</a>
		</td>
	</tr>
</table>	
	

