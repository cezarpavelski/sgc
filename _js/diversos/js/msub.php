<script type="text/javascript">
<!--//--><![CDATA[//><!--
function mostrarSub(toLoad,pagina){
	if (pagina=="fundo"){
	document.getElementById('logar1').style.display='block';	
	}
	var div = document.getElementById(pagina);
    div.innerHTML = "<font size=2>Carregando...</font>";
    var ajax = new Ajax();
    ajax.set_receive_handler(
       function(c) {
          div.innerHTML = c;
       }
    );
    ajax.send(toLoad);
}
//--><!]]>
</script>
