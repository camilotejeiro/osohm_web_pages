<?php
/***********************************************************************
 * User membership library
 * @author Camilo Tejeiro   ,=,e 
 **********************************************************************/
    
    /**
     * Register User
     * Here we are simply connecting to our database, checking if the 
     * user already exists, otherwise insert the registration info into 
     * the db.
     * @param string $user_name Username typed by the user.
     * @param string $user_email User e-mail typed by the user.
     * @param string $user_password User password typed by the user.
     * @return integer The function result code (for error handling)
     **/    
    function register_user($user_name, $user_email, $user_password)
    {
        $mysql_query = "";
        $query_result = SUCCESS_NO_ERROR;
        
        // connect to our database
        $database_connection = mysql_db_connect();
        
        if ($database_connection == FALSE)
            return REGISTER_DB_CANT_CONNECT;
        
        // check if our username is unique.
        $mysql_query = "select * from users where user_name='".$user_name."'";
        $query_result = $database_connection->query($mysql_query);
        
        if ($query_result == FALSE)
            return REGISTER_DB_QUERY_ERROR;
        elseif ($query_result->num_rows > 0)
            return REGISTER_DB_USER_EXISTS;
        else
        {
            // now we can insert the user into our database.
            $mysql_query = "insert into users values ('".$user_name."', sha1('".$user_password."'), '".$user_email."')"; 
            $query_result = $database_connection->query($mysql_query);
            
            if ($query_result == FALSE)
                return REGISTER_DB_INS_USER_ERROR;
            else
                return SUCCESS_NO_ERROR;
        }
    } 

    /**
     * Login User
     * Here we are connecting to our database, checking if username and 
     * passwords exist and setting up a session variable for our user.
     * @param string $user_name Username typed by the user.
     * @param string $user_password User password typed by the user.
     * @return integer The function result code (for error handling)
     **/     
    function login_user($user_name, $user_password)
    {
        $mysql_query = "";
        $query_result = SUCCESS_NO_ERROR;
        
        // connect to our database
        $database_connection = mysql_db_connect();
        
        if ($database_connection == FALSE)
            return LOGIN_DB_CANT_CONNECT;
        
        // check if our username and password exist.
        $mysql_query = "select * from users where user_name='".$user_name."' 
            and user_password=sha1('".$user_password."')";
        $query_result = $database_connection->query($mysql_query);
        
        if ($query_result == FALSE)
            return LOGIN_DB_QUERY_ERROR;
        elseif ($query_result->num_rows <= 0) // less-than is unnecessary(but this is client code).
            return LOGIN_DB_INVALID_USER_PASSWORD;
        else
        {
            // the user and password match to what we have in the db.
            // update the session.
            $_SESSION['validated_user'] = $user_name;
            return SUCCESS_NO_ERROR;
        }
    }

    /**
     * Log Out User
     * Unsetting the user session variable and destroying the session.
     * @return integer The function result code (for error handling)
     **/     
    function logout_user()
    {
        // unset the session variable.
        unset($_SESSION['validated_user']);
        
        // destroy the user session.
        if (session_destroy() != TRUE)
            return LOGOUT_ERROR;
        else
            return SUCCESS_NO_ERROR;
    }  

    /**
     * Check Login Session
     * Checking if the appropriate session variable is set.
     * @return integer The function result code (for error handling)
     **/    
    function check_login_session()
    {
        // see if people are already logged in, notify them if they are.
        if (isset($_SESSION['validated_user']) == FALSE)
            return CHECK_SESSION_NO_USER;
        else
            return SUCCESS_NO_ERROR;
    }
    
    /**
     * Reset Password
     * For resetting our password we are generating a random password, 
     * updating our database user entry with the random password and 
     * emailing the random password to the user.
     * @param string $user_name Username typed by the user.
     * @return integer The function result code (for error handling)
     **/
    function reset_password($user_name)
    {
        $mysql_query = "";
        $query_result = SUCCESS_NO_ERROR;
        
        $random_password = generate_random_password(8);
        
        // connect to our database
        // connect to our database
        $database_connection = mysql_db_connect();
        
        if ($database_connection == FALSE)
            return RESET_PWD_DB_CANT_CONNECT;
            
        // update db password, this query always return "true"
        // e.g. query ok, rows changes 0. So we will check later on.
        $mysql_query = "update users set user_password=sha1('".$random_password."') 
                        where user_name='".$user_name."'"; 
        $query_result = $database_connection->query($mysql_query);

        if ($query_result == FALSE)
            return RESET_PWD_DB_CANT_UPDATE;
        
        // gather respective user e-mail
        $mysql_query = "select user_email from users where user_name='".$user_name."'"; 
        $query_result = $database_connection->query($mysql_query);        
        
        if ($query_result == FALSE)
            return RESET_PWD_DB_EMPTY_EMAIL;
        elseif ($query_result->num_rows <= 0)
            return RESET_PWD_DB_INVALID_USER;
        else 
        {
            $row = $query_result->fetch_object();
            
            $to = $row->user_email;
            $subject = "cat login information";
            $message = "Your cat password has been changed to ".$random_password." \r\n"
                        ."please change it next time you log in";
            $from = "From: support@cat.com \r\n";
                    
            if (mail($to, $subject, $message, $from) == FALSE)
                return RESET_PWD_MAIL_ERROR;
            else
                return SUCCESS_NO_ERROR;
                
        }
    
    } 

    /**
     * Change Password
     * Connect to the database, check that the username and password 
     * combination is correct, finally update the password field to 
     * the new user chosen password.
     * @param string $user_name Username typed by the user.
     * @param string $old_password Old password in the database.
     * @param string $new_password New password chosen by the user.
     * @return integer The function result code (for error handling)
     **/  
    function change_password($user_name, $old_password, $new_password)
    {
        $mysql_query = "";
        $query_result = SUCCESS_NO_ERROR;
        
        // connect to our database
        $database_connection = mysql_db_connect();
 
        if ($database_connection == FALSE)
            return CHANGE_PWD_DB_CANT_CONNECT;        
        
        // check if our username and password exist.
        $mysql_query = "select * from users where user_name='".$user_name."' 
            and user_password=sha1('".$old_password."')";
        $query_result = $database_connection->query($mysql_query);
        
        if ($query_result == FALSE)
            return CHANGE_PWD_DB_QUERY_ERROR;
        elseif ($query_result->num_rows <= 0) // less-than is unnecessary(but this is client code).
            return CHANGE_PWD_DB_INVALID_PASSWORD;
        else
        {
            // ok, we validated user credentials, proceed to update their 
            // password.

            $mysql_query = "update users set user_password=sha1('".$new_password."') 
                            where user_name='".$user_name."'"; 
            $query_result = $database_connection->query($mysql_query);
            
            if ($query_result == FALSE)
                return CHANGE_PWD_DB_CANT_UPDATE;
            else
                return SUCCESS_NO_ERROR;
        }                       
    }    

    /**
     * Generate Random Password
     * To create a random password we are using the php open ssl random 
     * pseudo bytes generator, then converting the bytes to characters.
     * @param integer $half_length Half length of our desired password.
     * @return integer The function result code (for error handling)
     **/      
    function generate_random_password($half_length)
    {
        // using the php.net pseudo random generator, it will output a random 
        // string with twice the lenght provided.
        $bytes = openssl_random_pseudo_bytes($half_length);
        
        // converts the bytes to its respective characters
        $random_password = bin2hex($bytes);
        
        return $random_password;
    }
         
?>
