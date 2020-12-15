<?php 

		define('DB_NAME','laptopphongvu');
		define('DB_USER','root');
		define('DB_PASSWORD','abcdef1234');
		define('DB_HOST','localhost');
		
	class DbConnect{

		private $con; 
		

		function connect(){
			$this->con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

			if(mysqli_connect_errno()){
				echo "Failed to connect with database"; 
			}

			return $this->con; 
		}
	}
	
?>