/**
 * Upload múltiplo de arquivos com barra de progresso
 *
 * Autor: Fredi Machado
 * Link: http://fredimachado.com.br
 */

var uploader = null; // Objeto do SWF
var arquivos = {}; // Objeto com as informações dos arquivos (id, nome, tamanho, etc...)
var fila = []; // Array com os ids dos arquivos na fila
var atual    = 0; // Arquivo enviado no momento
var enviando = false; // Para evitar envio "duplo"

/**
 * Função que o Flash vai executar por padrão quando estiver tudo carregado
 * Assim podemos adicionar os listeners para nos retornar as informações
 */
function uploaderPronto()
{
	// Objeto do SWF no html
	uploader = document.getElementById('uploader');

	// Adiciona as funções
	// O primeiro argumento é o evento no Flash, o segundo argumento é a função
	// que o Flash irá executar aqui no Javascript quando o evento for disparado
	uploader.addListener('onSelected', 'onSelect');
	uploader.addListener('onProgress', 'onProgress');
	uploader.addListener('onComplete', 'onComplete');
	uploader.addListener('onCompleteData', 'onCompleteData');

	// Seta a url do script de upload
	uploader.url(url);

	// Seta os tipos de arquivos permitidos na caixa de seleção
	// Neste caso queremos somente imagens
	uploader.setaTiposPermitidos([
		{desc: "Imagens JPG, GIF ou PNG", ext: "*.jpg;*.jpeg;*.gif;*.png"}
	]);
}

// Escuta o evento "onSelected" do Flash
function onSelect(e)
{
	// Retorna uma array de objetos com informações do(s) arquivo(s) selecionado(s)
	var arqs = e.arquivos;

	// Faz um loop para adicionar os arquivos e criar as divs e barra de progresso
	for (var i = 0; i < arqs.length; i++)
		adicionaArquivo(arqs[i]);

	// Como setei no css a div #arquivos como "display:none"
	// agora quero que ela seja exibida
	$("#arquivos").show();

	// Executa a função para calcular totais (arquivos selecionados e tamanho total do upload)
	calculaTotais();

	// Seta o evento "click" do botão Enviar
	$("#btUpload").click(function() {
		enviarArquivos();
	});
}

// Adiciona o objeto com as informações do arquivo
function adicionaArquivo(arq)
{
	// Seta o objeto
	arquivos[arq.id] = arq;

	// Adiciona o html necessário para exibição das informações do arquivo e barra de progresso
	$('<div class="arquivo" id="arquivo_'+arq.id+'"><div class="c30p">'+arq.nome+'</div><div class="c100 ac">'+tamanho(arq.tamanho)+'</div><div class="c100 ac"><a href="javascript:void(0);" class="remover" rel="'+arq.id+'">X</a></div><div class="c30p progresso">&nbsp;</div><div class="sep" /></div>').appendTo("#lista_arquivos")
		.find(".progresso").append($('<span id="upload_'+arq.id+'" />').progressBar({ barImage: 'images/progressbg_green.gif' }));

	// Adiciona o evento "remover" ao clicar no link "X"
	$("#arquivo_"+arq.id+" .remover").click(function() {
		// Só continua caso o upload não esteja ativo
		if (!enviando)
		{
			// Pega o id, a partir do attributo "rel" do link
			var id = $(this).attr("rel");
			// Da um fadeOut e remove a div com as informações do arquivo
			$("#arquivo_"+id).fadeOut('fast', function() { $(this).remove(); });
			// Executa a função "removeArquivo" do Flash
			uploader.removeArquivo(id);
			// Remove as informações do arquivo do objeto
			delete arquivos[String(id)];
			// Re-calcula os totais
			calculaTotais();
		}
	});
}

// Função que é executada ao clicar no botão "Enviar"
function enviarArquivos()
{
	// Só continua caso o upload não esteja ativo
	if (!enviando)
	{
		// Começamos do primeiro arquivo da fila
		atual    = 0;
		// Agora estamos enviando
		enviando = true;

		// Monta a array fila com os ids dos arquivos
		for (var a in arquivos)
			fila.push(arquivos[a].id);

		// Executa a função "iniciaUpload" do flash já enviando o id do primeiro arquivo na fila
		uploader.iniciaUpload(fila[atual]);
	}
}

// Escuta o evento "onProgress" do Flash
function onProgress(e)
{
	// Calcula a porcentagem de acordo com as informações recebidas
	var valor = Math.ceil(Number(e.bytesLoaded / e.bytesTotal * 100));
	// Atualiza a barra de progresso
	$("#upload_"+e.id).progressBar(valor);
}

// Escuta o evento "onComplete" do Flash
function onComplete(e)
{
	// Vamos para o próximo arquivo
	atual++;

	// Se ainda não chegou ao final da fila, envia próximo arquivo
	if (atual < fila.length)
		uploader.iniciaUpload(fila[atual]);
	// Chegou ao final da fila, então aguarda 2 segundos e recarrega a página
	else
		window.setTimeout(function() {
			window.location.reload(true);
		}, 2000);
}

// Escuta o evento "onCompleteData" do Flash
function onCompleteData(e)
{
	// Caso o script retorne "1" é porque tudo ocorreu bem
	if (e.dados == "1")
		$("#upload_"+e.id).html("Enviado.");
	// Caso contrário é porque ocorreu algum erro
	else
		$("#upload_"+e.id).html("Erro ao enviar.");

}

// Calcula os totais (número de arquivos na fila e tamanho total dos arquivos)
function calculaTotais()
{
	var c = 0; // Quantidade de arquivos
	var t = 0; // Tamanho

	for (var i in arquivos)
	{
		c++;
		t += arquivos[i].tamanho; // Vai somando os tamanhos
	}

	// Temos pelo menos 1 arquivo na fila
	if (c)
	{
		$("#total_arquivos").text(c); // Número de arquivos
		$("#total_tamanho").text(tamanho(t)); // Tamanho total, já convertido para MB ou KB usando a função "tamanho"
		$("#totais_arquivos").show(); // Exibe a div
	}
	// Não temos arquivos
	else
	{
		// Esconde as divs
		$("#totais_arquivos").hide();
		$("#arquivos").hide();
	}
}

// Retorna o tamanho em MB ou KB
function tamanho(val)
{
	var kb = Number(Number(val)/1024).toFixed(1);
	return kb >= 1000 ? Number(kb/1024).toFixed(1) + " MB" : kb + " KB";
}
