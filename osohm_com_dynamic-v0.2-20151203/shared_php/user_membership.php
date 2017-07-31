<?php
/***********************************************************************
* User Membership Class
* Class including library methods to handle everything associated with 
* our platform membership accounts. e.g. registration, login, check_login 
* and logout. 
***********************************************************************/
    
    /*
     * Required Includes 
     */
    require_once('MySqlDatabase.php');
    require_once('osohm_result_codes.php');    

    if(class_exists('UserMembership') == FALSE)
    {
        class UserMembership
        {
            
            function register() 
            {
                global $osohm_database;
            
                //Check to make sure the form submission is coming from our script
                //The full URL of our registration page
                $current = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

                //The full URL of the page the form was submitted from
                $referrer = $_SERVER['HTTP_REFERER'];

                /*
                 * Check to see if the $_POST array has data (i.e. our form was submitted) and if so,
                 * process the form data.
                 */
                if ( empty ( $_POST ) == TRUE ) 
                {
                    return REGISTRATION_EMPTY_DATA;
                }
                else 
                {

                    /* 
                     * Here we actually run the check to see if the form was submitted from our
                     * site. Since our registration from submits to itself, this is pretty easy. If
                     * the form submission didn't come from the register.php page on our server,
                     * we don't allow the data through.
                     */
                    if ( $referrer == $current ) 
                    {
                            
                        //Set up the variables we'll need to pass to our insert method
                        //This is the name of the table we want to insert data into
                        $table = 'users';
                        
                        //These are the fields in that table that we want to insert data into
                        $fields = array('user_name', 'user_login', 'user_password', 'user_email', 'user_register_timestamp');
                        
                        //These are the values from our registration form... cleaned using our clean method
                        $values = $osohm_database->clean($_POST);
                        
                        //Now, we're breaking apart our $_POST array, so we can store our password securely
                        $username = $_POST['name'];
                        $userlogin = $_POST['username'];
                        $userpass = $_POST['password'];
                        $useremail = $_POST['email'];
                        $userreg = $_POST['date'];
                        
                        //We create a NONCE using the action, username, timestamp, and the NONCE SALT
                        $nonce = md5('registration-' . $userlogin . $userreg . NONCE_SALT);
                        
                        //We hash our password
                        $userpass = $osohm_database->hash_password($userpass, $nonce);
                        
                        //Recompile our $value array to insert into the database
                        $values = array(
                                    'name' => $username,
                                    'username' => $userlogin,
                                    'password' => $userpass,
                                    'email' => $useremail,
                                    'date' => $userreg
                                );
                        
                        //And, we insert our data
                        $insert = $osohm_database->insert($table, $fields, $values);
                        
                        if ( $insert == TRUE ) 
                        {
                            return REGISTRATION_SUCCESSFUL;
                        }
                    } 
                    else
                    {
                        return REGISTRATION_FOREIGN_FORM;
                    }
                }
            }
            
            function login() 
            {
                global $osohm_database;
            
                if (empty( $_POST ) == TRUE) 
                {
                    // empty submission.
                    return LOGIN_EMPTY_DATA;
                }
                else
                {    
                    //Clean our form data
                    $values = $osohm_database->clean($_POST);

                    //The username and password submitted by the user
                    $subname = $values['username'];
                    $subpass = $values['password'];

                    //The name of the table we want to select data from
                    $table = 'users';

                    /*
                     * Run our query to get all data from the users table where the user 
                     * login matches the submitted login.
                     */
                    $sql = "SELECT * FROM $table WHERE user_login = '" . $subname . "'";
                    $results = $osohm_database->select($sql);

                    echo "$results";

                    //return if the script doesn't exit
                    if ($results == FALSE) 
                    {
                        // user not existent.
                        return LOGIN_USER_NOT_FOUND;
                    }

                    //Fetch our results into an associative array
                    $results = mysql_fetch_assoc( $results );
                    
                    //The registration date of the stored matching user
                    $storeg = $results['user_register_timestamp'];

                    //The hashed password of the stored matching user
                    $stopass = $results['user_password'];

                    //Recreate our NONCE used at registration
                    $nonce = md5('registration-' . $subname . $storeg . NONCE_SALT);

                    //Rehash the submitted password to see if it matches the stored hash
                    $subpass = $osohm_database->hash_password($subpass, $nonce);

                    //Check to see if the submitted password matches the stored password
                    if ( $subpass == $stopass ) 
                    {
                        
                        //If there's a match, we rehash password to store in a cookie
                        $authnonce = md5('cookie-' . $subname . $storeg . AUTH_SALT);
                        $authID = $osohm_database->hash_password($subpass, $authnonce);
                        
                        //Set our authorization cookie
                        setcookie("osohmlogauth[user]", $subname);
                        setcookie("osohmlogauth[authID]", $authID);
                        
                        
                        //Return no error.
                        return LOGIN_SUCCESSFUL;
                    } 
                    else 
                    {
                        // invalid user password key.
                        return LOGIN_WRONG_USER_PASSWORD;
                    }
                } 
            }
            
            function logout() 
            {
                //Expire our auth coookie to log the user out
                $idout = setcookie('osohmlogauth[authID]', '', -3600, '', '', '', true);
                $userout = setcookie('osohmlogauth[user]', '', -3600, '', '', '', true);
                
                if ( $idout == TRUE && $userout == TRUE ) 
                {
                    return LOGOUT_SUCCESSFUL;
                } 
                elseif ($idout == FALSE)
                {
                    return LOGOUT_IDOUT_ERROR;
                }
                else
                {
                    return LOGOUT_USEROUT_ERROR;
                }
            }
            
            function checkLogin() 
            {
                global $osohm_database;

                /*
                 * If the cookie values are empty, we return false right away;
                 */
                if (empty( $cookie ) == TRUE) 
                {
                    // empty cookie.
                    return CHECK_LOGIN_EMPTY_COOKIE;
                }
                else 
                {
                    
                    //Grab our authorization cookie array
                    $cookie = $_COOKIE['osohmlogauth'];
                
                    //Set our user and authID variables
                    $user = $cookie['user'];
                    $authID = $cookie['authID'];
                    
                    //Query the database for the selected user
                    $table = 'users';
                    $sql = "SELECT * FROM $table WHERE user_login = '" . $user . "'";
                    $results = $osohm_database->select($sql);

                    //If the submitted username doesn't exit, return false.
                    if ($results == FALSE) 
                    {
                        // username not existent
                        return CHECK_LOGIN_USER_NOT_FOUND;
                    }

                    //Fetch our results into an associative array
                    $results = mysql_fetch_assoc( $results );
            
                    //The registration date of the stored matching user
                    $storeg = $results['user_register_timestamp'];

                    //The hashed password of the stored matching user
                    $stopass = $results['user_password'];

                    //Rehash password to see if it matches the value stored in the cookie
                    $authnonce = md5('cookie-' . $user . $storeg . AUTH_SALT);
                    $stopass = $osohm_database->hash_password($stopass, $authnonce);
                    
                    if ( $stopass == $authID ) 
                    {
                        return CHECK_LOGIN_SESSION_FOUND;
                    } 
                    else 
                    {
                        return CHECK_LOGIN_WRONG_USER_PASSWORD;
                    }
                } 
            }
        }
    }

    //Instantiate our database class
    $osohm_user_membership = new UserMembership;
?>
