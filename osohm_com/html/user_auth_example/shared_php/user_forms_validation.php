<?php
/***********************************************************************
 * Forms Validation
 **********************************************************************/

    function validate_registration_form($user_email, $user_name, $user_password, $user_password2)
    {
        $validation_result = SUCCESS_NO_ERROR;
        if (check_empty_form([$user_email, $user_name, $user_password, $user_password2]) == TRUE)
        {
            $validation_result = VALIDATON_REGISTER_EMPTY_FORM;
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
    
    function validate_login_form($user_name, $user_password)
    {
        $validation_result = SUCCESS_NO_ERROR;
        if (check_empty_form([$user_name, $user_password]) == TRUE)
        {
            $validation_result = VALIDATION_LOGIN_EMPTY_FORM;
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
    
    function validate_email($user_email)
    {
        // check if e-mail is malformed using php built-in filter.
        if (filter_var($user_email, FILTER_VALIDATE_EMAIL) == FALSE)
            return VALIDATION_EMAIL_INVALID;
        else
            return SUCCESS_NO_ERROR;
    }    
    
    function validate_username($user_name)
    {
        // do we have only allowed characters?
        // we will accept only upper and lower case letters (no special simbols)
        if (preg_match("/^[a-zA-Z]*$/",$user_name) == FALSE)
            return VALIDATION_USERNAME_INVALID;
        else
            return SUCCESS_NO_ERROR;
    }     
    
    /**
     * Validate password
     * Here we are checking that the user password itself has the 
     * following properties:
     * - it May contain letter and numbers
     * - Must contain at least 1 number and 1 letter
     * - May contain any of these characters: !@#$%
     * - Must be 6-16 characters
     * @param string    $user_password First password field entry
     * @param string    $user_password2 Second password field entry, for checking.
     * @return integer  the function result code.
     **/
    function validate_password($user_password)
    {
        // check that the password meets our requirements.
        if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{6,16}$/', $user_password) == FALSE)
            return 5;
        else
            return SUCCESS_NO_ERROR;
    }
    
    function check_password_match($user_password, $user_password2)
    {
        // check that our passwords match
        if ($user_password != $user_password2)
            return VALIDATION_PASSWORD_INVALID;
        else
            return SUCCESS_NO_ERROR;
    } 
?>
