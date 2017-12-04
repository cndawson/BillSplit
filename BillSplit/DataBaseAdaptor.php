 <?php
	// Author: Caylie Dawson
	// THISS IS JUST CODE FROM LAST PROJECT NOTHING HAS BEEN CHANGED
	class DataBaseAdapter {
		// The instance variable used in every one of the functions in class DatbaseAdaptor
		private $DB;
		// Make a connection to an existing data based named 'imdb_small' that has
		// table . In this assignment you will also need a new table named 'users'
		public function __construct() {
			$db = 'mysql:dbname=BillSplit;host=127.0.0.1;charset=utf8';
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
		public function getPaymentsAsArray($group) {
			$stmt = $this->DB->prepare ( "SELECT username, description, amount, date FROM payments WHERE groupName= '" . $group ."'" );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		}
		
		public function getUsersInGroupAsArray($group, $user) {
			$stmt = $this->DB->prepare ( "SELECT username FROM users WHERE groupName= '" . $group ."' and username !='" . $user . "'" );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		}
		//-------------------------------------------------------------------------//
		/////////HAVE TO CHECK IF GROUPNAME IS ALREADY REGISTERED, SEARCH THROUGH THE USERS DATABASE AND SEE IF ANY OF THE GROUPS MATCH?//////////////////
		//-------------------------------------------------------------------------//

		public function addGroupToUser($groupName, $user) {
			$aux = $this->DB->prepare( "SELECT * FROM users where groupName='" . $groupName . "'" );
			$aux->execute ();
			$arr = $aux->fetchAll ( PDO::FETCH_ASSOC );
			if(count($arr)>0)
				return FALSE;
		}

		public function checkGroup ($groupName){
			$stmt = $this->DB->prepare("select * from users where groupName='" . $groupName . "'");
			$stmt->execute ();
			$aux = $stmt->fetchAll ( PDO::FETCH_ASSOC );
			if(count($aux)==0) 
				return FALSE;
			return TRUE;
		}
		
		public function getGroup ($user){
			$stmt = $this->DB->prepare("select groupName from users where username='" . $user . "'");
			$stmt->execute ();
			$aux = $stmt->fetchAll ( PDO::FETCH_ASSOC );
			if(count($aux)>0)
				return $aux[0]['groupName'];
			return FALSE;
		}
		
		public function joinGroup($groupName, $user) {

			$groupCheck = $this->checkGroup($groupName);
			if ($groupCheck) {
				$stmt = $this->DB->prepare( "UPDATE users set groupName='" . $groupName . "' where username='" . $user . "'" );
				$stmt->execute ();
				return TRUE;
			}
			return FALSE;
		}
		
		public function registerGroup($groupName, $user) {
			$groupCheck = $this->checkGroup($groupName);
			if (!$groupCheck){
				$stmt = $this->DB->prepare( "UPDATE users set groupName='" . $groupName . "' where username='" . $user . "'" );
				$stmt->execute ();
				return TRUE;
			}
			return FALSE;
		}
		
		public function addPayment($user, $groupName, $description, $amount) {
			$stmt = $this->DB->prepare( "insert into payments (username, groupName, description, amount) VALUES ('" . $user . "', '" . $groupName . "', '" . $description . "', '" . $amount . "', CURRENT_TIMESTAMP())" );
			//$stmt = $this->DB->prepare( "insert into quotations (added, quote, author, rating, flagged) VALUES (now(), 'Rainbow Connection2', 'Kermit2', 0, 0)" );
			$stmt->execute ();
			return;
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
				$stmt = $this->DB->prepare ( "Insert into users (username, hash, payed, owed, groupName) VALUES ('" . $user . "', '" . $hash . "', 0.0, 0.0, '')" );
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