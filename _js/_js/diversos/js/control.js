   var padding = "0";
           
   function clearText(ctrl_name) {                
       if(ctrl_name == 'nome') 
           if (document.form2.nomepalestra.value == "Seu nome")
                document.form2.nomepalestra.value = ""; 
           
       if(ctrl_name == 'email')
            if (document.form1.newsletter.value == "Seu e-mail")
                document.form1.newsletter.value = "";
                
	   if(ctrl_name == 'emailp')
	       if (document.form2.emailpalestra.value == "Seu e-mail")
	           document.form2.emailpalestra.value = "";
	         
   } 
   
   function resetText(ctrl_name) {
   
       if(ctrl_name == 'nome'){
           if(document.form2.nomepalestra.value.length == 0) 
               document.form2.nomepalestra.value = "Seu nome"; 
        }
           
       if(ctrl_name == 'email'){
            if(document.form1.newsletter.value.length == 0) 
               document.form1.newsletter.value = "Seu e-mail"; 
       }
       if(ctrl_name == 'emailp'){
           if(document.form2.emailpalestra.value.length == 0) 
              document.form2.emailpalestra.value = "Seu e-mail"; 
       }
      
   }