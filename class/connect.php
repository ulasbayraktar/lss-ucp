<?php
	if(!defined('INCONAY')) die();

	class dbConn
	{
		private $host = "localhost";
		private $user = "root";
		private $pass = "";
		private $dbnm = "lsrpe";

		public function connect()
		{
			$dsn = "mysql:host=".$this->host.";dbname=".$this->dbnm.";charset=utf8";
			$db = new PDO($dsn, $this->user, $this->pass);
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			return $db;
		}
	}
 ?>
