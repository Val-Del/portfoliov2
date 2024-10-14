<?php
class Parametres
{
	private static $_host;
	private static $_port;
	private static $_dbname;
	private static $_login;
	private static $_pwd;

	static function getHost()
	{
		return self::$_host;
	}

	static function getPort()
	{
		return self::$_port;
	}

	static function getDbname()
	{
		return self::$_dbname;
	}

	static function getLogin()
	{
		return self::$_login;
	}

	static function getPwd()
	{
		return self::$_pwd;
	}


	// static function init()
	// {
	// 	if (file_exists("config.json")) {
	// 		$parametre  = json_decode(file_get_contents("config.json"));
	// 		self::$_host = $parametre->Host;
	// 		self::$_port = $parametre->Port;
	// 		self::$_dbname = $parametre->DbName;
	// 		self::$_login = $parametre->Login;
	// 		if (strlen($parametre->Pwd) == 0)
	// 			self::$_pwd = $parametre->Pwd; //developpement
	// 		else
	// 			self::$_pwd = $parametre->Pwd; //production
	// 	}
	// }
	static function init() {
		// Check if the config.php file exists
		if (file_exists("config.php")) {
			// Include the config.php file and store the returned array in $parametre
			include "config.php";
			// Access the configuration values
			self::$_host = $parameters['Host'];
			self::$_port = $parameters['Port'];
			self::$_dbname = $parameters['DbName'];
			self::$_login = $parameters['Login'];
			self::$_pwd = $parameters['Pwd'];
		}
	}
	

	

	
}