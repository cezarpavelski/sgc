package
{
	import flash.display.*;
	import flash.events.*;
	import flash.external.*;
	import flash.net.*;
	import flash.utils.*;

	public class Uploader extends Sprite
	{
		private var listeners:Object; // Irá guardar os eventos adicionados pelo Javascript
		private var arquivos:Object; // Arquivos da fila
		private var idsArqs:Dictionary; // ids dos arquivos da fila
		private var idAtual:int = 0; // id do arquivo que está sendo enviado no momento
		private var multiSelect:Boolean; // Guarda se é multi seleção de arquivos ou não
		private var fileRef:FileReference; // Caso seja seleção de um único arquivo
		private var fileRefList:FileReferenceList; // Lista de arquivos (em caso de seleção múltipla)
		private var tipos:Array; // Tipos de arquivos permitidos na caixa de seleção
		private var url:String; // URL do script de upload
		private var vars:URLVariables; // Variáveis para enviar junto do upload ao script
		private var enviando:Boolean; // Para verificar se estamos enviando um arquivo ou não

		// Eventos a serem "ouvidos" por Javascript
		static public const UPLOAD_START:String         = "onOpen";				// Ao iniciar o upload do arquivo
		static public const FILES_SELECT:String         = "onSelected";			// Ao selecionar um ou mais arquivos
		static public const IO_ERROR:String             = "onIoError";			// Ao ocorrer um erro de entrada/saída
		static public const UPLOAD_PROGRESS:String      = "onProgress";			// Sempre que houver uma mudança no progresso
		static public const SELECTION_CANCEL:String     = "onCancel";			// Ao cancelar
		static public const SECURITY_ERROR:String       = "onSecurityError";	// Erro de segurança
		static public const HTTP_ERROR:String           = "onHttpError";		// Erro de HTTP
		static public const UPLOAD_COMPLETE:String      = "onComplete";			// Ao completar o upload
		static public const UPLOAD_COMPLETE_DATA:String = "onCompleteData";		// Ao completar e receber dado(s) do script de upload (recomendado)
		static public const MOUSE_CLICK:String          = "onMouseClick";		// Ao clicar no swf

		// Construtor da classe
		public function Uploader()
		{
			stage.scaleMode = StageScaleMode.NO_SCALE;
			stage.showDefaultContextMenu = false;

			listeners   = {};
			arquivos    = {};
			idsArqs     = new Dictionary();
			tipos       = [];
			multiSelect = true; // Multi seleção de arquivos por padrão

			fileRefList = new FileReferenceList();
			fileRefList.addEventListener(Event.SELECT, eventoJS);
			fileRefList.addEventListener(Event.CANCEL, eventoJS);

			stage.addEventListener(MouseEvent.CLICK, clique);

			// Registra todos os callbacks e prepara JS
			registraCallbacks();
		}

		private function clique(e:MouseEvent):void
		{
			if (!enviando)
			{
				// Dispara o evento para o Javascript
				eventoJS(e);
				// Abre seleção de arquivos
				selecionar(multiSelect, tipos);
			}
		}

		private function selecionar(multiplos:Boolean = true, tiposPermitidos:Array = null):Boolean
		{
			var i:int = 0;
			var tipo:Object;
			var filtros:Array = [];

			if (tiposPermitidos)
			{
				// Monta filtros de arquivos permitidos
				while (i < tiposPermitidos.length)
				{
					tipo = tiposPermitidos[i];
					filtros[i] = new FileFilter(tipo.desc, tipo.ext);
					i++;
				}
			}

			if (multiplos) // Seleção múltipla de arquivos
				return filtros.length ? fileRefList.browse(filtros) : fileRefList.browse();
			else
			{
				// Seleção de um arquivo
				fileRef = new FileReference();
				fileRef.addEventListener(Event.SELECT, eventoJS);
				fileRef.addEventListener(Event.CANCEL, eventoJS);

				return filtros.length ? fileRef.browse(filtros) : fileRef.browse();
			}
		}

		// Registra todas as funções que podem ser executadas pelo Javascript
		private function registraCallbacks():void
		{
			ExternalInterface.addCallback("addListener",         registraEvento);
			ExternalInterface.addCallback("cancelaUpload",       cancelaUpload);
			ExternalInterface.addCallback("retornaArquivo",      retornaArquivo);
            ExternalInterface.addCallback("removeArquivo",       removeArquivo);
			ExternalInterface.addCallback("iniciaUpload",        iniciaUpload);
			ExternalInterface.addCallback("url",                 setaURL);
			ExternalInterface.addCallback("setaVariaveis",       setaVariaveis);
			ExternalInterface.addCallback("setaMultiSelect",     setaMultiSelect);
			ExternalInterface.addCallback("multiSelect",         retornaMultiSelect);
			ExternalInterface.addCallback("setaTiposPermitidos", setaTiposPermitidos);
			ExternalInterface.addCallback("tiposPermitidos",     retornaTiposPermitidos);

			// Executa a função Javascript "uploaderPronto" para "ouvir" os eventos de upload
			if (ExternalInterface.available)
				ExternalInterface.call("uploaderPronto");
		}

		// Função para registrar eventos pelo Javascript
		public function registraEvento(evento:String, funcaoJS:String):void
		{
			listeners[evento] = funcaoJS;
		}

		public function iniciaUpload(id:String):Boolean
		{
			// Verifica se o arquivo está na "fila"
			if (idValido(id))
			{
				enviando = true;

				// Seta a URL do script de upload
				var urlReq:URLRequest = new URLRequest(url);

				// Método POST, e adiciona as variáveis, setadas com a função "setaVariaveis"
				urlReq.method = URLRequestMethod.POST;
				urlReq.data   = vars;

				// Faz upload do arquivo
				retornaFileRef(id).upload(urlReq);
				return true;
			}
			return false;
		}

		// Verifica se o arquivo está na "fila"
		public function idValido(id:String):Boolean
		{
			return id in arquivos;
		}

		// Registra todos os arquivos selecionados
		private function registraArquivos(arqs:Object):Array
		{
			var ret:Array;
			var i:int = 0;

			if (arqs is FileReference) // Entra aqui caso seja seleção de um único arquivo (usando "setaMultiselect(false)")
				ret.push(arqs);
			else if (arqs is FileReferenceList) // Caso seja seleção de arquivos múltiplos (padrão)
				ret = arqs.fileList;

			// Faz o loop no array e executa a função de adicionar arquivo
			while (i < ret.length)
			{
				adicionaArquivo(ret[i]);
				i++;
			}

			// Retorna a array para ser enviada ao Javascript
			return ret;
		}

		// Adiciona a referência do arquivo
		private function adicionaArquivo(arq:FileReference):String
		{
			var id:String;

			// id é igual a idAtual + 1
			id = String(++idAtual);

			arquivos[id] = arq; // arquivo
			idsArqs[arq] = id; // id do arquivo

			// Adiciona os eventos que serão enviados para o Javascript
			arq.addEventListener(Event.OPEN, eventoJS);
			arq.addEventListener(Event.COMPLETE, eventoJS);
			arq.addEventListener(DataEvent.UPLOAD_COMPLETE_DATA, eventoJS);
			arq.addEventListener(ProgressEvent.PROGRESS, eventoJS);
			arq.addEventListener(HTTPStatusEvent.HTTP_STATUS, eventoJS);
			arq.addEventListener(IOErrorEvent.IO_ERROR, eventoJS);
			arq.addEventListener(SecurityErrorEvent.SECURITY_ERROR, eventoJS);

			return id;
		}

		// Remove o arquivo da fila
		public function removeArquivo(id:String):void
		{
			if (idValido(id))
            {
                cancelaUpload(id); // Cancela o upload do arquivo
                delete arquivos[id]; // Remove da fila
            }
        }

		public function cancelaUpload(id:String):void
		{
			if (idValido(id))
				retornaFileRef(id).cancel();
        }

		// Retorna o id da referência arquivo
		private function idArquivo(arq:FileReference):String
		{
			if (arq in idsArqs)
				return idsArqs[arq];
			return null;
		}

		// Retorna array de objetos com informações dos arquivos
		public function retornaArquivos(arqs:Array):Array
		{
			var ret:Array = [];
			var i:int = 0;

			while (i < arqs.length)
			{
				// Coloca o objeto com as informações do arquivo na array "ret"
				ret.push(retornaArquivoObjeto(arqs[i]));
				i++;
			}

			return ret;
        }

		// Retorna um objeto com as informações do arquivo
		private function retornaArquivoObjeto(arq:FileReference):Object
		{
			return {
				id: idArquivo(arq),
				nome: arq.name,
				criado: arq.creationDate.getTime(),
				modificado: arq.modificationDate.getTime(),
				tamanho: arq.size,
				tipo: arq.type
			};
		}

		// Retorna objeto com informações de um arquivo pelo seu id
		public function retornaArquivo(id:String):Object
		{
			if (!idValido(id))
				return null;

			return retornaArquivoObjeto(retornaFileRef(id));
        }

		// Retorna a referência do arquivo pelo id
		private function retornaFileRef(id:String):FileReference
		{
			if (idValido(id))
				return arquivos[id];
			return null;
		}

		// Seta a URL para o script de upload
		public function setaURL(valor:String):void
		{
			url = valor;
		}

		// Seta variáveis a serem enviadas junto com o script de upload
		public function setaVariaveis(variaveis:String):void
		{
			vars = new URLVariables(variaveis);
		}

		// Para setar se é multi seleção de arquivos ou não
		public function setaMultiSelect(valor:Boolean):void
		{
			multiSelect = valor;
		}

		public function retornaMultiSelect():Boolean
		{
			return multiSelect;
		}

		// Seta tipos permitidos na seleção
		public function setaTiposPermitidos(permitidos:Array):void
		{
			tipos = permitidos;
		}

		public function retornaTiposPermitidos():Array
		{
			return tipos;
		}

		// Esta função verifica o evento disparado e executa a função no Javascript
		// 		que está setada para ele (caso exista)
		// Nota: Esta função é usada para ouvir todos os eventos desta classe, com exceção
		// 		do "click" para seleção dos arquivos
		private function eventoJS(e:Object):void
		{
			// Objeto que irá ser enviado para o Javascript
			var ret:Object;
			// id do arquivo
			var id:String;

			ret = {};
			// Se o alvo do evento é uma referência de arquivo então retorna o id
			id = e.target is FileReference ? idArquivo(e.target) : null;

			if (id)
				ret.id = id;

			switch (e.type)
			{
				case Event.SELECT: // Quando o usuário seleciona os arquivos
				{
					var arqs:Array;
					ret.tipo     = FILES_SELECT; // Seta o tipo do evento
					arqs         = registraArquivos(e.target); // Registra os arquivos e retorna a array
					ret.arquivos = retornaArquivos(arqs); // Seta a array de arquivos no retorno
					break; // Cai fora do switch
				}
				case Event.CANCEL: // Ao clicar em "cancelar" na seleção de arquivos
				{
					ret.tipo = SELECTION_CANCEL; // Seta o tipo do evento
					break; // Cai fora do switch
				}
				case Event.OPEN: // Ao iniciar o upload do arquivo atual
				{
					ret.tipo = UPLOAD_START; // Seta o tipo do evento
					break; // Cai fora do switch
				}
				case Event.COMPLETE: // Ao completar o upload do arquivo
				{
					ret.tipo = UPLOAD_COMPLETE; // Seta o tipo do evento
					break; // Cai fora do switch
				}
				case DataEvent.UPLOAD_COMPLETE_DATA: // Ao completar o upload do arquivo e receber dados do script de upload
				{
					enviando  = false; // Terminou de enviar o arquivo atual
					ret.tipo  = UPLOAD_COMPLETE_DATA; // Seta o tipo do evento
					ret.dados = e.data.replace(/\\/g, "\\\\"); // Seta o retorno do script de upload
					break; // Cai fora do switch
				}
				case ProgressEvent.PROGRESS:
				{
					ret.tipo        = UPLOAD_PROGRESS; // Seta o tipo do evento
					ret.bytesLoaded = e.bytesLoaded; // Seta os bytes enviados
					ret.bytesTotal  = e.bytesTotal; // Seta o total de bytes do arquivo
					break; // Cai fora do switch
				}
				case HTTPStatusEvent.HTTP_STATUS:
				{
					ret.tipo = HTTP_ERROR; // Seta o tipo do evento
					ret.code = e.status; // Seta o código de status HTTP
					break; // Cai fora do switch
				}
				case IOErrorEvent.IO_ERROR:
				{
					ret.tipo = IO_ERROR; // Seta o tipo do evento
					ret.erro = e.text; // Seta o texto do erro
					break; // Cai fora do switch
				}
				case SecurityErrorEvent.SECURITY_ERROR:
				{
					ret.tipo = SECURITY_ERROR; // Seta o tipo do evento
					ret.erro = e.text; // Seta o texto do erro
					break; // Cai fora do switch
				}
				case MouseEvent.CLICK:
				{
					ret.tipo = MOUSE_CLICK; // Seta o tipo do evento
					break; // Cai fora do switch
				}
				default: // Nenhum dos eventos a cima
				{
					return;
					break; // Cai fora do switch
				}
			}

			// Verifica se o evento foi adicionado no Javascript
			// Se foi adicionado, então executa a função e envia o objeto com informações do evento
			if (ret.tipo in listeners)
				ExternalInterface.call(listeners[ret.tipo], ret);
		}
	}
}