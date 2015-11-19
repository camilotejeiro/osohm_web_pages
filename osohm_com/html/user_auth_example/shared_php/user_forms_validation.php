<?php
/***********************************************************************
 * Forms Validation Library.
 * @author Camilo Tejeiro   ,=,e 
 **********************************************************************/

    /**
     * Validate Registration Form
     * Registration Form Validation steps:
     * - check that no fields are empty.
     * - check that the e-mail is valid.
     * - check that the username is valid.
     * - check that both repeated user passwords match.
     * - check that the user password is valid.
     * @param string $user_email User email provided by the user.
     * @param string $user_name Username provided by the user.
     * @param string $user_password Password provided by the user.
     * @param string $user_password2 Repeated password provided by the user.
     * @return integer The function result code (for error handling)
     **/
    function validate_registration_form($user_email, $user_name, $user_password, $user_password2)
    {
        $validation_result = SUCCESS_NO_ERROR;
        if (check_empty_form([$user_email, $user_name, $user_password, $user_password2]) == TRUE)
        {
            $validation_result = VALIDATE_REGISTER_EMPTY_FORM;
            return $validation_result;
        }
        
        // check if e-mail address is valid.
        $validation_result = validate_email($user_email);
        
        if ($validation_result != SUCCESS_NO_ERROR)
        {
            return $validation_result;
        }
        
        // check if user name is valid
        $validation_result = validate_username($user_name);
        
        if ($validation_result != SUCCESS_NO_ERROR)
        {
            return $validation_result;
        }        

        // check if our passwords match.
        $validation_result = check_password_match($user_password, $user_password2);

        if ($validation_result != SUCCESS_NO_ERROR)
        {
            return $validation_result;
        } 

        // check if user password is valid
        $validation_result = validate_password($user_password);

        if ($validation_result != SUCCESS_NO_ERROR)
        {
            return $validation_result;
        }   
        
        return $validation_result;
    }

    /**
     * Validate Login Form
     * Login Form Validation steps:
     * - check that no fields are empty.
     * - check that the username is valid.
     * - check that the user password is valid.
     * @param string $user_name Username provided by the user.
     * @param string $user_password Password provided by the user.
     * @return integer The function result code (for error handling)
     **/    
    function validate_login_form($user_name, $user_password)
    {
        $validation_result = SUCCESS_NO_ERROR;
        if (check_empty_form([$user_name, $user_password]) == TRUE)
        {
            $validation_result = VALIDATE_LOGIN_EMPTY_FORM;
            return $validation_result;
        }

        // check if user name is valid
        $validation_result = validate_username($user_name);
        
        if ($validation_result != SUCCESS_NO_ERROR)
        {
            return $validation_result;
        }        

        // check if user password is valid
        $validation_result = validate_password($user_password);

        if ($validation_result != SUCCESS_NO_ERROR)
        {
            return $validation_result;
        }   
        
        return $validation_result;        
        
    }

    /**
     * Validate Reset Password Form
     * Login Form Validation steps:
     * - check that no fields are empty.
     * - check that the username is valid.
     * @param string $user_name Username provided by the user.
     * @return integer The function result code (for error handling)
     **/ 
    function validate_reset_password_form($user_name)
    {
        $validation_result = SUCCESS_NO_ERROR;
        if (check_empty_form([$user_name]) == TRUE)
        {
            $validation_result = VALIDATE_RESET_PWD_EMPTY_FORM;
            return $validation_result;
        }

        // check if user name is valid
        $validation_result = validate_username($user_name);
        
        if ($validation_result != SUCCESS_NO_ERROR)
        {
            return $validation_result;
        }
        
        return $validation_result;          
    }

    /**
     * Validate Change Password Form
     * Change Password Form Validation steps:
     * - check that no fields are empty.
     * - check that the username is valid.
     * - check if old password is valid.
     * - check if new repeated passwords match.
     * - check if new password is valid.
     * @param string $old_password Old password provided by the user.
     * @param string $new_password New password desired by the user.
     * @param string $new_password2 New repeated password which must match.
     * @return integer The function result code (for error handling)
     **/     
    function validate_change_password_form($old_password, $new_password, $new_password2)
    {
        $validation_result = SUCCESS_NO_ERROR;
        if (check_empty_form([$old_password, $new_password, $new_password2]) == TRUE)
        {
            $validation_result = VALIDATE_CHANGE_PWD_EMPTY_FORM;
            return $validation_result;
        }

        // check if old password is valid.
        $validation_result = validate_password($old_password);
        
        if ($validation_result != SUCCESS_NO_ERROR)
        {
            return $validation_result;
        }

        // check if new passwords match.
        $validation_result = check_password_match($new_password, $new_password2);

        if ($validation_result != SUCCESS_NO_ERROR)
        {
            return $validation_result;
        } 

        // check if new password is valid.
        $validation_result = validate_password($new_password);
        
        if ($validation_result != SUCCESS_NO_ERROR)
        {
            return $validation_result;
        }
        
        return $validation_result;          
    }
    
    /**
     * Check Empty Form
     * Iterate over every field in our form and check if it is empty.
     * @param array $form_fields_array Our array of form fields.
     * @return integer The function result code (for error handling)
     **/      
    function check_empty_form($form_fields_array)
    {
        // test to make sure that no field in our form is empty.
        foreach($form_fields_array as $form_field)
        {
            if (empty($form_field) == TRUE)
                return TRUE;
        }
        
        return FALSE;
    }
 
     /**
     * Validate Email
     * Use the PHP built in filter to detect malformed e-mails.
     * @param string $user_email Email passed by the user.
     * @return integer The function result code (for error handling)
     **/   
    function validate_email($user_email)
    {
        // check if e-mail is malformed using php built-in filter.
        if (filter_var($user_email, FILTER_VALIDATE_EMAIL) == FALSE)
            return VALIDATE_EMAIL_INVALID;
        else
            return SUCCESS_NO_ERROR;
    }    

     /**
     * Validate Username
     * We are checking the the username meets our required properties:
     * - allowed lenght
     * - allowed type of characters.
     * @param string $user_name Username passed by the user.
     * @return integer The function result code (for error handling)
     **/    
    function validate_username($user_name)
    {
        // do we have only allowed characters?
        // we will accept only upper and lower case letters (length 6 - 16).
        if((strlen($user_name) < 6) || (strlen($user_name) > 16))
            return VALIDATE_USERNAME_INVALID;        
        elseif (preg_match("/^[a-zA-Z0-9]+$/", $user_name) == FALSE)
            return VALIDATE_USERNAME_INVALID;
        else
            return SUCCESS_NO_ERROR;
    }     
    
    /**
     * Validate password
     * We are checking that the user password has our desired properties: 
     * the correct length.
     * @param string    $user_password Password field entry
     * @return integer  the function result code.
     **/
    function validate_password($user_password)
    {
        // check that the password meets our requirements.
        if((strlen($user_password) < 6) || (strlen($user_password) > 16))
            return VALIDATE_PASSWORD_INVALID;
        else
            return SUCCESS_NO_ERROR;
    }
    
    /**
     * Check Password Match
     * Compare both user password fields to make sure he/she typed it 
     * correctly. 
     * @param string    $user_password First password field entry
     * @param string    $user_password2 Repeated password field entry 
     * @return integer  the function result code.
     **/
    function check_password_match($user_password, $user_password2)
    {
        // check that our passwords match
        if ($user_password != $user_password2)
            return VALIDATE_PASSWORD_NO_MATCH;
        else
            return SUCCESS_NO_ERROR;
    } 
?>
