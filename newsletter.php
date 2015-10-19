<?php 
	include_once("extra/CriarFormulario.class.php");
	$formulario=new CriarFormulario();
	$cadastro = array(
					labels=>array("Título","Assunto","Descrição"),
					campos=>array("titulo","assunto","descricao"),
					tipo=>array("campoObrigatorio","campoObrigatorio","texto"),
					complemento=>array("","","","","")
					);
?>
<table cellpadding="0" cellspacing="0" style="width:100%; text-align: left;" align="center" border="0">
	<tr>
		<td style="padding:10px 10px 20px 0; color:#7f8a94; text-align: left; font-size:26px; font-family:'Century Gothic', Verdana">
			<span style="width:2px; height:40px; padding:5px; background:url('imagens/bg.jpg') repeat-x; text-align: left; display:inline">&nbsp;</span>
			<span style="height:40px; background:#f8f8f8; text-align: left; padding:5px;display:inline">
				NEWSLETTER
			</span>
			<br/>
		</td>
	</tr>	
	<tr>
		<td align='center' style="font-family:'Century Gothic', Verdana;">		
			<?php echo $formulario->criarCabecalhoForm("index.php?pg=visualizarNewsletter","form","post");?>
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr style="background-color:#ffffff">
						<td style="text-align:left;padding:8px"><b>BASE DE EMAIL</b></td>
						<td style="padding:5px;text-align:left">
							<input type="hidden" name="incluir" value="1"/>
							<?php 
								$todosEmails=array_keys($tabelaDeEmails);
								$todosEmails=implode(",", $todosEmails);
								$tabelaDeEmails[$todosEmails]="TODOS";
								$tabelaDeEmails=array_reverse($tabelaDeEmails);
								echo $formulario->criarTag(null,"baseEmail","",array(type=>"select","class"=>"caixa", option=>$tabelaDeEmails));
							?>
						</td>
					</tr>
					<?php 
						$j=0;
						foreach ($cadastro[labels] as $cl) {
							if($flag==1){
								$bgcolor="#ffffff";
								$flag=0;
							}else{
								$bgcolor="#f0f0f0";
								$flag=1;
							}
					?>
							<tr style="background-color:<?php echo $bgcolor;?>">
								<td style="text-align:left;padding:8px"><b><?php echo strtoupper($cl);?></b></td>
								<td style="padding:5px;text-align:left">
									<input type="hidden" name="incluir" value="1"/>
									<?php 
										echo $formulario->montarFormulario($cadastro[campos][$j],$campos[0][$cadastro[campos][$j]],$tabela,$cadastro[tipo][$j],$cadastro[complemento][$j]);
									?>
								</td>
							</tr>
					<?php
						$j++;
						}
					?>
					<tr>
						<td align="left" style="padding-top:10px">
							<a href="javascript:history.go(-1);">
								<img src="imagens/voltar.png" alt="Voltar" title="Voltar" border="0"/>
							</a>
						</td>
						<td align="left" style="padding-top:10px">
							<input type='image' src='imagens/proximoPasso.png'>
						</td>
					</tr>
				</table>
				<br/>
				<?php echo $formulario->fecharCabecalhoForm();?>		
			<br><br>		
		</td>	
	</tr>
</table>