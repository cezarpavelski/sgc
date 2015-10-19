<?php 
	require_once 'Produto.class.php';
	class CarrinhoDeCompras extends Produto{
	
		var $carrinho;
		
		//Coloca o novo Carrinho de Compras na sessão
		function CarrinhoDeCompras() {
			if(!$_SESSION['carrinho']){
				$_SESSION['carrinho'] = Array();
			}else{
				$_SESSION['carrinho'];
			}
		}
		
		//Atualiza os dados da sessão
		function atualizaDados() {
			$_SESSION["carrinho"] = @serialize($this->carrinho);
			$_SESSION["carrinho"];
		}
		
		//Pega os dados da sessão
		function getCarrinho() {
			$this->carrinho = @unserialize($_SESSION["carrinho"]);
		}
		
		//Adiciona um item no carrinho de compras
		function adicionaItem($produto) {
			//Pega os dados atualizados da sessão
			$this->getCarrinho();
			$codigo = $produto->getId();
			//Seo produto ainda não está no carrinho adicione
			if (!isset($this->carrinho[$codigo])) {
				$this->carrinho[$codigo] = $produto;
			}
			//Caso contrário, apenas incremente a quantidade do produto já existente
			else {
				$quantidade = $produto->getQuantidade();
				$quantidade1 = $this->carrinho[$codigo]->getQuantidade();
				$this->carrinho[$codigo]->setQuantidade($quantidade+$quantidade1);
		}
			//Atualiza os dados da sessão
			$this->atualizaDados();
		}
		
		
		//Remove um item do carrinho de compras
		function removeItem($produto) {
			$this->getCarrinho();
			
			$codigo = $produto->getId();
			unset($this->carrinho[$codigo]);
			
			$this->atualizaDados();
		}
		
		//Pega o valor total das compras do usuário
		function getTotal() {
			$this->getCarrinho();
			$total = 0;
			foreach($this->carrinho as $produto) {
				$total += $produto->getPreco()*$produto->getQuantidade();
			}
			return $total;
		}
		
		function listaCarrinho(){
			$this->getCarrinho();
			return $this->carrinho;
		}
		
		function getTotalDeItens(){
			$this->getCarrinho();
			if(count($_SESSION["carrinho"])!=0){
				$quantidade = count($this->carrinho);
			}else{
				$quantidade = 0;
			}
			return $quantidade;
		}
		
		function getPesoTotal(){
			$this->getCarrinho();
			$total = 0;
			foreach($this->carrinho as $produto) {
				$total += $produto->getPeso()*$produto->getQuantidade();
			}
			return $total;
		}
		
		function limparCarrinho(){
			$_SESSION['carrinho']="";
		}
	
	}
?>