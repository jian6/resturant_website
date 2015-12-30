<?php

class WebsiteUser{
    /* Host address for the database */
    protected static $DB_HOST = "127.0.0.1";
    /* Database username */
    protected static $DB_USERNAME = "wp_eatery";
    /* Database password */
    protected static $DB_PASSWORD = "password";
    /* Name of database */
    protected static $DB_DATABASE = "wp_eatery";
    
    private $username;
    private $password;
	private $lastlogin;
    private $mysqli;
    private $dbError;
    private $authenticated = false;
    
    function __construct() {
        $this->mysqli = new mysqli(self::$DB_HOST, self::$DB_USERNAME, 
                self::$DB_PASSWORD, self::$DB_DATABASE);
        if($this->mysqli->errno){
            $this->dbError = true;
        }else{
            $this->dbError = false;
        }
    }
    public function authenticate($username, $password){
        $loginQuery = "SELECT * FROM adminusers WHERE username = ? AND password = ?";
        $stmt = $this->mysqli->prepare($loginQuery);
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $this->username = $username;
            $this->password = $password;
            $this->authenticated = true;
        }
        $stmt->free_result();
    }
    public function isAuthenticated(){
        return $this->authenticated;
    }
    public function hasDbError(){
        return $this->dbError;
    }
    public function getUsername(){
        return $this->username;
    }
	
	public function lastLogin($username, $password, $lastlogin) {
		$loginQuery = "UPDATE adminusers SET lastlogin = ? WHERE username = ? AND password = ?";
        $stmt = $this->mysqli->prepare($loginQuery);
        $stmt->bind_param('sss', $lastlogin, $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
			$this->lastlogin = $lastlogin;
            $this->username = $username;
            $this->password = $password;
        }
        $stmt->free_result();
		
	}
	
	public function getInfo($username, $password){
        //The query method returns a mysqli_result object
        $query = "SELECT _id, lastlogin FROM adminusers WHERE username = ? AND password = ?";
		$stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
		$result = $stmt->get_result();
        $admins = Array();
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                array_push($admins, $row['_id']);
				array_push($admins, $row['lastlogin']);			
            }
            $result->free();
            return $admins;
        }
    }
}
?>
