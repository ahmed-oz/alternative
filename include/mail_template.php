<?php

define('SITE_URL_MAIL'  ,  'http://'.$_SERVER['HTTP_HOST']);  

function text2mail_template ($text){
		
	$out = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width"/>
	</head>
	<body style="width:100%; font-family: Helvetica, Arial, sans-serif; margin: 0;">
		
		<table style="width:700px; margin: 0 auto;" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td style="">
					<a href="'.SITE_URL_MAIL.'" target="_blank"><img width="200" style="vertical-align: middle; margin: 10px;" src="'.SITE_URL_MAIL.'/images/alternativa-logo-header.png" alt="Logo app.alternativa.it" /></a>
				</td>
	
			</tr>
		</table><table border="0" style="width:700px; margin: 0 auto;">
			<tr>
				<td class="center" align="center" valign="top">
					<center style="width: 700px; margin: 0 auto;">
					  <table style="width: 100%; margin: 0px 0 10px 0;" border="0">
						<tr>
						  <td style="border: 1px solid #c5d52b; background-color: #f2f2f2;  padding: 15px !important; font-size: 13px;">
								   '.$text.'
						  </td>
						</tr>
					  </table>
	
					  <table style="margin: 5px 0;" border="0">
						<tr>
						  <td align="center">
							<p style="text-align:center; font-size: 10px">Copyright Alternativa 2013. Tutti i diritti riservati.</p>
						  </td>
						</tr>
					  </table>
					</center>
				</td>
			</tr>
		</table>
	</body>
	</html>';
	
	return($out);
	
}


?>