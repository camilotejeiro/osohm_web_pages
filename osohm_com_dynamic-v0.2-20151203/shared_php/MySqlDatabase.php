<?php
/***********************************************************************
* mySQL Database Class
* Class including library methods interface with our mySQL database. 
* e.g. for accessing, reading and modifying our osohm database securely. 
***********************************************************************/

    /*
     * Required Includes.
     */ 
    require_once('osohm_database_info.php');

    if(class_exists('MySqlDatabase') == FALSE)
    {
        class MySqlDatabase 
        {
            
            /***************************************************************
             * Osohm Database Class Constructor
             * PHP5 style constructor for compatibility with PHP5.
             * Connects to the database server and selects a database
             * Does the actual setting up of the connection to the database.
             **************************************************************/
            function __construct() 
            {
                $this->connect();
            }

            /***************************************************************
             * Osohm Database Class Legacy Constructor.
             * PHP4 compatibility layer for calling the PHP5 constructor.
             * Connects to the database server and selects a database.
             * @uses OsohmDatabase::__construct()
             **************************************************************/    
            function MySqlDatabase() 
            {
                return $this->__construct();
            }
        
            /***************************************************************
             * Connect 
             * Connect to and select database
             * @uses the constants defined in config.php
             **************************************************************/    
            function connect() 
            {
                $link = mysql_connect('localhost', DB_USER, DB_PASS);

                if ($link == FALSE) 
                {
                    die('Could not connect: ' . mysql_error());
                }

                $db_selected = mysql_select_db(DB_NAME, $link);

                if ($db_selected == FALSE) 
                {
                    die('Can\'t use ' . DB_NAME . ': ' . mysql_error());
                }
            }
            
            /***************************************************************
             * Clean 
             * Clean the array using mysql_real_escape_string function.
             * Cleans an array by array mapping mysql_real_escape_string
             * onto every item in the array.
             * @param array $array The array to be cleaned
             * @return array $array The cleaned array
             **************************************************************/
            function clean($array) 
            {
                return array_map('mysql_real_escape_string', $array);
            }
            
            /***************************************************************
             * Hash Password
             * Create a secure hash.
             * Creates a secure copy of the user password for storage
             * in the database.
             * @param string $password The user's created password
             * @param string $nonce A user-specific NONCE
             * @return string $secureHash The hashed password
             **************************************************************/
            function hash_password($password, $nonce) 
            {
              $secureHash = hash_hmac('sha512', $password . $nonce, SITE_KEY);
              
              return $secureHash;
            }
            
            /***************************************************************
             * Insert
             * Insert data into the database.
             * Does the actual insertion of data into the database.
             * @param string $table The name of the table to insert data into
             * @param array $fields An array of the fields to insert data into
             * @param array $values An array of the values to be inserted
             * @return boolean indicating whether the insert was succesful
             **************************************************************/
            function insert($table, $fields, $values) 
            {
                $fields = implode(", ", $fields);
                $values = implode("', '", $values);
                $sql="INSERT INTO $table (user_id, $fields) VALUES ('', '$values')";

                if (mysql_query($sql) == FALSE) 
                {
                    die('Error: ' . mysql_error());
                } 
                else 
                {
                    return TRUE;
                }
            }
            
            /***************************************************************
             * Select
             * Select data from the database
             * Grabs the requested data from the database.
             * @param string $sql the sql query command to send.
             * @retun boolean/resource $results the mysql query result.
             **************************************************************/
            function select($sql) 
            {
                $results = mysql_query($sql);
                
                return $results;
            }
        }
    }

    //Instantiate our database class
    $osohm_database = new MySqlDatabase;
?>
