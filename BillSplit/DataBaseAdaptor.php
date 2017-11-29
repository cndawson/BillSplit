 <?php
	// Author: Caylie Dawson
	// THISS IS JUST CODE FROM LAST PROJECT NOTHING HAS BEEN CHANGED
	class DataBaseAdapter {
		// The instance variable used in every one of the functions in class DatbaseAdaptor
		private $DB;
		// Make a connection to an existing data based named 'imdb_small' that has
		// table . In this assignment you will also need a new table named 'users'
		public function __construct() {
			$db = 'mysql:dbname=quotes;host=127.0.0.1;charset=utf8';
			$user = 'root';
			$password = '';
			
			try {
				$this->DB = new PDO ( $db, $user, $password );
				$this->DB->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			} catch ( PDOException $e ) {
				echo ('Error establishing Connection');
				exit ();
			}
		}
		public function getQuotesAsArray() {
			$stmt = $this->DB->prepare ( "SELECT quote, author, rating, flagged FROM quotations" );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		}
		public function addToQuotes($quote, $author) {
			print_r($quote, $author);
			$stmt = $this->DB->prepare( "insert into group (groupName, description, amount, user) VALUES (now(), '" . $groupName . "', '" . $description . "', '" . $amount . "', '" . $user . "')" );
			//$stmt = $this->DB->prepare( "insert into quotations (added, quote, author, rating, flagged) VALUES (now(), 'Rainbow Connection2', 'Kermit2', 0, 0)" );
			$stmt->execute ();
			return;
			//$stmt->fetchAll ( PDO::FETCH_ASSOC );
		}
		
		public function getHashForUser($user) {
			$stmt = $this->DB->prepare ( "SELECT hash FROM users where username= '" . $user . "'" );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		}
		
		public function logIN($user, $pswd) {
			$databaseHash = $this->getHashForUser($user);
			print_r($databaseHash);
			// echo "****" . $databaseHash[0] . PHP_EOL;
			// echo password_verify($pswd, $stmt) . PHP_EOL;
			//echo ($stmt);
			if (sizeof($databaseHash) != 0) {
				$dhash = $databaseHash[0]["hash"];
			 // echo "***>" .  password_verify($pswd, $dhash) . PHP_EOL;
				return password_verify($pswd, $dhash);
			}
			else  // user not found
				return FALSE;
			//return;
		}
		public function addToUsers($user, $pswd) {
			$databaseHash = $this->getHashForUser($user);
			//print_r($databaseHash);
			//echo " Array size = " . sizeof($databaseHash). PHP_EOL;
			if (sizeof($databaseHash) == 0) {
					
				$hash = password_hash($pswd, PASSWORD_DEFAULT);
				echo password_verify($pswd, $hash) . PHP_EOL;
				$stmt = $this->DB->prepare ( "Insert into users (username, hash) VALUES ('" . $user . "', '" . $hash . "')" );
				$stmt->execute ();
			  	return TRUE;
			}
			return FALSE;
		}


	} // End class DatabaseAdaptor
	  
	// Testing code that should not be run when a part of MVC
	$theDBA = new DatabaseAdapter ();
	 //$arr = $theDBA->addToQuotes ('test', 'author');
	//print_r($arr);
	
	?>