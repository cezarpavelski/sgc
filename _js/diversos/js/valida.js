/***
* Descrição.: formata um campo do formulário de
* acordo com a máscara informada...
* Parâmetros: - objForm (o Objeto Form)
* - strField (string contendo o nome
* do textbox)
* - sMask (mascara que define o
* formato que o dado será apresentado,
* usando o algarismo "9" para
* definir números e o símbolo "!" para
* qualquer caracter...
* - evtKeyPress (evento)
* Uso.......: <input type="textbox" 
* name="xxx".....
* onkeypress="return txtBoxFormat(document.rcfDownload, 'str_cep', '99999-999', event);">
* Observação: As máscaras podem ser representadas como os exemplos abaixo:
* CEP -> 99.999-999
* CPF -> 999.999.999-99
* CNPJ -> 99.999.999/9999-99
* Data -> 99/99/9999
* Tel Resid -> (99) 999-9999
* Tel Cel -> (99) 9999-9999
* Processo -> 99.999999999/999-99
* C/C -> 999999-!
* E por aí vai... 
***/

function txtBoxFormat(objForm, strField, sMask, evtKeyPress) {
      var i, nCount, sValue, fldLen, mskLen,bolMask, sCod, nTecla;

      if(document.all) { // Internet Explorer
        nTecla = evtKeyPress.keyCode; }
      else if(document.layers) { // Nestcape
        nTecla = evtKeyPress.which;
      }else{
      	nTecla = evtKeyPress.which;
      }

      sValue = objForm[strField].value;

      // Limpa todos os caracteres de formatação que
      // já estiverem no campo.
      sValue = sValue.toString().replace( "-", "" );
      sValue = sValue.toString().replace( "-", "" );
      sValue = sValue.toString().replace( ".", "" );
      sValue = sValue.toString().replace( ".", "" );
      sValue = sValue.toString().replace( "/", "" );
      sValue = sValue.toString().replace( "/", "" );
      sValue = sValue.toString().replace( "(", "" );
      sValue = sValue.toString().replace( "(", "" );
      sValue = sValue.toString().replace( ")", "" );
      sValue = sValue.toString().replace( ")", "" );
      sValue = sValue.toString().replace( " ", "" );
      sValue = sValue.toString().replace( " ", "" );
      fldLen = sValue.length;
      mskLen = sMask.length;

      i = 0;
      nCount = 0;
      sCod = "";
      mskLen = fldLen;

      while (i <= mskLen) {
        bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/"))
        bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " "))

        if (bolMask) {
          sCod += sMask.charAt(i);
          mskLen++; }
        else {
          sCod += sValue.charAt(nCount);
          nCount++;
        }

        i++;
      }

      objForm[strField].value = sCod;

      if (nTecla != 8) { // backspace
        if (sMask.charAt(i-1) == "9") { // apenas números...
          return ((nTecla > 47) && (nTecla < 58)); } // números de 0 a 9
        else { // qualquer caracter...
          return true;
        } 
      } else {
        return true;
      }
    }

function formatString(objForm, strCampo, sCase){
	var texto = objForm[strCampo].value;
	var sTexto;
	
	if (sCase=='UP'){
		sTexto=texto.toUpperCase();
	}
	else{
		sTexto=texto.toLowerCase();		
	}
	objForm[strCampo].value=sTexto;
	return true;
}

function Limpar(valor, validos) {
	// retira caracteres invalidos da string
	var result = "";
	var aux;
	for (var i=0; i < valor.length; i++) {
		aux = validos.indexOf(valor.substring(i, i+1));
		if (aux>=0) {
			result += aux;
		}
	}
	return result;
}

//FORMAT NÚMERO COMO MOEDA NO EVENTO KEYDOWN
function Formata(campo,tammax,teclapres,decimal) {
	var tecla = teclapres.keyCode;
	vr = Number(Limpar(campo.value,"0123456789"));
	vr=String(vr);
	tam = vr.length;
	dec=decimal

	if (tam < tammax && tecla != 8){
		tam = vr.length + 1 ; 
	}

	if (tecla == 8 ){
		tam = tam - 1 ; 
	}

	if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ){				
		if((tam==0) || (tam==2)){
			campo.value="0," + vr;
		}
		if ( (tam > dec) && (tam <= 5) ){
			campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec, tam ) ; 
		}
		if ( (tam >= 6) && (tam <= 8) ){
			campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ); 
		}
		if ( (tam >= 9) && (tam <= 11) ){
			campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + 
			"," + vr.substr( tam - dec, tam ) ; 
		}
		if ( (tam >= 12) && (tam <= 14) ){
			campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + 
			"." + vr.substr(tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
		}
		if ( (tam >= 15) && (tam <= 17) ){
			campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14, 3 ) + "." + vr.substr( tam - 11, 3 ) + 
			"." + vr.substr(tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ;
		}
	} 
	
}

//ARREDONDA O NUMERO DUAS CASAS DECIMAIS	
function Arred(num){	
			
	var txtnum=(String(num));
	var tam = txtnum.search(/\./)+1;
	var nstr;
	var val="";
	var z=0;
	var g=0;
	var r=0;
	
	if (tam<=0){
		txtnum=txtnum+".00";
		tam=txtnum.search(/\./)+1;
	}
							
	var dec = txtnum.substr(tam,3);															
	if(Number(dec.substr(2,1))>=5){
		dec=Number(dec.substr(0,2))+1;
	}
	else{
		dec=dec.substr(0,2);
		if (dec.length==1){
			dec=dec+"0";
		}
	}
	
	
	nstr=txtnum.substr(0,tam-1);
	z=nstr.length%3;
	if ((tam >=3) && (z!=0)){
		for(r=1;r<=Math.floor(nstr.length/3);r++){
			val=val+nstr.substr(g,z)+".";
			g=z;
			z=3;
		}
		val=val+nstr.substr(g,z);
	}
	else {
		val=nstr;
	}
	val=val+","+dec;
	
	return val;
}

//CALCULA A SOMATÓRIA DOS VALORES E ATRIBUI AO FORMULÁRIO.
function Calcula(obj, k){
	var i;
	var soma=0;
	var j= obj.id;
	
	var val=Number(((document.getElementById(j).value).replace(".","")).replace(",","."));
	var qtd=Number(document.getElementById("qtd"+j.substr(3,1)).innerHTML);
	var subt=val*qtd;
	
	document.getElementById("div"+j.substr(3,1)).innerHTML=Arred(subt);
	for(i=0; i<k; i++){			
		soma+=Number((String(document.getElementById("div"+i).innerHTML).replace(".","")).replace(",","."));
	}
	
	document.getElementById("total").innerHTML="R$ "+Arred(soma);			
}

function getCookie(cook){
	if (document.cookie.length>0){
		start=document.cookie.indexOf(cook + "=");
	  	if (start!=-1){ 
			start=start + cook.length+1; 
			end=document.cookie.indexOf(";", start);
			if (end==-1){
				end=document.cookie.length;
			}
			return unescape(document.cookie.substring(start, end));
		} 
	}
	return ""
}

function trocaTab(pos){
	if(getCookie('old_pos')){
		document.getElementById('01b'+getCookie('old_pos')).src="images/borda_01b.gif";
		document.getElementById('02b'+getCookie('old_pos')).style.backgroundImage="url(images/borda_02b.gif)";
		document.getElementById('03b'+getCookie('old_pos')).src="images/borda_03b.gif";
		document.getElementById('div'+getCookie('old_pos')).style.display='none';
	}
	
	document.getElementById('01b'+pos).src="images/borda_01a.gif";
	document.getElementById('02b'+pos).style.backgroundImage="url(images/borda_02a.gif)";
	document.getElementById('03b'+pos).src="images/borda_03a.gif";
	document.getElementById('div'+pos).style.display='';
	document.cookie='old_pos='+pos;
	document.cookie='pos_tab='+pos;
}

function vetQtd(cod){
	var cook=getCookie('minhas_qtds');
	var ps=cook.search(cod);
	var ps_ini=cook.indexOf(":",ps)+1;
	var ps_fim=cook.indexOf(",",ps_ini);
	return cook.substr(ps_ini, ps_fim-ps_ini);								
}

function remQtd(cod){
	var cook=getCookie('minhas_qtds');
	var ps=cook.search(cod);
	var ps_fim=cook.indexOf(",",ps);
	var prt=cook.substr(ps, ps_fim-ps+1);
	
	var res_cook=cook.replace(prt, '');
	document.cookie='minhas_qtds='+res_cook;

	var prod=getCookie('meus_produtos');
	var ps=prod.search(cod);
	var ps_fim=prod.indexOf(",",ps);
	var prt=prod.substr(ps, ps_fim-ps+1);

	var res_prod=prod.replace(prt, '');
	document.cookie='meus_produtos='+res_prod;

}

function altQtd(cod, valor){
	var cook=getCookie('minhas_qtds');
	var ps=cook.search(cod);
	var ps_fim=cook.indexOf(",",ps);
	var prt=cook.substr(ps, ps_fim-ps+1);
	
	var res_cook=cook.replace(prt, '');
	document.cookie='minhas_qtds='+res_cook+cod+':'+valor+',';
	
}