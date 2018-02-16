<?php

class Cookie {

	private static $cookie_secret_key = '';

	public function __construct() {
		$this->setSecretKey('sav_user');
	}

	private function setSecretKey($key) {
		self::$cookie_secret_key = md5($key);
	}
	
	/* GESTIONE COOKIE 'remember me' */
	public function setLoginCookie($user) {
		// generate random token
		$token = md5(uniqid(mt_rand(), true)); //GenerateRandomToken(); // generate a token, should be 128 - 256 bit
		
		if($this->storeUserToken($user, $token)) {
			$cookie = $user . ':' . $token;
			$mac = hash_hmac('sha256', $cookie, self::$cookie_secret_key);
			$cookie .= ':' . $mac;
			
			//setcookie('sav_user', $cookie, time() + 60*60*24*7, "/", "app.alternativa-auto.it.arguo-stage.com");
			setcookie('sav_user', $cookie, time() + 60*60*24*7, "/");
		}
	}
	
	public function unsetLoginCookie($cookie_name) {
		setcookie($cookie_name, '', -1, '/');
		unset($_COOKIE[$cookie_name]);
	}

	private function storeUserToken($username, $token) {
		$sql = "INSERT INTO `secure_login`(`username`, `token`, `create_date`) VALUES ('" . mysql_real_escape_string($username) . "','" . mysql_real_escape_string($token) . "', NOW())";
		if(mysql_query($sql)) {
			return true;
		} else {
			return false;
		}
	}

	private function fetchUserToken($username) {
		$sql = "SELECT `token` FROM `secure_login` WHERE `username`='" . mysql_real_escape_string($username) . "' ORDER BY `create_date` DESC LIMIT 1;";
		$res = mysql_query($sql);
		return mysql_result($res, 0, 'token');
	}
	
	private function logUserIn($username) {
		$sql = "SELECT * FROM `concessionari` WHERE `login`='" . mysql_real_escape_string($username) . "' AND `id_status` >=1";
		$result=mysql_query($sql);
		
		if(mysql_num_rows($result)==1)
		{
			$_SESSION['login_utente'] = "ok"; 
			$_SESSION['id_utente_sessione'] = mysql_result($result,0,'id_concessionaria');
			$_SESSION['nome_concessionaria_sessione'] = mysql_result($result,0,'nome_concessionaria');
			$_SESSION['id_livello_sessione'] = mysql_result($result,0,'id_livello');
			return true;
		}
		return false;
	}

	public function rememberMe() {
		$cookie = isset($_COOKIE['sav_user']) ? $_COOKIE['sav_user'] : '';		//echo 'RMB_'.$cookie.'<br>';
		if ($cookie) {
			list ($username, $token, $mac) = explode(':', $cookie);
			if ($mac !== hash_hmac('sha256', $username . ':' . $token, self::$cookie_secret_key)) {
				return false;
			}
			$usertoken = $this->fetchUserToken($username); 			//var_dump( $username );echo "<br>";
			if ($this->timingSafeCompare($usertoken, $token)) {
				return $this->logUserIn($username);
			}
		}
		return false;
	}

	/**
	 * A timing safe equals comparison
	 *
	 * To prevent leaking length information, it is important
	 * that user input is always used as the second parameter.
	 *
	 * @param string $safe The internal (safe) value to be checked
	 * @param string $user The user submitted (unsafe) value
	 *
	 * @return boolean True if the two strings are identical.
	 */
	private function timingSafeCompare($safe, $user) {
		// Prevent issues if string length is 0
		$safe .= chr(0);
		$user .= chr(0);

		$safeLen = strlen($safe);
		$userLen = strlen($user);

		// Set the result to the difference between the lengths
		$result = $safeLen - $userLen;

		// Note that we ALWAYS iterate over the user-supplied length
		// This is to prevent leaking length information
		for ($i = 0; $i < $userLen; $i++) {
			// Using % here is a trick to prevent notices
			// It's safe, since if the lengths are different
			// $result is already non-0
			$result |= (ord($safe[$i % $safeLen]) ^ ord($user[$i]));
		}

		// They are only identical strings if $result is exactly 0...
		return $result === 0;
	}

}


?>