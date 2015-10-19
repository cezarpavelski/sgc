<script type="text/javascript">
<!--//--><![CDATA[//><!--
function mostrarConteudo(toLoad,imagem){
    var div = document.getElementById(imagem);
    div.innerHTML = "<div align='center' style='width:100%;'><img src='images/loader.gif'></div>";
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
