<?php
	class database {
		private $conn;

		public function __construct() {
			$this->conn = new PDO( 'mysql:host=localhost;dbname=' . 'images', 'root', '' );
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
