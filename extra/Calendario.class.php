<?php 
	class Calendario{
		private $data;
		private $dias;

		public function getData() {
			return $this->data;
		}
		
		public function getDias() {
			return $this->dias;
		}
	
		public function setData($data) {
			$this->data = $data;
		}

		public function Calendario(){
			
		}
		
		public function __construct($data=""){
			$this->data = $data;
			$this->GerarCalendario();
		}
		
		public function DiaDaSemana($dia,$mes,$ano){
			$diaTemp=date("w", strtotime($ano."-".$mes."-".$dia));
			switch($diaTemp) {
		       case 0: $diaDaSemana = "Domingo"; break;
		       case 1: $diaDaSemana = "Segunda-Feira"; break;
		       case 2: $diaDaSemana = "Terça-Feira"; break;
		       case 3: $diaDaSemana = "Quarta-Feira"; break;
		       case 4: $diaDaSemana = "Quinta-Feira"; break;
		       case 5: $diaDaSemana = "Sexta-Feira"; break;
		       case 6: $diaDaSemana = "Sábado"; break;
		   }
		   return $diaDaSemana;
		}
		
		public function GerarCalendario(){
		   $data=explode("/",$this->data);
		   $ano=$data[1];
		   $mes=$data[0];
		   if (((fmod($ano,4)==0) and (fmod($ano,100)!=0)) or (fmod($ano,400)==0)) {
		       $dias_fevereiro = 29;
		   } else {
		       $dias_fevereiro = 28;
		   }
		   switch($mes) {
		       case 01: $this->dias = 31; break;
		       case 02: $this->dias = $dias_fevereiro; break;
		       case 03: $this->dias = 31; break;
		       case 04: $this->dias = 30; break;
		       case 05: $this->dias = 31; break;
		       case 06: $this->dias = 30; break;
		       case 07: $this->dias = 31; break;
		       case 08: $this->dias = 31; break;
		       case 09: $this->dias = 30; break;
		       case 10: $this->dias = 31; break;
		       case 11: $this->dias = 30; break;
		       case 12: $this->dias = 31; break;
		   } 
		   for($i=1; $i<=$this->dias; $i++){
		   		$calendario[$i]["dia"]=$i;
		   		$calendario[$i]["mes"]=$mes;
		   		$calendario[$i]["ano"]=$ano;
		   		$calendario[$i]["diaDaSemana"] = $this->DiaDaSemana($i,$mes,$ano);
		   }
		   return $calendario;
		}
	}

?>