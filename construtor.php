<?php 
	include_once("model/DAO.class.php");
	include_once("extra/Paginacao.class.php");
	include_once("extra/GoogleMaps.class.php");
	include_once("extra/Video.class.php");
	include_once("extra/ListagemDeDados.php");
	include_once("extra/CriarFormulario.class.php");
	include_once("extra/Upload.class.php");
	include_once("extra/Thumbnail.class.php");
	
	$dao=new DAO();
	$thumbnail=new Thumbnail();
	$acao=$_GET[acao];
	$id=$_REQUEST[id];
	$formulario=new CriarFormulario();
	$order='id';
?>

<table cellpadding="0" cellspacing="0" style="width:100%; text-align: left;" align="center" border="0">
	<tr>
		<td style="padding:10px 10px 20px 0; color:#7f8a94; text-align: left; font-size:26px; font-family:'Century Gothic', Verdana">
			<span style="width:2px; height:40px; padding:5px; background:url('imagens/bg.jpg') repeat-x; text-align: left; display:inline">&nbsp;</span>
			<span style="height:40px; background:#f8f8f8; text-align: left; padding:5px;display:inline">
				<?php echo strtoupper($tituloDaPagina);?>
			</span>
			<br/>
		</td>
	</tr>
	
	<?php 
		/*================================================================================*/
		/*========================= LISTAGEM DOS REGISTROS ===============================*/
		/*================================================================================*/
		if(!$acao){
			if($_GET[campoOrder]){
				$order=$_GET[campoOrder];
			}
			$tipoOrder=explode("_",$order);
			if($tipoOrder[1]=="desc"){
				$order=$tipoOrder[0]." asc";
				$ordem='asc';
				$flecha="flechaCima.png";
			}else{
				$order=$tipoOrder[0]." desc";
				$ordem='desc';
				$flecha="flechaBaixo.png";
			}
			if($_REQUEST[busca]){
				$where="where ".$_REQUEST[campoBusca]." like '%".$_REQUEST[busca]."%'";
				$urlBusca="&campoBusca=".$_REQUEST[campoBusca]."&busca=".$_REQUEST[busca];
			}
			$campos=$dao->selectAll($tabela." ".$where." order by ".$order);
	?>
		<tr>
			<td style="widht:100%; text-align: center" valign="top">
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td colspan="<?php echo count($listagem[labels])+1;?>" align="center" style="padding:0 15px 15px 15px" valign="bottom">
							<?php 
								$formularioPesquisa= new CriarFormulario();
								echo $formularioPesquisa->criarCabecalhoForm("index.php?pg=".$pg."&tabela=".$tabela,"formPesquisa","post");
							?>
							<div style="width:835px;vertical-align: top;">
							<b>PESQUISAR: </b>
							<?php 
								$j=0;
								foreach($listagem[labels] as $c){
									$arrayCategorias[$listagem[campos][$j]]=strtoupper($c);
									$j++;
								}
								echo $formularioPesquisa->criarTag(null,"busca","",array(type=>"text", "class"=>"caixa", onfocus=>"this.style.backgroundColor=\"#f9f2cb\"", onblur=>"this.style.backgroundColor=\"#FFFFFF\""))."&nbsp;&nbsp;";
								echo $formularioPesquisa->criarTag(null,"campoBusca","",array(type=>"select", "class"=>"caixa", style=>"width:200px", option=>$arrayCategorias))."&nbsp;&nbsp;";
								echo '<input type="image" src="imagens/lupa.png" alt="Pesquisar" title="Pesquisar" style="position:absolute" width="30" height="30"/>';
							?>
							</div>
							</form>
						</td>
					</tr>
					<tr>
					<?php 
						$j=0;
						foreach($listagem[labels] as $ll){
							echo "<td class='barraTitulo'><b><a href='index.php?pg=$pg&campoOrder=".$listagem[campos][$j++]."_".$ordem."'>".strtoupper($ll)."</a>";
							if($listagem[campos][$j-1]==$tipoOrder[0]){
								echo "&nbsp;<img src='imagens/$flecha'/>";
							} 
							echo "</b></td>";
						}
					?>
						<td class="barraTitulo" style="width:100px"><b>FUNÇÕES</b></td>
					</tr>
					<?php 
				        $limite=$_GET[limite];
						if (count($campos)!=0){
						for ($i=$limite+0;$i<($maxPaginas+$limite);$i++){
							if(!$campos[$i][id]){
								break;	
							}
							if($flag==1){
								$bgcolor="#f0f0f0";
								$flag=0;
							}else{
								$bgcolor="#ffffff";
								$flag=1;
							}
					?>
					<tr style="background-color:<?php echo $bgcolor;?>;" onmouseover="this.style.backgroundColor='#CCCCCC';" onmouseout="this.style.backgroundColor='<?php echo $bgcolor;?>';">
						<?php
							$j=0;
							foreach($listagem[campos] as $lc){
						?>
							<td style="text-align:center; border-right:1px solid #e4e4e4; padding:8px;">
								<?php
									$campo=$campos[$i][$lc];
									$tipo=$listagem[tipo][$j];
									$complemento=$listagem[complemento][$j];
									
									echo ListagemDeDados($campo,$tipo,$complemento);
								?>
							</td>
						<?php $j++;}?>
							<td align="center">
								<?php if($botaoVisualizar==1){?>
								<a href="index.php?pg=<?php echo $pg;?>&id=<?php echo $campos[$i][id]?>&acao=visualizar">
									<img alt="Visualizar Registro" title="Visualizar Registro" src="imagens/view.png" border="0"/>
								</a>
								<?php }?>
								<?php if($botaoEditar==1){?>
								<a href="index.php?pg=<?php echo $pg;?>&id=<?php echo $campos[$i][id]?>&acao=editar">
									<img alt="Editar Registro" title="Editar Registro" src="imagens/edit.png" border="0"/>
								</a>
								<?php }?>
								<?php if($botaoExcluir==1 && $_SESSION[tipoAdm]=='Administrador'){?>
								<a href="deletarRegistro.php?id=<?php echo $campos[$i][id]?>&tabela=<?php echo $tabela?>" class="confirm">
									<img alt="Deletar Registro" title="Deletar Registro" src="imagens/del.png" border="0"/>
								</a>
								<?php }?>
								<?php if($botaoGaleria==1){?>
									<a href="index.php?pg=galeria&id=<?php echo $campos[$i][id]?>&tabela=<?php echo $tabela?>">
										<img alt="Galeria de Imagens" title="Galeria de Imagens" src="imagens/galeria.png" border="0"/>
									</a>
								<?php }?>
							</td>
					</tr>
					<?php }?>
				  	<tr>
						<td colspan="<?php echo count($listagem[labels])+1;?>" align="center" style="padding-top:10px;" valign="bottom">
						<?php 
							$paginacao=new Paginacao($campos,"index.php?pg=".$pg."&campoOrder=".$tipoOrder[0]."_".$tipoOrder[1].$urlBusca,$maxPaginas,$limite);
							if($paginacao!="false"){
								echo $paginacao;
							}
						?>
						</td>
				  	</tr>
					  <?php
						}else{
							echo "<tr><td colspan='".(count($listagem[labels])+1)."'><br>Nenhum Registro Encontrado!</td></tr>";
						}
					  ?>  
				</table>
				<br/>
				<a href="index.php?pg=<?php echo $pg;?>&acao=incluir">
					<?php if($botaoAdicionar==1){?>
						<img src="imagens/new.png" border="0">
					<?php }?>
				</a>
			</td>
		</tr>
	<?php 
		/*================================================================================*/
		/*====================== FORMULARIO DE CADASTRO E EDIÇÃO==========================*/
		/*================================================================================*/
		}else if($acao=="incluir" || $acao=="editar"){
			if($acao=="editar"){
				$campos=$dao->selectUnique("id",$id,$tabela);
			}else{
				$campos=$dao->selectFree("SHOW TABLE STATUS LIKE '$tabela'");
				if($_POST[incluir]){
					if($galeria==1){
						@mkdir($diretorio."/".$tabela.$campos[0]['Auto_increment'],0777);
						@chmod($diretorio."/".$tabela.$campos[0]['Auto_increment'],0777);
					}
					$camposPost="";
					$j=0;
					foreach ($cadastro[campos] as $cc) {
						$value=$_POST[$cc];
						if($cadastro[tipo][$j]=="arquivo" || $cadastro[tipo][$j]=="imagem"){
							if($_FILES[$cc][name]){
								$arquivo=new Upload($_FILES[$cc],$diretorio);
								$value=$arquivo->getNovoNome();
								if($_POST["hidden_".$cc]){
									@unlink($diretorio."/".$_POST["hidden_".$cc]);
									@unlink($diretorio."/thumb_".$_POST["hidden_".$cc]);
								}
								if($cadastro[tipo][$j]=="imagem"){
									$thumbnail->setMaxThumbSize($thumbWidth,$thumbHeight);
									$thumbnail->createThumb($diretorio."/".$value);
									if($marcaDagua==1){
										$thumbnail->setLogoFile($logoMarcaDagua);
										$thumbnail->insertLogo($diretorio."/".$value);
									}
								}
							}else if($_POST["hidden_".$cc]){
								$value=$_POST["hidden_".$cc];
							}
						}else{
							if($cadastro[tipo][$j]=="moeda"){
								$value=str_replace(".","",$value);
								$value=str_replace(",",".",$value);
							}else if($cadastro[tipo][$j]=="checkBox"){
								$complementoTabela=explode("|",$cadastro[complemento][$j]);
								if($complementoTabela[0]=="permissao"){
									$contItens[0][quant]=count($_SESSION['menu']);
								}else{
									$contItens=$dao->selectFree("select count(id) as quant from $complementoTabela[0]");
								}
								for($i=1;$i<=$contItens[0][quant];$i++){
									if(is_numeric($_POST["check_".$complementoTabela[0].$i])){
										$value.=$_POST["check_".$complementoTabela[0].$i].",";
									}
								}
								$value=substr($value,0,-1);
							}else if($cadastro[tipo][$j]=="radio"){
								$complementoTabela=explode("|",$cadastro[complemento][$j]);
								$value=$_POST["radio_".$complementoTabela[0]];
							}else if($cadastro[tipo][$j]=="data" || $cadastro[tipo][$j]=="calendario"){
								$value=explode("/",$value);
								$value=$value[2]."-".$value[1]."-".$value[0];
							}
						}
						
						$camposPost.="'".$value."',";	
						$j++;
					}
					$camposPost=substr($camposPost,0,-1);
					$replace=$dao->selectFree("REPLACE INTO $tabela VALUES ($camposPost)");
					if($pg=="contasEmail"){
						//Cria email no cpanel
						include("extra/cPanel.php");
						if(!$_POST[quota]){
							$_POST[quota]=50;
						}
						$cpanel=new emailAccount($hostCpanel,$userCpanel,$passCpanel,"2082",false,"x3",$_POST[email]);
						if($id){
							$cpanel->setPassword($_POST[senha]);
							$cpanel->setQuota($_POST[quota]);
						}else{
							$cpanel->create($_POST[senha],$_POST[quota]);
						}
					}
					$resposta=1;
				}else{
					$autoIncrement = $campos[0]['Auto_increment'];
				}
			}
	?>
		<tr>
			<td style="widht:100%; text-align: left" valign="top">
				<?php 
					if(!$id && $resposta==1){
						echo "<script type='text/javascript'>
									$().ready(function() {
									  $('#alert').jqm({overlay: 50, modal: true, overlayClass: 'whiteOverlay', trigger: false}); 
									  alert('Cadastro Realizado com Sucesso');
									  $('#jqmClose').click(function() { 
									    location.href='index.php?pg=".$pg."&acao=incluir';
									  });
									});
							  </script>";
					}else if($id && $resposta==1){
						echo "<script type='text/javascript'>
									$().ready(function() {
									  $('#alert').jqm({overlay: 50, modal: true, overlayClass: 'whiteOverlay', trigger: false});
									  alert('Cadastro Alterado com Sucesso'); 
									  $('#jqmClose').click(function() { 
									    location.href='index.php?pg=".$pg."&id=".$id."&acao=editar';
									  });
									});
							  </script>";
					}
				?>
				<?php echo $formulario->criarCabecalhoForm("index.php?pg=".$pg."&tabela=".$tabela."&acao=incluir","form","post", array(enctype=>"multipart/form-data"));?>
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
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
										if($cadastro[campos][$j]=="id"){
											if(!$id){
												echo "<b>".$autoIncrement."</b>";
											}else{
												echo "<b>".$id."</b>";
											}
										}else{
									?>
									<?php 
											$name=$cadastro[campos][$j];
											$value=$campos[0][$cadastro[campos][$j]];
											$tipo=$cadastro[tipo][$j];
											$complemento=$cadastro[complemento][$j];
											
											echo $formulario->montarFormulario($name,$value,$tabela,$tipo,$complemento);
										}	
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
							<input type='image' src='imagens/enviar.png'>
						</td>
					</tr>
				</table>
				<br/>
				<input type='hidden' name='registrar' value='1'>
				<input type='hidden' name='id' value='<?php echo $id;?>'>
				<?php echo $formulario->fecharCabecalhoForm();?>
			</td>
		</tr>
	<?php 
		/*================================================================================*/
		/*====================== VISUALIZAÇÃO DOS REGISTROS ==============================*/
		/*================================================================================*/
		}else if($acao=="visualizar"){	
		$campos=$dao->selectUnique("id",$id,$tabela);
	?>
		<tr>
			<td style="widht:100%; text-align: left" valign="top">
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
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
							<tr style="background-color:<?php echo $bgcolor;?>" onmouseover="this.style.backgroundColor='#CCCCCC';" onmouseout="this.style.backgroundColor='<?php echo $bgcolor;?>';">
								<td style="text-align:left;padding:8px; width:20%"><b><?php echo strtoupper($cl);?></b></td>
								<td style="padding:5px; text-align:left">
									<?php 
										$campo=$campos[0][$cadastro[campos][$j]];
										$tipo=$cadastro[tipo][$j];
										$complemento=$cadastro[complemento][$j];
										
										echo ListagemDeDados($campo,$tipo,$complemento);
									?>
								</td>
							</tr>
					<?php
						$j++;
						}
					?>
					<tr>
						<td align="left" style="padding-top:10px" colspan="2">
							<a href="javascript:history.go(-1);">
								<img src="imagens/voltar.png" alt="Voltar" title="Voltar" border="0"/>
							</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>	
<?php }?>
</table>
<?php
	$_SESSION[paginaAtual]="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>