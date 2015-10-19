<?php 
/*======================Como Utilizar===================================================================
 * Para utilizar o menu sem submenu coloque apenas o links exemplo "HOME"=>array(links=>array("index.php"))
 * 
$menu= new MenuDropDown(array(
								  "tEste"=>array(
											labels=>array("teste1","teste2"), 
											links=>array("index.php","index2.php")
											)
								   )
						,'#990000','#000000','#ccccccc','#ffffff');
	echo $menu->GerarMenu();
*/
	class MenuDropDown{
		private $itensMenu;
		private $corDaFonte;
		private $corDoFundo;
		private $corDaBorda;
		private $corRollOver;
		
		public function MenuDropDown(){
			
		}
		
		public function __construct($itensMenu="", $corDaFonte="#777", $corDoFundo="#FFFFFF", $corDaBorda="#777" , $corRollOver="red"){
			$this->itensMenu = $itensMenu;
			$this->corDaFonte = $corDaFonte;
			$this->corDoFundo = $corDoFundo;
			$this->corDaBorda = $corDaBorda;
			$this->corRollOver = $corRollOver;
			$this->gerarMenu();
		}
		
		public function GerarScript(){
			$script='
			<script type="text/javascript">
			    function horizontal() {
				   var navItems = document.getElementById("menu_dropdown").getElementsByTagName("li");
				   for (var i=0; i< navItems.length; i++) {
				      if(navItems[i].className == "submenu")
				      {
				         if(navItems[i].getElementsByTagName("ul")[0] != null)
				         {
				            navItems[i].onmouseover=function() {this.getElementsByTagName("ul")[0].style.display="block";}
				            navItems[i].onmouseout=function() {this.getElementsByTagName("ul")[0].style.display="none";}
				         }
				      }
				   }
				}
				window.onload = function(){
					horizontal();		
				}
			</script>
			';
			return $script;
		}
		
		public function GerarStyle(){
			$style='
			<style>
				ul.menubar{
				  font-family:"Century Gothic", Verdana, Arial; 
				  margin: 0px;
				  padding: 0px;
				  font-size: 14px;
				  z-index:1001;
				}
				
				ul.menubar .submenu{
				  margin: 0px;
				  list-style: none;
				  border-right: 1px solid '.$this->corDaBorda.';
				  float:left;
				  z-index:1001;
				  padding:0 10px 0 10px;
				  margin:0 0 0 2px;
				}
				 
				ul.menubar ul.menu{
				  display: none;
				  position: absolute;
				  margin: 0px;
				}
				 
				ul.menubar a{
				  padding: 0px;
				  display:block;
				  text-decoration: none;
				  color: '.$this->corDaFonte.';
				  padding: 5px;
				}
				 
				ul.menu, ul.menu ul{
				  margin: 0;
				  padding: 0;
				  border-bottom: 1px solid '.$this->corDaBorda.';
				  width: 200px; /* Width of Menu Items */
				  background-color: '.$this->corDoFundo.'; /* IE6 Bug */
				}
				 
				ul.menu li{
				  position: relative;
				  list-style: none;
				  border: 0px;
				}
				 
				ul.menu li a{
				  display: block;
				  text-decoration: none;
				  border: 1px solid '.$this->corDaBorda.';
				  border-bottom: 0px;
				  color: '.$this->corDaFonte.';
				  padding: 5px 10px 5px 5px;
				}
				 
				ul.menu li sup{
				  font-weight:bold;
				  font-size:7px;
				  color: '.$this->corDaFonte.';
				}
				 
				/* Fix IE. Hide from IE Mac \*/
				* html ul.menu li { float: left; height: 1%; }
				* html ul.menu li a { height: 1%; }
				/* End */
				 
				ul.menu ul{
				  position: absolute;
				  display: none;
				  left: 149px; /* Set 1px less than menu width */
				  top: 0px;
				}
				 
				ul.menu li.submenu ul { display: none; } /* Hide sub-menus initially */
				 
				ul.menu li.submenu { background: transparent right center no-repeat; }
				 
				ul.menu li a:hover { background-color: '.$this->corRollOver.'; }
				
				ul a:hover { color: #990000; }
			</style>
			';
			return $style;
		}
		
		public function GerarMenu(){
			$menu = '<ul id="menu_dropdown" class="menubar">';
			$opcoes = $this->itensMenu;
			
			while (current($opcoes)) {
				$key = key($opcoes);
				$labels=$opcoes[$key][labels];
				$links=$opcoes[$key][links];
				$target=$opcoes[$key][target];
				
				if($links && !$labels){
					if($target[0]=='_self'){
						$links[0]="index.php?pg=".$links[0];
					}
					$menu .= '<li class="submenu"><a href="'.$links[0].'" target="'.$target[0].'">'.$key.'</a>';
				}else{
					$menu .= '<li class="submenu"><a href="#">'.$key.'</a>';	
					$menu .= '<ul class="menu">';
					for($i=0; $i<count($labels); $i++){
						if($target[$i]=='_self'){
							$links[$i]="index.php?pg=".$links[$i];
						}
						$menu .= '<li><a href="'.$links[$i].'" target="'.$target[$i].'">'.$labels[$i].'</a></li>';
					}
					$menu .= '</ul>';
				}	
				$menu .= '</li>';	
				next($opcoes);
			}			   
			$menu .= '</ul>';
			$menuGerado = $this->GerarScript().$this->GerarStyle().$menu;
			return $menuGerado;
		}
		
		public function getItensMenu() {
			return $this->itensMenu;
		}
	
		public function getCorDaFonte() {
			return $this->corDaFonte;
		}
	
		public function getCorDoFundo() {
			return $this->corDoFundo;
		}
	
		public function getCorDaBorda() {
			return $this->corDaBorda;
		}
		
		public function getCorRollOver() {
			return $this->corRollOver;
		}
		
		public function setItensMenu($itensMenu) {
			$this->itensMenu = $itensMenu;
		}
	
		public function setCorDaFonte($corDaFonte) {
			$this->corDaFonte = $corDaFonte;
		}
	
		public function setCorDoFundo($corDoFundo) {
			$this->corDoFundo = $corDoFundo;
		}
	
		public function setCorDaBorda($corDaBorda) {
			$this->corDaBorda = $corDaBorda;
		}
		
		public function setCorRollOver($corRollOver) {
			$this->corRollOver = $corRollOver;
		}

		public function __toString() {
			return $this->gerarMenu();
		}
		
		
		
	}

?>