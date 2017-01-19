<?php
 	require_once("Rest.inc.php");
	
	class API extends REST {
	
		public $data = "";
		
		const DB_SERVER = "127.0.0.1";
		const DB_USER = "mario";
		const DB_PASSWORD = "1234";
		const DB = "characters-db";

		private $db = NULL;
		private $mysqli = NULL;
		public function __construct(){
                    parent::__construct();				
                    $this->dbConnect();				
		}
		
		/*
		 *  Connect to Database
		*/
		private function dbConnect(){
			$this->mysqli = new mysqli(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD, self::DB);
		}
		
		/*
		 * Dynmically call the method based on the query string
		 */
		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['x'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404); // If the method not exist with in this class "Page not found".
		}
		
                
                /**
                 * Encode array into JSON
                 * @param type $data
                 * @return type
                 */
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
                
		/**
                 * List of all characters
                 */
                private function characters(){	
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
                        $query="SELECT * FROM recursos";
                        $r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				$result = array();
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				$this->response($this->json($result), 200); // send character details
			}
			$this->response('',204);	// If no records "No Content" status
		}

		/**
                 * INSERT A NEW CHARACTER
                 */
		private function insertCharacter(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}

			$character = json_decode(file_get_contents("php://input"),true);
			
                        // Columns of data base
                        $column_names = array('nombre', 'descripcion', 'imagen');
			$keys = array_keys($character);
			$columns = '';
			$values = '';
			foreach($column_names as $desired_key){ // Check the character received. If blank insert blank into the array.
			   if(!in_array($desired_key, $keys)) {
			   		$$desired_key = '';
				}else{
					$$desired_key = $character[$desired_key];
				}
				$columns = $columns.$desired_key.',';
				$values = $values."'".$$desired_key."',";
			}
			$query = "INSERT INTO recursos(".trim($columns,',').") VALUES(".trim($values,',').")";
			if(!empty($character)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Personaje creado correctamente", "data" => $character);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	//"No Content" status
		}
		
	
	}
	
	// Initiiate Library
	$api = new API;
	$api->processApi();
?>
