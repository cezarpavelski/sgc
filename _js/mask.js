//-----> PADRONIZAÇÃO DO JAVASCRIPT
//-----> Funcional em: IE e Firefox
//-----> Autor:David Augustynczyk / 2006
//
//-----> LEGENDA DAS FUNÇÕES
//
// v_... = validação ...
// m_... = máscara ...

function valida_email(){
	if (document.form999.login.value.indexOf('@')==-1||document.form999.login.value.indexOf('.')==-1){
	alert('Digite um Email válido');
	document.form999.login.value='';
	document.form999.login.focus();
	}
}


//-----> somente números:
function mascaraEntrada(objeto, sMask, evtKeyPress){ // onkeypress="javascript:return mascaraEntrada(this,'99999-999',event);" 
	 
	var i, nCount, sValue, fldLen, mskLen,bolMask, sCod, nTecla; 
	
	if (document.all) { nTecla = evtKeyPress.keyCode; } 
	else if (document.layers) { nTecla = evtKeyPress.which; } 
	else { nTecla = evtKeyPress.which; if (nTecla == 8){ return true; } } 
	
	sValue = objeto.value; 
	
	sValue = sValue.toString().replace( "-", "" ); 
	sValue = sValue.toString().replace( "-", "" ); 
	sValue = sValue.toString().replace( ".", "" ); 
	sValue = sValue.toString().replace( ".", "" ); 
	sValue = sValue.toString().replace( "/", "" ); 
	sValue = sValue.toString().replace( "/", "" ); 
	sValue = sValue.toString().replace( ":", "" ); 
	sValue = sValue.toString().replace( ":", "" ); 
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
	
	while (i <= mskLen){ 
	bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/") || (sMask.charAt(i) == ":")) 
	bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " ")) 
	if (bolMask) 
	{ 
	sCod += sMask.charAt(i); 
	mskLen++; 
	} 
	else 
	{ 
	sCod += sValue.charAt(nCount); 
	nCount++; 
	} 
	i++; 
	} 
	
	objeto.value = sCod; 
	
	if (nTecla != 8) 
	{ 
	if (sMask.charAt(i-1) == "9") 
	{ 
	return ((nTecla > 47) && (nTecla < 58)); 
	} 
	else { return true; } 
	} 
	else { return true; } 
} 


function v_NR(tecla){

	if(typeof(tecla) == 'undefined')
	var tecla = window.event;
	var codigo = (tecla.which ? tecla.which : tecla.keyCode ? tecla.keyCode : tecla.charCode);
	
	// permite números, 8=backspace, 46=del e 9=tab
	if ( (codigo >= 48 && codigo <= 57) || (codigo >= 96 && codigo <= 105) || codigo == 8 || codigo == 46 || codigo == 9 ){ 
		return true; 
	}else{ 
		alert("Apenas números são permitidos !"); return false; 
	} 
}


//-----> máscara cnpj:

function m_CNPJ(campo,tammax) {

var vr = campo.value;
vr = vr.replace( "-", "" );
vr = vr.replace( "/", "" );
vr = vr.replace( ".", "" );
vr = vr.replace( ".", "" );
var tam = vr.length;

if (tam < tammax) { tam = vr.length + 1 ; }

tam = tam - 1;
if ( (tam > 2) && (tam <= 5) ) {
vr = vr.substr( 0, tam - 1 ) + '-' + vr.substr( tam - 1, tam ) ; }
if ( (tam >= 6) && (tam <= 8) ) {
vr = vr.substr( 0, tam - 5 ) + '/' + vr.substr( tam - 5, 4 ) + '-' + vr.substr( tam - 1, tam ) ; }
if ( (tam >= 9) && (tam <= 11) ) {
vr = vr.substr( 0, tam - 8 ) + '.' + vr.substr( tam - 8, 3 ) + '/' + vr.substr( tam - 5, 4 ) + '-' + vr.substr( tam - 1, tam ) ; }
if ( (tam >= 12) && (tam < 14) ) {
vr = vr.substr( 0, tam - 11 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '/' + vr.substr( tam - 5, 4 ) + '-' + vr.substr( tam - 1, tam ) ; }

campo.value = vr; 
}

//-----> máscara cpf: 
function m_CPF(campo,tammax) {

var vr = campo.value;
vr = vr.replace( "-", "" );
vr = vr.replace( ".", "" );
vr = vr.replace( ".", "" );
var tam = vr.length;

if (tam < tammax) { tam = vr.length + 1; }

tam = tam - 1;
if ( (tam > 2) && (tam <= 11) ) {
vr = vr.substr( 0, tam - 1 ) + '-' + vr.substr( tam - 1, tam ); }
if ( (tam == 10) ) {
vr = vr.substr( 0, tam - 7 ) + '.' + vr.substr( tam - 7, 3 ) + '.' + vr.substr( tam - 4, tam ); }

campo.value = vr;
}



//-----> máscara cep:
function m_CEP(campo,tammax) {

var vr = campo.value;
vr = vr.replace( "-", "" );
vr = vr.replace( ".", "" );
var tam = vr.length;

if (tam < tammax) { tam = vr.length + 1; }

tam = tam - 1;
if ( (tam > 2) && (tam <= 8) ) {
vr = vr.substr( 0, tam - 2 ) + '-' + vr.substr( tam - 2, tam ); }
if ( (tam == 7) ) {
vr = vr.substr( 0, tam - 5 ) + '.' + vr.substr( tam - 5, tam ); }

campo.value = vr;
}



//-----> máscara data:
function m_DATA(campo,tammax,tecla) {

if(typeof(tecla) == 'undefined')
var tecla = window.event;
var codigo = (tecla.which ? tecla.which : tecla.keyCode ? tecla.keyCode : tecla.charCode);

var vr = campo.value;
vr = vr.replace( "/", "" );
vr = vr.replace( "/", "" );
var tam = vr.length;

if (tam < tammax) { tam = vr.length + 1; }
if (codigo == 8) { tam = tam - 1; }

tam = tam - 1;
if ( (tam >= 2) && (tam < 3) ) {
vr = vr.substr( 0, tam - 0 ) + '/' + vr.substr( tam - 0, 2 ); }
if ( (tam >= 3) && (tam < 4) ) {
vr = vr.substr( 0, tam - 1 ) + '/' + vr.substr( tam - 1, 2 ); }
if (tam == 4) {
vr = vr.substr( 0, tam - 2 ) + '/' + vr.substr( tam - 2, 2 ) + '/' + vr.substr( tam - 0, 5 ); }
if (tam == 5) {
vr = vr.substr( 0, tam - 3 ) + '/' + vr.substr( tam - 3, 2 ) + '/' + vr.substr( tam - 1, 6 ); }
if (tam == 6) {
vr = vr.substr( 0, tam - 4 ) + '/' + vr.substr( tam - 4, 2 ) + '/' + vr.substr( tam - 2, 7 ); }
if (tam == 7) {
vr = vr.substr( 0, tam - 5 ) + '/' + vr.substr( tam - 5, 2 ) + '/' + vr.substr( tam - 3, 8 ); }

campo.value = vr;
}



//-----> máscara hora:
function m_HORA(campo,tammax,tecla) {

if(typeof(tecla) == 'undefined')
var tecla = window.event;
var codigo = (tecla.which ? tecla.which : tecla.keyCode ? tecla.keyCode : tecla.charCode);

var vr = campo.value;
vr = vr.replace( ":", "" );
vr = vr.replace( ":", "" );
var tam = vr.length;

if (tam < tammax) { tam = vr.length + 1; }
if (codigo == 8) { tam = tam - 1; }

tam = tam - 1;
if ( (tam >= 2) && (tam < 3) ) {
vr = vr.substr( 0, tam - 0 ) + ':' + vr.substr( tam - 0, 2 ); }
if ( (tam >= 3) && (tam < 4) ) {
vr = vr.substr( 0, tam - 1 ) + ':' + vr.substr( tam - 1, 2 ); }
if (tam == 4) {
vr = vr.substr( 0, tam - 2 ) + ':' + vr.substr( tam - 2, 2 ) + ':' + vr.substr( tam - 0, 5 ); }
if (tam == 5) {
vr = vr.substr( 0, tam - 3 ) + ':' + vr.substr( tam - 3, 2 ) + ':' + vr.substr( tam - 1, 6 ); }

campo.value = vr;
}



//-----> máscara moeda:
//onKeydown="Formata(this,10,event,2);" 
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

function Formata(campo,tammax,teclapres,decimal) { 
	var tecla = teclapres.keyCode; 
	vr = Limpar(campo.value,"0123456789"); 
	tam = vr.length; 
	dec=decimal; 
	
	if (tam < tammax && tecla != 8){ 
	tam = vr.length + 1 ; 
	} 
	
	
	if (tecla == 8 ){ 
	tam = tam - 1 ; 
	} 
	
	
	    if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ) { 
	
	        if ( tam <= dec ){ 
	        campo.value = vr ; 
	        } 
	
	        if ( (tam > dec) && (tam <= 5) ){ 
	        campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec,tam ) ; 
	        } 
	        if ( (tam >= 6) && (tam <= 8) ){ 
	        campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3) + "," + vr.substr( tam - dec, tam ) ; 
	        } 
	        if ( (tam >= 9) && (tam <= 11) ){ 
	        campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
	        } 
	        if ( (tam >= 12) && (tam <= 14) ){ 
	        campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11,3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
	        } 
	        if ( (tam >= 15) && (tam <= 17) ){ 
	        campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14,3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." +	vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ; 
	        } 
	    } 

} 

