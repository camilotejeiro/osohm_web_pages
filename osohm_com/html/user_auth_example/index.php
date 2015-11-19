<?php
/***********************************************************************
 * Example Login Page
 * @author Camilo Tejeiro   ,=,e 
 ***********************************************************************/
    
    /*
     * Page requires and includes.
     */
    require_once('shared_php/result_codes.php');
    require_once('shared_php/user_forms_validation.php');
    require_once('shared_php/mysql_database.php');
    require_once('shared_php/user_membership.php');
    require_once('shared_php/error_handling.php'); 
     
    /*
     * Vars declaraction and initialization.
     */     
    // Page Header variables.
    $page_title = 'Login - CAT';
    $page_description = 'login page';
    $page_author = 'CAT team';
    // $page_styles = 'css/login.css';
    
    // page script variables.
    $page_result_code = SUCCESS_NO_ERROR;
    $page_message = "please enter your username and password";
    
    $user_name = "";
    $user_password = "";

    /*
     * Page script logic
     */
    session_start();
    
    $page_result_code = check_login_session();
    
     // if a login session exists, make sure you redirect to the my account page. 
    if ($page_result_code == SUCCESS_NO_ERROR)
    {
        // redirect to the 'user_account' page
        // REMEMBER:
        // header() must be called before any actual output is 
        // sent, either by normal HTML tags, blank lines in a file, or from PHP.
        // plus addressess must be absolute (we need to change this)
        header("Location: user_account/index.php");
    }
    else
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            // Create short variable names. 
            $user_name = $_POST['user_name'];
            $user_password = $_POST['user_password'];
            
            $page_result_code = validate_login_form($user_name, $user_password);
            
             // if validation was succesful
            if ($page_result_code == SUCCESS_NO_ERROR)
            {
                $page_result_code = login_user($user_name, $user_password);
                
                if($page_result_code == SUCCESS_NO_ERROR)
                {
                    $page_message = "login successful"; 
                    
                    // redirect to the 'my_account' page
                    // REMEMBER:
                    // header() must be called before any actual output is 
                    // sent, either by normal HTML tags, blank lines in a file, or from PHP.
                    // plus addressess must be absolute (we need to change this)
                    header("Location: user_account/index.php");
                }
                else
                {
                    handle_result_code($page_result_code, $page_message);
                }
            }
            else
            {   
                handle_result_code($page_result_code, $page_message);
            }       
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    
    <?php require_once('shared_php/page_header.php'); ?>
    
    <body>
        <h4>Login Page</h4>
        <p><?php echo "$page_message"; ?></p>
        <a href='registration/index.php'>Not a member?</a>
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
            Username: <input type="text" name="user_name"><br>
            Password: <input type="password" name="user_password"><br>
            <input type="submit" name="login" value="login" /> 
        </form>
        <a href="forgot_password/index.php">Forgot your password?</a>
    </body>
    
</html>

