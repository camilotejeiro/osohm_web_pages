<?php
/***********************************************************************
 * MySQL Database Library
 * @author Camilo Tejeiro   ,=,e 
 **********************************************************************/

    /**
     * MySQL Database Connect
     * Connect to our example mySql db with our credentials.
     * @return integer  the function result code.
     **/
    function mysql_db_connect()
    {
        $connection_result = new mysqli('localhost', 'osohm_user', 'osohm_user0615@mySql', 'osohm_example_db');
        
        return $connection_result;
    }
    
?>
