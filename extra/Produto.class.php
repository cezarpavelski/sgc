<?php 
	class Produto {
  
	  private $id;
	  private $nome;
	  private $preco;
	  private $peso;
	  private $imagem;
	  private $quantidade;
	
	  function Produto(){
	  	
	  }
	  
	  function __construct($id,$nome,$preco,$peso,$imagem,$quantidade) {
		   $this->id  = $id;
		   $this->nome = $nome;
		   $this->preco = $preco;
		   $this->peso = $peso;
		   $this->imagem = $imagem;
		   $this->quantidade   = $quantidade;
	  }
	
	  function getId() {
	   return $this->id;
	  }
	  
	  function setId($id){
	   $this->id = $id;	
	  }
	
	  function getQuantidade() {
	   return $this->quantidade;
	  }
	
	  function setQuantidade($quantidade) {
	   $this->quantidade = $quantidade;
	  }
	  
	  function getNome() {
	   return $this->nome;
	  }
	  
	  function setNome($nome){
	   $this->nome = $nome;	
	  }
	
	  function getPreco() {
	   return $this->preco;
	  }
	
	  function setPreco($preco) {
	   $this->preco = $preco;
	  }
	  
	  function getPeso() {
	   return $this->peso;
	  }
	  
	  function setPeso($peso){
	   $this->peso = $peso;	
	  }
	
	  function getImagem() {
	   return $this->imagem;
	  }
	
	  function setImagem($imagem) {
	   $this->imagem = $imagem;
	  }
 }
?>