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


	static function init() {
		// Check if the config.php file exists
		if (file_exists("config.php")) {
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