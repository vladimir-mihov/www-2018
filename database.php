<?php
	class database {
		private $conn;
		static private $dbName = 'images';
		static private $dbUser = 'root';
		static private $dbPass = '';

		public function __construct() {
			$this->conn = new PDO( 'mysql:host=localhost;dbname=' . self::$dbName, self::$dbUser, self::$dbPass );
		}

		public function __destruct() {
			$this->conn = null;
		}

		public function query( $sql ) {
			return $this->conn->query( $sql );
		}

		public function prepare( $sql ) {
			return $this->conn->prepare( $sql );
		}
	}
?>
