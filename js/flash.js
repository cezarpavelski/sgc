function conteudo(swf,largura,altura,LocalId){
    STRFlash = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="'+largura+'" height="'+altura+'">'
    STRFlash += '<param name="movie" value="'+swf+'" />'
    STRFlash += '<param name="quality" value="high" />'
	STRFlash += '<PARAM NAME="menu" VALUE="false">'	
    STRFlash += '<param name="wmode" value="transparent" />'
    STRFlash += '<embed src="'+swf+'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'+largura+'" height="'+altura+'" wmode="transparent"></embed>'
    STRFlash += '</object>'
    document.getElementById(LocalId).innerHTML = STRFlash;
} 