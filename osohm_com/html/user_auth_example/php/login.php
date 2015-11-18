<?php
/***********************************************************************
 * Login Functionality.
 **********************************************************************/
 
    function login_user($user_name, $user_password)
    {
        $mysql_query = "";
        
        // connect to our database
        $database_connection = mysql_db_connect();
        
        if ($database_connection == FALSE)
            return LOGIN_CANT_CONNECT;
        
        // check if our username is unique.
        $mysql_query = "select * from users where user_name='".$user_name."' 
            and user_password=sha1('".$user_password."')";
        $query_result = $database_connection->query($mysql_query);
        
        if ($query_result == FALSE)
            return LOGIN_SEL_QUERY_ERROR;
        elseif ($query_result->num_rows <= 0) // less-than is unnecessary(but this is client code).
            return LOGIN_INVALID_USER_PASSWORD;
        else
        {
            // the user and password match to what we have in the db.
            // update the session.
            $_SESSION['validated_user'] = $user_name;
            return SUCCESS_NO_ERROR;
        }
    }    
?>
