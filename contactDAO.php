<?php
require_once('./class/contactInfo.php');
//Used to throw mysqli_sql_exceptions for database
//errors instead or printing them to the screen.
mysqli_report(MYSQLI_REPORT_STRICT);
/**
 * Abstract data access class. Holds all of the database
 * connection information, and initializes a mysqli object
 * on instantiation.
 * 
 * @author Matt
 */
class contactDAO {
    protected $mysqli;
    
    /* Host address for the database */
    protected static $DB_HOST = "127.0.0.1";
    /* Database username */
    protected static $DB_USERNAME = "wp_eatery";
    /* Database password */
    protected static $DB_PASSWORD = "password";
    /* Name of database */
    protected static $DB_DATABASE = "wp_eatery";
    
    /*
     * Constructor. Instantiates a new MySQLi object.
     * Throws an exception if there is an issue connecting
     * to the database.
     */
    function __construct() {
        try{
            $this->mysqli = new mysqli(self::$DB_HOST, self::$DB_USERNAME, 
                self::$DB_PASSWORD, self::$DB_DATABASE);
        }catch(mysqli_sql_exception $e){
            throw $e;
        }
    }
    
    public function getMysqli(){
        return $this->mysqli;    
    }
	
	 /*this is to check if there is a duplicate email.
     * 
     */
    public function getContacts(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM mailinglist');
        $mailingList = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new contact object, and add it to the array.
                $contact = new ContactInfo($row['_id'], $row['customerName'], $row['phoneNumber'], $row['emailAddress'], $row['referrer']);
                $mailingList[] = $contact;
            }
            $result->free();
            return $mailingList;
        }
        $result->free();
        return false;
    }
    
    /*
     * This is an example of how to use a prepared statement
     * with a select query.
     */
    public function dupEmail($email){
        $query = 'SELECT * FROM mailinglist WHERE emailAddress = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            return true;
		}
		return false;
    }

    public function addContact($contact){
        if(!is_numeric($contact->getPhone())){
            return 'Phone must be a number.';
        }
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            $query = 'INSERT INTO mailinglist (customerName, phoneNumber, emailAddress, referrer) VALUES (?,?,?,?)';
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $stmt = $this->mysqli->prepare($query);
			echo $this->mysqli->error;
            //The first parameter of bind_param takes a string
            //describing the data. In this case, we are passing 
            //4 variables: an integer(phone), and 3
            //strings (name, email, refer).
            //
            //The string contains a one-letter datatype description
            //for each parameter. 'i' is used for integers, and 's'
            //is used for strings.
            $stmt->bind_param('siss',
                    $contact->getName(), 
                    $contact->getPhone(), 
                    password_hash($contact->getEmail(), PASSWORD_DEFAULT),
					$contact->getRefer());
            //Execute the statement
            $stmt->execute();
            //If there are errors, they will be in the error property of the
            //mysqli_stmt object.
            if($stmt->error){
                return $stmt->error;
            } else {
                return $contact->getName() . ' added successfully!';
            }
        } else {
            return 'Could not connect to Database.';
        }
    }
    
    
    
}

?>
