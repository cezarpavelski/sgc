<script type="text/javascript" src="extra/autocomplete/js/jquery-1.3.2.min.js" charset="utf-8"></script>
<?php 
	include_once("extra/Formulario.class.php");
	$formulario=new Formulario();
	extract($_POST);
?>
<script type="text/javascript">
	$(function(){
		$("#enviar").click( function(){
			$().ajaxStart(function() { $('#msg_sucesso').show(); });
			var emailTeste = $('#emailTeste').val();
			var titulo = $('#titulo').val(); 
			var assunto = $('#assunto').val(); 
			var descricao = $('#descricao').val(); 
			if(!emailTeste){
				$("#msg_sucesso").html("<br/>Preencha o email!"); 
				$("#msg_sucesso").css('background-color', "#d45b4b"); 
				$('#msg_sucesso').show();
			}else{
				$("#msg_sucesso").text("<img src='imagens/loading.gif' width='24' height='24' style='float:left; margin:0 10px 10px 0;'/><br/>Enviando email de teste...");
				$("#msg_sucesso").css('background-color', "#7bd965");  
				$.post("enviarNewsletter.php",{emailTeste: emailTeste, titulo: titulo, assunto: assunto, descricao: descricao},function(data){
					$("#msg_sucesso").html("<br/>"+data); 
				}); 
			}
		}); 
	});
</script>
<script type="text/javascript">
	$(function(){
		$("#enviarBaseEmail").click( function(){
			$().ajaxStart(function() { $('#msg_sucesso').show(); });
			var titulo1 = $('#tituloNews').val(); 
			var assunto1 = $('#assuntoNews').val(); 
			var descricao1 = $('#descricaoNews').val();
			var baseemail = $('#baseEmail').val(); 
			$("#msg_sucesso").css('background-color', "#7bd965");  
			$("#msg_sucesso").html("<img src='imagens/loading.gif' width='24' height='24' style='float:left; margin:0 10px 10px 0;'/><br/>Enviando newsletter..."); 
			window.location.hash='#topo';
			$.post("enviarNewsletter.php",{baseemail: baseemail, titulo: titulo1, assunto: assunto1, descricao: descricao1},function(data){
				$("#msg_sucesso").html("<br/>"+data); 
			}); 
		}); 
	});
</script>
<table cellpadding="0" cellspacing="0" style="width:100%; text-align: left;" align="center" border="0">
	<tr>
		<td style="padding:10px 10px 20px 0; color:#7f8a94; text-align: left; font-size:26px; font-family:'Century Gothic', Verdana">
			<span style="width:2px; height:40px; padding:5px; background:url('imagens/bg.jpg') repeat-x; text-align: left; display:inline">&nbsp;</span>
			<span style="height:40px; background:#f8f8f8; text-align: left; padding:5px;display:inline" id="topo">
				NEWSLETTER
			</span>
			<br/>
		</td>
	</tr>	
	<tr>
		<td align='center' style="font-family:'Century Gothic', Verdana;">	
			<div id="msg_sucesso" style="text-align:justify; width:100%; font-family:Verdana; line-height:6px; font-size:12px; color:#ffffff; border:1px dashed #666666; margin:0 0 10px 0;background-color:#7bd965; display:none; padding:10px 10px 20px 10px;"><img src='imagens/loading.gif' width='24' height='24' style='float:left; margin:0 10px 10px 0;'/><br/>Enviando newsletter...</div>
			<table cellpadding="0" cellspacing="0" width="100%" border="0">	
				<tr style="background-color:#f0f0f0">
					<td style="text-align:left;padding:8px"><b>ENVIAR EMAIL DE TESTE</b></td>
					<td style="padding:5px;text-align:left">
						<?php echo $formulario->criarCabecalhoForm("#","formNewsletter");?>
							<?php echo $formulario->criarTag(null,"email","DIGITE O EMAIL AQUI",array(type=>"text", "class"=>"caixa",id=>"emailTeste",onfocus=>"javascript:this.value=\"\"",style=>"float:left;margin:2px 5px 0 0"),"email");?>
							<input type="hidden" name="titulo" id="titulo" value="<?php echo $titulo;?>" />
							<input type="hidden" name="assunto" id="assunto" value="<?php echo $assunto;?>" />
							<input type="hidden" name="descricao" id="descricao" value="<?php echo htmlspecialchars($descricao);?>" />
							<input type='image' src='imagens/enviar.png' name="enviar" id="enviar" onclick="return false" style="float:left">
						<?php echo $formulario->fecharCabecalhoForm();?>
					</td>
				</tr>
				<tr style="background-color:#ffffff">
					<td style="text-align:left;padding:8px" colspan="2">
						<b style="font-size:20px">VISUALIZAÇÃO DA NEWSLETTER</b><br/><br/>
						<?php
							echo "Assunto do Email: <b>".$assunto."</b><br/><br/>";
							echo "<fieldset>
								   <legend><b>Corpo do Email</b></legend><br/>";
									echo $descricao;
							echo "</fieldset>";	
						?>	
						<br/>
						<?php echo $formulario->criarCabecalhoForm("#","formNewsletterBase");?>
							<input type="hidden" name="tituloNews" id="tituloNews" value="<?php echo $titulo;?>" />
							<input type="hidden" name="assuntoNews" id="assuntoNews" value="<?php echo $assunto;?>" />
							<input type="hidden" name="descricaoNews" id="descricaoNews" value="<?php echo htmlspecialchars($descricao);?>" />
							<input type="hidden" name="baseEmail" id="baseEmail" value="<?php echo htmlspecialchars($baseEmail);?>" />
							<br/><input type='image' src='imagens/enviarNewsletter.png' name="enviarBaseEmail" id="enviarBaseEmail" onclick="return false;">
						<?php echo $formulario->fecharCabecalhoForm();?>
					</td>
				</tr>
			</table>	
			<br><br>		
		</td>	
	</tr>
</table>