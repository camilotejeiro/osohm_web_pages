<?php
/***********************************************************************
 * Error Handling Library.
 * @author Camilo Tejeiro   ,=,e 
 **********************************************************************/
    
    // if we use an undefined constant.
    const DEBUG_MODE = TRUE;  
    
    /**
     * Handle Result Code.
     * Switch over every result code until you find the right one, then 
     * create an appropriate page user message and append debugging 
     * information if applicable (if debugging is true) 
     * @param integer $result_code page result code and potential error code.
     * @param string $page_message Message we will modify as applicable.
     **/
    function handle_result_code($result_code, &$page_message)
    {
        
        $result_code_name = '';
        
        switch ($result_code) 
        {
            case (UNCAUGHT_ERROR):
            {
                $result_code_name = 'UNCAUGHT_ERROR';
                
                // This is a pretty big deal.
                // Normally we never ever want to hold execution or kill 
                // our script (this is bad design), the application must 
                // unwind and resolve gracefully but if we have a fatal 
                // error or we fail to handle or catch our error, we must 
                // kill our script promptly to avoid any further issues.
                $page_message = 'Page Error, please contact the development team';
                die("Page Error, please contact the development team");
                break;
            }
            case SUCCESS_NO_ERROR:
            {
                $result_code_name = 'SUCCESS_NO_ERROR';
                
                // don't update existent message, break out. 
                break;
            }
            case VALIDATE_REGISTER_EMPTY_FORM:
            {
                $result_code_name = 'VALIDATE_REGISTER_EMPTY_FORM';
                
                $page_message = 'We found one or more empty fields, 
                                please update and re-submit';
                break;
            }
            case VALIDATE_LOGIN_EMPTY_FORM:
            {
                $result_code_name = 'VALIDATE_LOGIN_EMPTY_FORM';
                
                $page_message = 'We found one or more empty fields, 
                                please update and re-submit';
                break;
            }
            case VALIDATE_RESET_PWD_EMPTY_FORM:
            {
                $result_code_name = 'VALIDATE_RESET_PWD_EMPTY_FORM';
                
                $page_message = 'We found one or more empty fields, 
                                please update and re-submit';
                break;
            }
            case VALIDATE_EMAIL_INVALID:
            {
                $result_code_name = 'VALIDATE_EMAIL_INVALID';
                
                $page_message = 'Invalid e-mail, please update the form 
                                and re-submit';
                break;
            }
            case VALIDATE_USERNAME_INVALID:
            {
                $result_code_name = 'VALIDATE_USERNAME_INVALID';
                                
                $page_message = 'Invalid username, please update the form 
                                and re-submit';
                break;
            }
            case VALIDATE_PASSWORD_INVALID:
            {
                $result_code_name = 'VALIDATE_PASSWORD_INVALID';
                
                $page_message = 'Invalid password, please update the form 
                                and re-submit';
                break;
            }
            case VALIDATE_PASSWORD_NO_MATCH:
            {
                $result_code_name = 'VALIDATE_PASSWORD_NO_MATCH';
                
                $page_message = 'Passwords did not match, please update 
                                the form and re-submit';
                break;
            }
            case REGISTER_DB_CANT_CONNECT:
            {
                $result_code_name = 'REGISTER_DB_CANT_CONNECT';
                
                $page_message = 'Sorry, we could not create your account, 
                                please try again later';
                break;
            }
            case REGISTER_DB_QUERY_ERROR:
            {
                $result_code_name = 'REGISTER_DB_QUERY_ERROR';
                
                $page_message = 'Sorry, we could not create your account, 
                                please try again later';
                break;
            }
            case REGISTER_DB_USER_EXISTS:
            {
                $result_code_name = 'REGISTER_DB_USER_EXISTS';

                $page_message = 'Username already exists, please choose 
                                a different one';
                break;
            }
            case REGISTER_DB_INSERT_USER_ERROR:
            {
                $result_code_name = 'REGISTER_DB_INSERT_USER_ERROR';

                $page_message = 'Sorry, we could not create your account, 
                                please try again later';
                break;
            }
            case LOGIN_DB_CANT_CONNECT:
            {
                $result_code_name = 'LOGIN_DB_CANT_CONNECT';
                
                $page_message = 'Sorry, we could not login to your account, 
                                please try again later';
                break;
            }
            case LOGIN_DB_QUERY_ERROR:
            {
                $result_code_name = 'LOGIN_DB_QUERY_ERROR';   
                
                $page_message = 'Sorry, we could not login to your account, 
                                please try again later';
                break;
            }
            case LOGIN_DB_INVALID_USER_PASSWORD:
            {
                $result_code_name = 'LOGIN_DB_INVALID_USER_PASSWORD';
                
                $page_message = 'Invalid user password combination, please update 
                                the form and re-submit';
                break;
            }
            case CHECK_SESSION_NO_USER:
            {
                $result_code_name = 'CHECK_SESSION_NO_USER';                
                
                $page_message = "This page is for members only, 
                                please <a href=\"../index.php\">Login</a> first";
                break;
            }
            case LOGOUT_ERROR:
            {
                $result_code_name = 'LOGOUT_ERROR'; 
                               
                $page_message = 'Could not log you out, please try again';
                break;
            }
            case RESET_PWD_DB_CANT_CONNECT:
            {
                $result_code_name = 'RESET_PWD_DB_CANT_CONNECT'; 
                
                $page_message = 'Sorry, we could not reset your password, 
                                please contact us or try again later';
                break;
            }
            case RESET_PWD_DB_CANT_UPDATE:
            {
                $result_code_name = 'RESET_PWD_DB_CANT_UPDATE'; 
                
                $page_message = 'Sorry, we could not reset your password, 
                                please contact us or try again later';
                break;
            }
            case RESET_PWD_DB_QUERY_ERROR:
            {
                $result_code_name = 'RESET_PWD_DB_QUERY_ERROR'; 
                
                $page_message = 'Sorry, we could not reset your password, 
                                please contact us or try again later';
                break;
            }
            case RESET_PWD_DB_EMPTY_EMAIL:
            {
                $result_code_name = 'RESET_PWD_DB_EMPTY_EMAIL'; 
                
                $page_message = 'Email does not exist, please update the 
                                form and try again';
                break;
            }
            case RESET_PWD_DB_INVALID_USER:
            {
                $result_code_name = 'RESET_PWD_DB_INVALID_USER'; 
                
                $page_message = 'User is invalid, please update the form and 
                                re-submit';
                break;
            }
            case RESET_PWD_MAIL_ERROR:
            {
                $result_code_name = 'RESET_PWD_MAIL_ERROR'; 
                
                $page_message = 'Sorry, we could not reset your password, 
                                please contact us or try again later';
                break;
            }
            case CHANGE_PWD_DB_CANT_CONNECT:
            {
                $result_code_name = 'CHANGE_PWD_DB_CANT_CONNECT'; 
                
                $page_message = 'Sorry, we could not change your password, 
                                please contact us or try again later';
                break;
            }
            case CHANGE_PWD_DB_QUERY_ERROR:
            {
                $result_code_name = 'CHANGE_PWD_DB_QUERY_ERROR'; 
                
                $page_message = 'Sorry, we could not change your password, 
                                please contact us or try again later';
                break;
            }
            case CHANGE_PWD_DB_INVALID_PASSWORD:
            {
                $result_code_name = 'CHANGE_PWD_DB_INVALID_PASSWORD'; 
                
                $page_message = 'Invalid password, please update the form 
                                and re-submit';
                break;
            } 
            case CHANGE_PWD_DB_CANT_UPDATE:
            {
                $result_code_name = 'CHANGE_PWD_DB_CANT_UPDATE'; 
                
                $page_message = 'Sorry, we could not change your password, 
                                please contact us or try again later';
                break;
            }
            default:
            {
                // unkonw result code.
                
                $result_code_name = 'UNCAUGHT_ERROR';
                
                // This is a pretty big deal.
                // Normally we never ever want to hold execution or kill 
                // our script (this is bad design), the application must 
                // unwind and resolve gracefully but if we have a fatal 
                // error or we fail to handle or catch our error, we must 
                // kill our script promptly to avoid any further issues.
                $page_message = "Page Error, please contact the development team";
                die("Page Error, please contact the development team");
                break; 
            }                        
        }
        
        // if we are in debug mode append the name and value of our result 
        // code.
        if (DEBUG_MODE == TRUE)
            $page_message.=" ($result_code_name: $result_code)";
    }
?>
