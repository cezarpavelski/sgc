<?php

/**
 * Arquivo com a classe \c ImgHandler.
 * @file class.ImgHandler.php
*/

/*
 * Exemplo de uso:
 *
 * $img = 'foto.jpg'; // foto que deverá ser salva/redimensionada
 * $ImgHandler = new ImgHandler();
 * $foto = $ImgHandler->saveImg( $img );
 * $ImgHandler->createThumb( $foto );
 * $ImgHandler->insertLogo( $foto );
*/

/* Definição de constantes que poderão ser usadas na chamada ao método insertLogo() */
defined( 'IMGHANDLER_LOGO_TOP_LEFT' ) || define( 'IMGHANDLER_LOGO_TOP_LEFT', 1 );
defined( 'IMGHANDLER_LOGO_TOP_RIGHT' ) || define( 'IMGHANDLER_LOGO_TOP_RIGHT', 2 );
defined( 'IMGHANDLER_LOGO_TOP_CENTER' ) || define( 'IMGHANDLER_LOGO_TOP_CENTER', 3 );
defined( 'IMGHANDLER_LOGO_BOTTOM_LEFT' ) || define( 'IMGHANDLER_LOGO_BOTTOM_LEFT', 4 );
defined( 'IMGHANDLER_LOGO_BOTTOM_RIGHT' ) || define( 'IMGHANDLER_LOGO_BOTTOM_RIGHT', 5 );
defined( 'IMGHANDLER_LOGO_BOTTOM_CENTER' ) || define( 'IMGHANDLER_LOGO_BOTTOM_CENTER', 6 );
defined( 'IMGHANDLER_LOGO_MIDDLE_LEFT' ) || define( 'IMGHANDLER_LOGO_MIDDLE_LEFT', 7 );
defined( 'IMGHANDLER_LOGO_MIDDLE_RIGHT' ) || define( 'IMGHANDLER_LOGO_MIDDLE_RIGHT', 8 );
defined( 'IMGHANDLER_LOGO_MIDDLE_CENTER' ) || define( 'IMGHANDLER_LOGO_MIDDLE_CENTER', 9 );

/**
 * A classe \c ImgHandler é responsável por copiar imagens (de um diretório ou de um formulário, por meio de envio por método POST), redimensioná-las e inserir a logomarca (marca d'água).
 * @class ImgHandler
 * @author Roberto Beraldo Chaiben (rbchaiben [at] gmail [dot] com)
 * @version 1.1
 * @see http://www.php.net/manual/pt_BR/book.image.php
 * @see http://www.php.net/manual/pt_BR/features.file-upload.php
*/
class Thumbnail
{

	/*=============================================*/
	/*====     PROPRIEDADES DA CLASSE     =========*/
	/*=============================================*/

	/**
	 * Largura máxima das imagens, em pixels.
	 * @private max_img_width
	*/
	private $max_img_width = 800;

	/**
	 * Altura máxima das imagens, em pixels.
	 * @private max_img_height
	*/
	private $max_img_height = 600;

	/**
	 * Largura máxima das miniaturas (\em thumbnails), em pixels.
	 * @private max_thumb_width
	*/
	private $max_thumb_width = 110;

	/**
	 * Altura máxima das miniaturas (\em thumbnails), em pixels.
	 * @private max_thumb_height
	*/
	private $max_thumb_height = 110;

	/**
	 * Prefixo que diferencia uma miniatura (\em thumbnail) de sua imagem original.
	 * @private thumb_prefix
	*/
	private $thumb_prefix = 'thumb_';

	/**
	 * Sufixo que diferencia uma miniatura (\em thumbnail) de sua imagem original.
	 * @private thumb_sufix
	*/
	private $thumb_sufix = '';

	/**
	 * Qualidade final da imagem (inteiro entre 0 e 100).
	 * @note Esse valor só é usado em imagens JPEG.
	 * @private img_quality
	*/
	private $img_quality = 100;

	/**
	 * Qualidade final da miniatura (\e thumbnail) (inteiro entre 0 e 100).
	 * @note Esse valor só é usado em imagens JPEG.
	 * @private thumb_quality
	*/
	private $thumb_quality = 70;

	/**
	 * Caminho para o arquivo da logomarca (marca d'água) que deve ser inserida nas imagens.
	 * @private logo_file
	*/
	private $logo_file = 'logo.png';

	/*==============================================*/
	/*=========     MÉTODOS DA CLASSE     ==========*/
	/*==============================================*/

	/**
	 * Salva a imagem, redimensionando-a, se ultrapassar as dimensões máximas permitidas.
	 * @param filename Caminho para a imagem que deve ser salva.
	 * @return Retorna o nome da imagem salva.
	 * @note O nome final do arquivo da iamgem é gerado dinamicamente, a fim de evitar arquivos com nomes iguais e, consequentemente, sobreescrita de arquivos diferentes.
	*/
	public function saveImg( $filename )
	{
		list( $largura, $altura ) = getimagesize( $filename );

		// se as dimensões da imagem forem maiores que as permitidas, faz o redimensionamento dela.
		if ( $largura > $this->max_img_width || $altura > $this->max_img_height )
		{
			return $this->ResizeImg( $filename );
		}

		// gera um nome para a imagem.
		$novo_nome = $this->randName( $filename );
		//$novo_nome = $filename;

		copy( $filename, $novo_nome );

		return $novo_nome;
	}
	/*---------------------------------------------------*/

	/**
	 * Redimensiona uma imagem e a salva.
	 * @param filename Imagem a ser redimensionada.
	 * @return Retorna o nome da imagem salva.
	*/
	protected function ResizeImg( $filename )
	{

		list( $largura, $altura ) = getimagesize( $filename );
		$img_type = $this->getImgType( $filename );

		// define largura e altura conforma o tamanho da imagem,
		// a fim de manter a proporção entre as dimensões

		if ( $largura > $altura)
		{
			$nova_largura = $this->max_img_width;
			$nova_altura = round( ($nova_largura / $largura) * $altura );
		}
		elseif ( $altura > $largura )
		{
			$nova_altura = $this->max_img_height;
			$nova_largura = round( ($nova_altura / $altura) * $largura );
		}
		else
		{
			$nova_altura = $nova_largura = $this->max_img_width;
		}

		$src_img = call_user_func( 'imagecreatefrom' . $img_type, $filename );
		$dst_img = imagecreatetruecolor( $nova_largura, $nova_altura );

		imagecopyresampled( $dst_img, $src_img, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura, $altura );

		$nome_img = $this->randName( $filename );

		// verifica se é JPEG
		// Se for, adiciona o terceiro parâmetro (img_quality)
		if ( $img_type == 'jpeg' )
		{
			imagejpeg( $dst_img, $nome_img, $this->img_quality );
		}
		else
		{
			call_user_func( 'image' . $img_type, $dst_img, $nome_img );
		}

		imagedestroy( $src_img );
		imagedestroy( $dst_img );

		return $nome_img;
	}
	/*------------------------------------------------------*/

	/**
	 * Gera \em thumbnail de uma imagem.
	 * @param filename Imagem da qual deve ser gerado o \em thumbnail.
	 * @return Retorna o nome final do \em thumbnail.
	*/
	public function createThumb( $filename )
	{
		list( $largura, $altura ) = getimagesize( $filename );
		$img_type = $this->getImgType( $filename );

		// define largura e altura conforma o tamanho da imagem,
		// a fim de manter a proporção entre as dimensões

		if ( $largura > $altura)
		{
			$nova_largura = $this->max_thumb_width;
			$nova_altura = round( ($nova_largura / $largura) * $altura );
		}
		elseif ( $altura > $largura )
		{
			$nova_altura = $this->max_thumb_height;
			$nova_largura = round( ($nova_altura / $altura) * $largura );
		}
		else
		{
			$nova_altura = $nova_largura = $this->max_thumb_width;
		}

		$src_img = call_user_func( 'imagecreatefrom' . $img_type, $filename );
		$dst_img = imagecreatetruecolor( $nova_largura, $nova_altura );

		imagecopyresampled( $dst_img, $src_img, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura, $altura );

		$ext = end( explode( '.', $filename ) );
		$nome_arr = pathinfo( $filename );
		$nome_img = dirname( $filename) . DIRECTORY_SEPARATOR . $this->thumb_prefix . $nome_arr['filename'] . $this->thumb_sufix . '.' . $ext;

		// verifica se é JPEG
		// Se for, adiciona o terceiro parâmetro (thumb_quality)
		if ( $img_type == 'jpeg' )
		{
			imagejpeg( $dst_img, $nome_img, $this->thumb_quality );
		}
		else
		{
			call_user_func( 'image' . $img_type, $dst_img, $nome_img );
		}

		imagedestroy( $src_img );
		imagedestroy( $dst_img );

		return $nome_img;
	}
	/*----------------------------------------------------------*/

	/**
	 * Gera um novo nome para a imagem, evitando que haja arquivos com os mesmos nomes.
	 * @param filename Nome original do arquivo.
	 * @return Retorna o novo nome do arquivo.
	 * @note Se for passado um caminho completo para o método (com nomes de diretórios), o retorno conterá o caminho completo também, alterando apenas o nome do arquivo, sem modificar os nomes dos diretórios.
	*/
	protected function randName( $filename )
	{
		$tipo = getimagesize( $filename );
		$tipo = $tipo[2];

		switch ( $tipo )
		{
			case 1:
				$ext = 'gif';
				break;
			case 2:
				$ext = 'jpg';
				break;
			case 3:
				$ext = 'png';
				break;
			default:
				$ext = false;
		}

		if ( !$ext )
		{
			return false;
		}

		$novo_nome = strtolower( str_replace( ".", "", uniqid( time(), true) ) );
		$nome = ( $novo_nome . "." . $ext );

		return dirname( $filename ) . DIRECTORY_SEPARATOR . $nome;
	}
	/*---------------------------------------------*/

	/**
	 * Insere logomarca (marca d'água) numa imagem.
	 * @param filename Caminho para o arquivo da imagem na qual deve ser inserida a logomarca (marca d'água).
	 * @param logoBorder Distância que a logomarca (marca d'água) ficará da borda da imagem, em pixels. Por padrão, essa distância é de 5 pixels.
	 * @param logoPosition Posição em que deverá ser inserida a logomarca (marca d'água). Pode ser um dos seguintes valores (constantes):
	 * 	@li IMGHANDLER_LOGO_TOP_LEFT -> Insere no topo esquerdo;
	 * 	@li IMGHANDLER_LOGO_TOP_RIGHT -> Insere no topo direito;
	 * 	@li IMGHANDLER_LOGO_TOP_CENTER -> Insere no topo central;
	 * 	@li IMGHANDLER_LOGO_BOTTOM_LEFT -> Insere na base esquerda;
	 * 	@li IMGHANDLER_LOGO_BOTTOM_RIGHT -> Insere na base direita;
	 * 	@li IMGHANDLER_LOGO_BOTTOM_CENTER -> Insere na base central;
	 * 	@li IMGHANDLER_LOGO_MIDDLE_LEFT -> Insere na pate central vertical, à esquerda;
	 * 	@li IMGHANDLER_LOGO_MIDDLE_RIGHT -> Insere na pate central vertical, à direita;
	 * 	@li IMGHANDLER_LOGO_MIDDLE_CENTER -> Insere na pate central vertical, centrailzado horizontalmente;
	 *
	 *
	 * Por padrão, a logomarca é inserida na base direita.
	 *
	 * @return Retorna TRUE em caso de sucesso e FALSE em caso de erro.
	*/
	public function insertLogo( $filename, $logoBorder = 5, $logoPosition = NULL )
	{
		if ( !file_exists( $filename ) )
		{
			echo "Arquivo \"" . $filename . "\" não encontrado";
			return false;
		}

		if ( !is_int( $logoBorder ) || $logoBorder < 0 )
		{
			$logoBorder = 0;
		}

		if ( $logoPosition == NULL )
		{
			// assume o valor padrão
			$logoPosition = IMGHANDLER_LOGO_BOTTOM_RIGHT;
		}

		$logoBorder++;

		$logo_type = $this->getImgType( $this->logo_file );
		$img_type = $this->getImgType( $filename );

		if ( !$logo_type || !$img_type )
		{
			return false;
		}

		$img = call_user_func( 'imagecreatefrom' . $img_type, $filename );
		$logo = call_user_func( 'imagecreatefrom' . $logo_type, $this->logo_file );

		// dimensões das imagens
		$img_size = array( imagesx( $img ), imagesy( $img ) );
		$logo_size = array( imagesx( $logo ), imagesy( $logo ) );

		// ponto onde deverá ser inserida a logomarca
		switch ( $logoPosition )
		{
			case IMGHANDLER_LOGO_TOP_LEFT:
				$x = $logoBorder;
				$y = $logoBorder;
				break;

			case IMGHANDLER_LOGO_TOP_RIGHT:
				$x = $img_size[0] - ( $logo_size[0] + $logoBorder );
				$y = $logoBorder;
				break;

			case IMGHANDLER_LOGO_TOP_CENTER:
				$x = ( $img_size[0] / 2 - ( $logo_size[0] / 2 ) ) - $logoBorder;
				$y = $logoBorder;
				break;

			case IMGHANDLER_LOGO_BOTTOM_LEFT:
				$x = $logoBorder;
				$y = $img_size[1] - ( $logo_size[1] + $logoBorder );
				break;

			case IMGHANDLER_LOGO_BOTTOM_RIGHT:
				$x = $img_size[0] - ( $logo_size[0] + $logoBorder );
				$y = $img_size[1] - ( $logo_size[1] + $logoBorder );
				break;

			case IMGHANDLER_LOGO_BOTTOM_CENTER:
				$x = ( $img_size[0] / 2 - ( $logo_size[0] / 2 ) ) - $logoBorder;
				$y = $img_size[1] - ( $logo_size[1] + $logoBorder );
				break;

			case IMGHANDLER_LOGO_MIDDLE_LEFT:
				$x = $logoBorder;
				$y = ( $img_size[1] / 2 - ( $logo_size[1] / 2 ) ) - $logoBorder;
				break;

			case IMGHANDLER_LOGO_MIDDLE_RIGHT:
				$x = $img_size[0] - ( $logo_size[0] + $logoBorder );
				$y = ( $img_size[1] / 2 - ( $logo_size[1] / 2 ) ) - $logoBorder;
				break;

			case IMGHANDLER_LOGO_MIDDLE_CENTER:
				$x = ( $img_size[0] / 2 - ( $logo_size[0] / 2 ) ) - $logoBorder;
				$y = ( $img_size[1] / 2 - ( $logo_size[1] / 2 ) ) - $logoBorder;
				break;

			default:
				$x = $y = false;

		}

		if ( !$x || !$y )
		{
			return false;
		}

		$logo_point = array( $x, $y );

		imagecopy( $img, $logo, $logo_point[0], $logo_point[1], 0, 0, $logo_size[0], $logo_size[1] );

		// verifica se é JPEG
		// Se for, adiciona o terceiro parâmetro (thumb_quality)
		if ( $img_type == 'jpeg' )
		{
			imagejpeg( $img, $filename, $this->img_quality );
		}
		else
		{
			call_user_func( 'image' . $img_type, $img, $filename );
		}

		imagedestroy( $logo );
		imagedestroy( $img );

		return true;
	}
	/*----------------------*/

	/**
	 * Identifica o tipo de uma imagem.
	 * @param filename Caminho da imagem.
	 * @return Retorna o tipo da imagem (gif, jpeg ou png).
	*/
	protected function getImgType( $filename )
	{
		$type = getimagesize( $filename );

		if ( $type == FALSE || !is_array( $type ) )
		{
			return false;
		}

		switch ( $type[2] )
		{
			case 1: // GIF
				$img_type = 'gif';
				break;
			case 2: // JPEG
				$img_type = 'jpeg';
				break;
			case 3: // PNG
				$img_type = 'png';
				break;
			default:
				$img_type = false;
		}

		return $img_type;
	}
	/*-----------------------------*/

	/**
	 * Modifica as dimensões máximas das iamgens.
	 * @param width Largura máxima das imagens.
	 * @param height Altgura máxima das imagens.

	*/
	public function setMaxImgSize( $width, $height )
	{
		if ( is_integer( $width ) && is_integer( $height ) )
		{
			$this->max_img_width = $width;
			$this->max_img_height = $height;
		}
	}
	/*------------------------*/

	/**
	 * Modifica as dimensões máximas das miniaturas (thumbnails).
	 * @param width Largura máxima das miniaturas (thumbnails).
	 * @param height Altgura máxima das miniaturas (thumbnails).

	*/
	public function setMaxThumbSize( $width, $height )
	{
		if ( is_integer( $width ) && is_integer( $height ) )
		{
			$this->max_thumb_width = $width;
			$this->max_thumb_height = $height;
		}
	}
	/*------------------------*/

	/**
	 * Determina o prefixo das miniaturas (thumbnails)
	 * @param prefix Prefixo das miniaturas (thumbnails)
	*/
	public function setThumbPrefix( $prefix )
	{
		$this->thumb_prefix = $prefix;
	}
	/*----------------------------*/

	/**
	 * Determina o sufixo das miniaturas (thumbnails)
	 * @param sufix Sufixo das miniaturas (thumbnails)
	*/
	public function setThumbSufix( $sufix )
	{
		$this->thumb_sufix = $sufix;
	}
	/*----------------------------*/

	/**
	 * Define a qualidade final da imagem.
	 * @note Esse valor só é usado em imagens JPEG.
	 * @param img_quality Qualidade final da imagem. Deve ser um inteiro entre 0 e 100.
	*/
	public function setImgQuality( $img_quality )
	{
		if ( !is_int( $img_quality ) || $img_quality < 0 || $img_quality > 100 )
		{
			return false;
		}

		$this->img_quality = $img_quality;
	}
	/*-------------------------*/

	/**
	 * Define a qualidade final da miniatura (\e thumbnail).
	 * @note Esse valor só é usado em imagens JPEG.
	 * @param thumb_quality Qualidade final da miniatura (\e thumbnail). Deve ser um inteiro entre 0 e 100.
	*/
	public function setThumbQuality( $thumb_quality )
	{
		if ( !is_int( $thumb_quality ) || $thumb_quality < 0 || $thumb_quality > 100 )
		{
			return false;
		}

		$this->thumb_quality = $thumb_quality;
	}
	/*-------------------------*/

	/**
	 * Altera o caminho do arquivo da logomarca (marca d'água) que deve sr inserida nas imagens.
	 * @param logo_file Caminho para o arquivo da logomarca (marca d'água).
	*/
	public function setLogoFile( $logo_file )
	{
		if ( !file_exists( $logo_file ) )
		{
			echo "Arquivo \"" . $logo_file . "\" não encontrado. Retornando ao valor padrão.";
		}
		else
		{
			$this->logo_file = $logo_file;
		}
	}
	/*---------------------*/

}

?>
