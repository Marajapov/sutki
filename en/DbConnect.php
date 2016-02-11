<?php

/**
 * Connecting / disconnecting Database
 *
 * @author Ravi Tamada
 */
 
class DbConnect {
    
    private $conn;

    // constructor
    function __construct() {
        
        // connecting to database
        $this->connect();
    }

    // destructor
    function __destruct() {
        // closing db connection
        $this->close();
    }

    /**
     * Establishing database connection
     * @return database handler
     */
    function connect() {        
        include_once dirname(__FILE__) . './Config.php';
        
        // Connecting to mysql database
        $this->conn = mysql_connect('50.62.209.110:3306', 'android_user', 'abakan123') or die(mysql_error());
		
        // Selecting database
        mysql_select_db('usena_android') or die(mysql_error());
        
        // returing connection resource
        return $this->conn;
    }

    /**
     * Closing database connection
     */
    function close() {
        // closing db connection
        mysql_close($this->conn);
    }

}

?>
