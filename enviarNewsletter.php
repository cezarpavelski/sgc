<?php 
		header("Content-Type: text/html; charset=iso-8859-1",true);		
		include_once 'configuracao.php';
		include_once 'model/DAO.class.php';
		$emailTeste=$_POST['emailTeste'];
		$assunto=$_POST['assunto'];
		$titulo=$_POST['titulo'];
		$baseEmail=$_POST['baseemail'];
		$descricao=htmlspecialchars_decode($_POST['descricao']);		

		$nome_usermail=$nomeDoRemetente;
		$login_usermail=$emailDoRemetente;
		$senha_usermail=$senhaDoEmail;
		$subject_usermail=$assunto;    
		 	
		$to_reposta=$emailDoRemetente;
		if($emailTeste){
			$to_mail[1]=$emailTeste;
			$to_nome[1]=$emailTeste;
		}else{
			$dao=new DAO();
			$baseEmail=explode(",",$baseEmail);
			foreach($baseEmail as $BE){
				$sql.="select email from ".$BE." union ";
			}
			$sql=substr($sql,0,-7);
			$emails=$dao->selectFree($sql);
			$i=1;
			foreach($emails as $e){
				$to_mail[$i]=$e[email];
				$to_nome[$i]=$e[email];
				$i++;
			}
		}    
		
		require("extra/phpmailer/class.phpmailer.php"); // ADICIONA O SCRIPT DE ENVIO DE E-MAILS
	
		$mail = new PHPMailer(); // INICIA A CLASSE PHPMAILER 
		$mail->IsSMTP(); //ESSA OPÇÃO HABILITA O ENVIO DE SMTP
		$mail->Host = $hostDoEmail; //SERVIDOR DE SMTP, USE smtp.SeuDominio.com OU smtp.hostsys.com.br
		$mail->SMTPAuth = true; //ATIVA O SMTP AUTENTICADO
		$mail->Username = "$login_usermail"; //EMAIL PARA SMTP AUTENTICADO (pode ser qualquer conta de email do seu domínio)
		$mail->Password = "$senha_usermail"; //SENHA DO EMAIL PARA SMTP AUTENTICADO 
		$mail->From = "$to_reposta"; //E-MAIL DO REMETENTE 
		$mail->FromName = "$nome_usermail"; //NOME DO REMETENTE
		$mail->AddAddress("$to_mail[1]","$to_nome[1]");
		
		if(count($to_mail)==1){
			$mens  =  $descricao;
			$mail->IsHTML(true); //ATIVA MENSAGEM NO FORMATO HTML
			$mail->Subject = "$subject_usermail"; //ASSUNTO DA MENSAGEM 
			$mail->WordWrap = 50; // ATIVAR QUEBRA DE LINHA
			$mail->Body = $mens;
			$enviou = $mail->Send();
		}else{
			for($i=2;$i<=count($to_mail);$i++){
				$mail->AddBCC("$to_mail[$i]","$to_nome[$i]"); //E-MAIL DO DESINATÁRIO, NOME DO DESINATÁRIO --> AS VARIÁVEIS ALI PODEM FAZER REFERÊNCIA A DADOS VINDO DE $_GET OU $_POST, OU AINDA DO BANCO DE DADOS    
				$mail->IsHTML(true); //ATIVA MENSAGEM NO FORMATO HTML
				$mail->Subject = "$subject_usermail"; //ASSUNTO DA MENSAGEM 
				$mail->WordWrap = 50; // ATIVAR QUEBRA DE LINHA
				$mens  =  $descricao;
				$mail->Body = $mens;
				$enviou = $mail->Send();
			}
		}
		
		if(!$enviou){
			if($emailTeste){
				$erro="Erro no envio do email!";
			}else{
				$erro="Erro no envio da newsletter!";
			}
			echo $erro;		
		}else{
			if($emailTeste){
				$conf="Email enviado com Sucesso!";
			}else{
				$conf="Newsletter enviada com Sucesso!";
			}
			echo $conf;		
		}
?>