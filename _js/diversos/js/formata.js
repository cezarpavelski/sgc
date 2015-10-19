//Tratamento de números

function soNumero()

{

	if (event.shiftKey==0)

	{

		if ( (event.keyCode < 48 && event.keyCode != 8 && event.keyCode !=13 && event.keyCode != 46 && event.keyCode != 44) || event.keyCode > 57 && event.keyCode != 13 && event.keyCode != 46 && event.keyCode != 44)

		{ 		

			event.keyCode = 0;

			event.returnValue=false;			

		}

	} 

}



// Função para tratamento do formato de telefone (com 3 ou 4 números de prefixo)

function formataTelefone(obj)

{

	numero = _extraiNumero(obj.value)

	if (numero.length >= 10) {

		formataCampo(obj, "(XX)XXXX-XXXX")

	} else if (numero.length == 9) {

		formataCampo(obj, "(XX)XXX-XXXX")

	} else if (numero.length == 8) {

		formataCampo(obj, "XXXX-XXXX")

	} else if (numero.length > 4) {

		formataCampo(obj, "XXX-XXXX")

	} else {

		if (obj.value != numero)

		{

			obj.value = numero

		}

	}

}



function mascaraCep(objeto)

{

   if (objeto.value.indexOf("-") == -1 && objeto.value.length > 5){ objeto.value = ""; }

   if (objeto.value.length == 5){

   objeto.value += "-";

  }

 }



// Função para tratamento do formato de cep

function formataCep(obj)

{

	numero = _extraiNumero(obj.value)

	if (numero.length > 3) {

		formataCampo(obj, "XXXXX-XXX")

	} else {

		if (obj.value != numero)

		{

			obj.value = numero

		}

	}

}



// Função para tratamento do formato de cpf

function formataCpf(obj)

{

	numero = _extraiNumero(obj.value)

	if (numero.length > 3) {

		formataCampo(obj, "XXX.XXX.XXX-XX")

	} else {

		if (obj.value != numero)

		{

			obj.value = numero

		}

	}

}



// Função para tratamento do formato de ra

function formataRA(obj)

{

	numero = _extraiNumero(obj.value)

	if (numero.length > 6) {

		formataCampo(obj, "XXXXXX-X")

	} else {

		if (obj.value != numero)

		{

			obj.value = numero

		}

	}

}



function formataCampo(obj, mascara)

{

	var valor = ''

	var tamValor = 0

	var tamMascara = 0

	var resultado = ''

	var aux1 = ''

	var aux2 = ''

	var posMas = 1

	var posVal = 1

	var tecla = obj.value.substr( obj.value.length - 1, 1)

	var masclen = mascara.length



	if(obj.value.length > mascara.length)

	{

		valor = _extraiNumero(obj.value.substring(0, obj.value.length-(obj.value.length-mascara.length)))

	} else {

		valor = _extraiNumero(obj.value)

	}



	//muda formatação somente quando receber uma tecla válida 

	if( !_teclaValida(tecla) && (obj.value != ''))

	{

		tamValor = valor.length

		tamMascara = mascara.length

		while((posVal <= tamValor) && (posMas <= tamMascara))

		{

			// percorre caracter por caracter no valor dado (do fim p/ começo)

			aux1 = valor.substring(tamValor - posVal, (tamValor - posVal) + 1)

			// percorre caracter por caracter na máscara (do fim p/ começo)

			aux2 = mascara.substring(tamMascara - posMas, (tamMascara - posMas) + 1)

			if(aux2 == 'X')

			{

				resultado = aux1 + resultado

				posVal = posVal + 1

			}else if((aux2 == '-') || (aux2 == '/') || (aux2 == '.' ) || (aux2 == '(') || (aux2 == ')') || (aux2 == ',')) // símbolos presentes nas máscaras

			{

				resultado = aux2 + resultado

			}

			posMas = posMas + 1

		}

		//  colocando "posMas" e "posVal" em suas posições atuais

		posVal = posVal - 1

		posMas = posMas - 1

		// caso especial para número de telefone (máscara começa com símbolo)

		if((posMas == tamMascara - 1) && (mascara.substring(0, 1) == '('))

		{

			resultado = '(' + resultado

		}

		

		if (obj.value != resultado)

		{

			if ( (resultado.length>=obj.maxLength) && (masclen>=resultado.length) )

			{

				if (masclen == resultado.length)

				{

					obj.maxLength = masclen

				} else{

					obj.maxLength = resultado.length+1

				}

			}

			obj.value = resultado

		}

		

	}

}



// Retorna true quando for um número

function _somenteNumero(numero)

{

	// numeros aceitos 0,1,2,3,4,5,6,7,8,9,37,38,39,40,46

	ER=/(^[0-2]$|^3[789]{0,1}$|^4[06]{0,1}$|^[5-9]$)/

	return ER.test(numero)

}



//  teclas que podem ser pressionadas

function _teclaValida(tecla)

{

	// 8  backspace			9  Tab				33 PageUp				34 PageDown	

	// 35 End				36 Home 			37 seta para esquerda	38 seta para cima 

	// 39 seta para direita 40 seta para baixo	46 Delete

	ER=/(^[8-9]$|^3[3-9]{1}$|^4[06]{1}$)/

	return ER.test(numero)

}



// retorna somente números [0..9]

function _extraiNumero(dado)

{

	var aux = ''

	for(n=0; n < dado.length; n++){

		if(_somenteNumero(dado.substr(n,1))){

			aux += dado.substr(n,1)

		}

	}

	return aux

}



// Validação de e-mail

function validaEmail(obj, alerta)

{

	var str = obj.value;



	// @ deve estar pelo menos na posição 1 de str,

	// deve estar pelo menos na posição 3 de str e não pde pode estar na última posição de str.

	if(str.length>0 && (str.indexOf('@') < 1 || str.indexOf('.') < 3 || (str.length < 5) || (str.substr(str.length-1, 1) == '.')))

	{

		// exibe mensagem ao usuário.

		if(alerta)

		{

			alert('E-mail inválido: ' + str);

			obj.value=''			

		}

		if(obj != null)

		{

			obj.focus();

		}

		return false;

	} else {

		return true;

	}

}







function mascara_data(param)

{

        var mydata = '';

        mydata = mydata + param.value;

        if (mydata.length == 2){

                mydata = mydata + '/';

                param.value = mydata;

        }

        if (mydata.length == 5){

                mydata = mydata + '/';

                param.value = mydata;

        }

        if (mydata.length == 10){

                verifica_data(param);

        }

}



function verifica_data (param)

{

	dia = (param.value.substring(0,2));

	mes = (param.value.substring(3,5));

	ano = (param.value.substring(6,10));



	situacao = "";

	// verifica o dia valido para cada mes

	if ((dia < 01)||(dia < 01 || dia > 30) && (  mes == 04 || mes == 06 || mes == 09 || mes == 11 ) || dia > 31) {

		situacao = "falsa";

	}



	// verifica se o mes e valido

	if (mes < 01 || mes > 12 ) {

		situacao = "falsa";

	}



	// verifica se e ano bissexto

	if (mes == 2 && ( dia < 01 || dia > 29 || ( dia > 28 && (parseInt(ano / 4) != ano / 4)))) {

		situacao = "falsa";

	}



	// verifica se e ano esta correto

	if (situacao == "" && ano.length != 4)

	{

		situacao = "falsa"

	}

	

	if (param.value.length < 10)

	{

		situacao = "falsa";

	}

	

	if (situacao == "falsa")

	{

		if (param.value != "")

		{

			alert("Data inválida!");

			param.value="";

			param.focus();

		}

	}

}



// Valida CPF

function validaCPF(obj, str, alerta)

{

	var numero;

	var digito = new Array(10); // array para os dígitos do CPF.

	var aux    = 0;             // índice para a string num.

	var posicao

	var i

	var soma

	var dv

	var dvInformado;



	if(obj != null)

	{

		str = obj.value;

	}



	numero = _extraiNumero(str);



	// Retira os dígitos formatadores de CPF '.' e '-', caso existam.

	if (str.length > 0)

	{

		while ((str.indexOf('.') != -1) || (str.indexOf('-') != -1))

		{

		  if (str.indexOf('.') != -1)

			 {

			  aux = str.indexOf('.');

				str = str.substr(0, aux) + str.substr(aux+1, str.length-1);

			}

			 if (str.indexOf('-') != -1)

			  {

				 aux = str.indexOf('-');

				 str = str.substr(0, aux) + str.substr(aux+1, str.length-1);

		  }

		 } //while

	} //if



	//verifica CPFs manjados

	switch (str) {

		case '0':

		case '00':

		case '000':

		case '0000':

		case '00000':

		case '000000':

		case '0000000':

		case '00000000':

		case '000000000':

		case '0000000000':

		case '00000000000':

		case '11111111111':

		case '22222222222':

		case '33333333333':

		case '44444444444':

		case '55555555555':

		case '66666666666':

		case '77777777777':

		case '88888888888':

		case '99999999999':

			obj.value = '';

			document.getElementById('alert_cpf').style.display='';

			obj.focus();

			return false;

	}



	// Início da validação do CPF.

	/* Retira do número informado os dois últimos dígitos */

	dvInformado = str.substr(9,2); 

	/* Desmembra o número do CPF no array digito */

	for (i=0; i<=8; i++)

	{

		digito[i] = str.substr(i,1);

	}

	/* Calcula o valor do 10o. digito de verificação */

	posicao = 10;

	soma = 0;

	for (i=0; i<=8; i++)

	{

		soma = soma + digito[i] * posicao;

		posicao--;

	}

	digito[9] = soma % 11;

	if (digito[9] < 2)

	{

		digito[9] = 0; 

	}

	else

	{

		digito[9] = 11 - digito[9];

	}

	/* Calcula o valor do 11o. digito de verificação */

	posicao = 11;

	soma = 0;

	for (i=0; i<=9; i++)

	{

		soma = soma + digito[i] * posicao;

		posicao--;

	}

	digito[10] = soma % 11;

	if (digito[10] < 2)

	{

		digito[10] = 0; 

	}

	else

	{

		digito[10] = 11 - digito[10];

	}

	dv = digito[9] * 10 + digito[10];

	/* Verifica se o DV calculado é igual ao informado */

	if(dv != dvInformado) 

	{

		// exibe mensagem ao usuário.

		if(alerta)

		{

			obj.value = '';

			

			document.getElementById('alert_cpf').style.display='';

		}

		if(obj != null)

		{

			obj.focus();

		}

		return false;

	}

	else

	{

		document.getElementById('alert_cpf').style.display='none';

		return true;

	}

}

function FormataCNPJ(Campo, teclapres){

	var tecla = teclapres.keyCode;

	var vr = new String(Campo.value);
	vr = vr.replace(".", "");
	vr = vr.replace(".", "");
	vr = vr.replace("/", "");
	vr = vr.replace("-", "");

	tam = vr.length + 1 ;

	
	if (tecla != 9 && tecla != 8){
		if (tam > 2 && tam < 6)
			Campo.value = vr.substr(0, 2) + '.' + vr.substr(2, tam);
		if (tam >= 6 && tam < 9)
			Campo.value = vr.substr(0,2) + '.' + vr.substr(2,3) + '.' + vr.substr(5,tam-5);
		if (tam >= 9 && tam < 13)
			Campo.value = vr.substr(0,2) + '.' + vr.substr(2,3) + '.' + vr.substr(5,3) + '/' + vr.substr(8,tam-8);
		if (tam >= 13 && tam < 15)
			Campo.value = vr.substr(0,2) + '.' + vr.substr(2,3) + '.' + vr.substr(5,3) + '/' + vr.substr(8,4)+ '-' + vr.substr(12,tam-12);
		}
}


function habilita()

	{

		var frm = document.form_nutri;

		frm.curso1.disabled=false

		frm.curso2.disabled=false

		frm.curso3.disabled=false

		frm.curso4.disabled=false

		

	}

	

	function desabilita()

	{

		var frm = document.form_nutri;

		frm.curso1.disabled=true

		frm.curso2.disabled=true

		frm.curso3.disabled=true

		frm.curso4.disabled=true

		

	}

	

	function valida_check(param)

	{

		var frm = document.form_nutri;

		frm.qtd_curso_selecionados.value=""

		frm.qtd_curso.value=""

		if (param.checked==true && param.id == "op2")

		{

			frm.qtd_curso.value='1'

		}

		

		if (param.checked==true && param.id == "op3")

		{

			frm.qtd_curso.value='2'

		}

		

		if (param.checked==true && param.id == "op4")

		{

			frm.qtd_curso.value='3'

		}

		

	}

	

	function valida_cursos(param)

	{

		var frm = document.form_nutri;

		var i=frm.qtd_curso_selecionados.value

		if (param.checked==true)

		{

			i++

			frm.qtd_curso_selecionados.value = i

		} else {

			i--

			frm.qtd_curso_selecionados.value = i

		}

		

		if (frm.qtd_curso_selecionados.value == frm.qtd_curso.value)

		{

			alert("Todos os Cursos Selecionados!!")

			if (frm.curso1.checked==false){

				frm.curso1.disabled=true

			} 

			if (frm.curso2.checked==false){

				frm.curso2.disabled=true

			} 

			if (frm.curso3.checked==false){

				frm.curso3.disabled=true

			} 

			if (frm.curso4.checked==false){

				frm.curso4.disabled=true

			} 

		

		} else {

			if (frm.curso1.checked==false){

				frm.curso1.disabled=false

			} 

			if (frm.curso2.checked==false){

				frm.curso2.disabled=false

			} 

			if (frm.curso3.checked==false){

				frm.curso3.disabled=false

			} 

			if (frm.curso4.checked==false){

				frm.curso4.disabled=false

			} 

		}

		

	}	

	function fc_limpa2()

	{

		var frm = document.form_nutri;

		

		frm.curso1.checked=false

		frm.curso2.checked=false

		frm.curso3.checked=false

		frm.curso4.checked=false

		

			

	}			