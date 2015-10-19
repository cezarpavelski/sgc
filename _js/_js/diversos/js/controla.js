
$(document).ready(function() {
//========================================================================================
//	manda os dados da pesquisa
//========================================================================================
	
	$('#start_sobrenos').click(function(){
										
		$('#title_cartao').css({ display:"none"});
		$('#body_cartao').css({ display:"none"});
		
		$('#body_privacidade').css({ display:"none"});
		$('#title_privacidade').css({ display:"none"});
		
		$('#title_sobrenos').css({ display:""});		
		$('#body_sobrenos').css({ display:""});		
								
	});
	
	$('#start_privacidade').click(function(){
	
		$('#title_cartao').css({ display:"none"});
		$('#body_cartao').css({ display:"none"});
		
		$('#title_sobrenos').css({ display:"none"});
		$('#body_sobrenos').css({ display:"none"});
		
		$('#title_privacidade').css({ display:""});	
		$('#body_privacidade').css({ display:""});	
	
	});

	$('#start_cartao').click(function(){
		
		$('#title_sobrenos').css({ display:"none"});
		$('#body_sobrenos').css({ display:"none"});
		
		$('#title_privacidade').css({ display:"none"});
		$('#body_privacidade').css({ display:"none"});
		
		$('#title_cartao').css({ display:""});	
		$('#body_cartao').css({ display:""});	
		
	});
	
});