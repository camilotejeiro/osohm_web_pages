<?php
/***********************************************************************
 * Example Login Page
 ***********************************************************************/

    require_once('shared_php/result_codes.php');
    require_once('shared_php/user_forms_validation.php');
    require_once('shared_php/mysql_database.php');
    require_once('shared_php/user_membership.php');

    session_start();
     
    # Header variables.
    $page_title = 'Login - CAT';
    $page_description = 'login page';
    $page_author = 'CAT team';
    # $page_styles = 'css/login.css';
    
    # Declare and initialize our variables.
    $user_name = "";
    $user_password = "";

    $validation_result = SUCCESS_NO_ERROR;
    $login_result = SUCCESS_NO_ERROR;
    $login_message = "please enter your username and password";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // Create short variable names. 
        $user_name = $_POST['user_name'];
        $user_password = $_POST['user_password'];
        
        $validation_result = validate_login_form($user_name, $user_password);
        
         // if validation was succesful
        if ($validation_result == SUCCESS_NO_ERROR)
        {
            $login_result = login_user($user_name, $user_password);
            
            if($login_result == SUCCESS_NO_ERROR)
            {
                $login_message = "login successful"; 
                
                // redirect to the 'my_account' page
                // REMEMBER:
                // header() must be called before any actual output is 
                // sent, either by normal HTML tags, blank lines in a file, or from PHP.
                // plus addressess must be absolute (we need to change this)
                header("Location: user_account/index.php");
            }
            else
            {
                $login_message = "login not successful: $login_result"; 
            }
        }
        else
        {   
            $login_message = "wrong username/password: $validation_result"; 
        }       
    }
    
?>

<!DOCTYPE html>
<html lang="en">
    
    <?php require_once('shared_php/page_header.php'); ?>
    
    <body>
        <h4>Login Page</h4>
        <p><?php echo "$login_message"; ?></p>
        <a href='registration/index.php'>Not a member?</a>
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
            Username: <input type="text" name="user_name"><br>
            Password: <input type="password" name="user_password"><br>
            <input type="submit" name="login" value="login" /> 
        </form>
        <a href="forgot_password/index.php">Forgot your password?</a>
    </body>
    
</html>

