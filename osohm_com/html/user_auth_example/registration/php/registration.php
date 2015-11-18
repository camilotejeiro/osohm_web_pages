<?php
/***********************************************************************
 * Registration Functionality.
 **********************************************************************/
    
    function register_user($user_name, $user_email, $user_password)
    {
        $mysql_query = "";
        // connect to our database
        $database_connection = mysql_db_connect();
        
        if ($database_connection == FALSE)
            return REGISTER_CANT_CONNECT;
        
        // check if our username is unique.
        $mysql_query = "select * from users where user_name='".$user_name."'";
        $query_result = $database_connection->query($mysql_query);
        
        if ($query_result == FALSE)
            return REGISTER_SEL_QUERY_ERROR;
        elseif ($query_result->num_rows > 0)
            return REGISTER_USER_EXISTS;
        else
        {
            // now we can insert the user into our database.
            $mysql_query = "insert into users values ('".$user_name."', sha1('".$user_password."'), '".$user_email."')"; 
            $query_result = $database_connection->query($mysql_query);
            
            if ($query_result == FALSE)
                return REGISTER_INS_QUERY_ERROR;
            else
                return SUCCESS_NO_ERROR;
        }
    }    
?>
