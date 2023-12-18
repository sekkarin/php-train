<?php

class Config  
{	
	public $host;
	public $user;
	public $pass;
	public $db;
	function __construct() {
		$this->host = "localhost";
		$this->user  = "root";
		$this->pass = "";
		$this->db = "sport";
	}
}

?>