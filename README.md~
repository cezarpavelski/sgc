# SGC
Sistema de gerenciamento de conteúdo utilizando para administração de sites criado em 2010

## INSTALACAO

Criar uma banco de dados qualquer e criar a tabela admin que esta no arquivo LEIA ME/tabelaAdmin(unica obrigatoria).txt, esta é a 
única tabela obrigatória para o SGC.
Alterar o arquivo model/Conexao.class.php com os dados do seu banco de dados

## NOMENCLATURA DAS PAGINAS    

### MODO DE UTILIZAR

Copie o bloco de codigo abaixo e salve suas paginas dentro da pasta **paginas**

```php
    //TITULO DA PAGINA
	$tituloDaPagina = "telas do software";
	
	//TABELA NO BANCO DE DADOS
	$tabela = "telas_software";
	
    //GALERIA DE IMAGENS
	$galeria = 1; /*1 para ativo ou 0 para inativo*/ 

    //INFORMACOES PARA EDICAO E VISUALIZACAO DOS REGISTROS ******************************************
		
	$cadastro = array(
			   labels=>array("ID","Nome","Descricao","Imagem(800X469)"),
                           campos=>array("id","nome","descricao",'imagem'),
			   tipo=>array("titulo","selecao","selecaoMultipla","selecaoMultipla"),
			   complemento=>array("","estado|nome","nome|id_estado|cidade|nome","descricao|id_cidade|bairro|nome")
			 ); 
	
    //INFORMACOES PARA LISTAGEM DOS REGISTROS *******************************************************

	$listagem = array(
                           labels=>array("ID","Nome","Descricao","Imagem(800X469)"),
			   campos=>array("id","nome","descricao",'imagem'),
			   tipo=>array("titulo","titulo","texto","selecao"),
			   complemento=>array("","","300","cidade|nome")
			 ); 

```


## LEGENDA DE TIPOS PARA CADASTRO E LISTAGEM DE REGISTROS

### TIPOS PARA CADASTRO

	calendario => Coloca calendário na frente do input e formata a data no formato dd/mm/aaaa
	data => cria um input text e formata a data no formato dd/mm/aaaa e valida a data
	telefone => cria um input text e formata o telefone no formato (44) 9999-9999
	cpf => cria um input text e formata o cpf no formato 044.156.999-65 e valida o cpf
	cnpj => cria um input text e formata o cnpj no formato 01.679.152/0001-25 e valida o cnpj
	hora => cria um input text e formata a hora no formato hh:mm:ss
	moeda => cria um input text e formata a moeda no formato 1.234,34
	cep => cria um input text e formata o cep no formato 88999-000
	campoObrigatorio => cria um input text e deixa o campo obrigatorio
	email => cria um input text e valida o email Ex.: email valido cezarpavelski@yahoo.com.br
	url => cria um input text e valida a url Ex.: url valida http://www.pavelski.net
	titulo => cria um input text sem validacao
	texto => cria um textarea	
	imagem => cria um input file com validacao para somente arquivos jpg, jpeg, gif, png
	youtube => cria um input text para url do youtube e mostra o video se tiver

	arquivo => cria um input file sem validacao de arquivos
		|=>COMPLEMENTO => utilizado para validar os arquivos permitidos Ex.: doc|pdf|txt	
	
	selecao => cria um select de campos vindos de outra tabela
		|=>COMPLEMENTO => uso obrigatorio para o tipo selecao Ex.: tabela|campo	
	
	selecaoAjax => cria um select de campos vindos de outra tabela via ajax
		|=>COMPLEMENTO => uso obrigatorio para o tipo selecaoMultipa 
		Ex.: nome do campo do select|campo identificador da tabela|tabela|campo resultado da tabela => estado|id_estado|cidade|nome	

	checkBox => cria campos check box com campos vindos de outras tabelas
		|=>COMPLEMENTO => uso obrigatorio para o tipo checkBox Ex.: tabela|campo	
	
	radio => cria campos radio buttom com campos vindos de outras tabelas
		|=>COMPLEMENTO => uso obrigatorio para o tipo checkBox Ex.: tabela|campo	
				

### TIPOS PARA LISTAGEM

	data => imprime a data na tela no formato dd/mm/aaaa
	moeda => imprime o valor na tela no formato R$ 1.234,34
	titulo => imprime o texto na tela utilizado para varchar
	
	texto => imprime o texto na tela utilizado para text
		|=>COMPLEMENTO => imprime na tela a quantidade de caracteres desejado Ex.: 500, senao passado nenhum valor imprime o texto todo	
	
	arquivo => mostra o icone da extensão do arquivo ou o flash se a extensao for swf
	imagem => mostra a miniatura da imagem na tela
	
	youtube => mostra o video com tamanho padrao 450X300	
		
	selecao => imprime na tela o campo de outra tabela
		|=>COMPLEMENTO => uso obrigatorio Ex.: tabela|campo
		
	checkBox => imprime uma lista numerada de campos de outras tabelas
		|=>COMPLEMENTO => uso obrigatorio Ex.: tabela|campo
		
	radio => imprime na tela o campo de outra tabela
		|=>COMPLEMENTO => uso obrigatorio Ex.: tabela|campo
		
