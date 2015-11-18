<?php
/***********************************************************************
 * MySQL Database connection functions.
 **********************************************************************/
    
    function mysql_db_connect()
    {
        $connection_result = new mysqli('localhost', 'osohm_user', 'osohm_user0615@mySql', 'osohm_example_db');
        
        return $connection_result;
    }
    
?>
