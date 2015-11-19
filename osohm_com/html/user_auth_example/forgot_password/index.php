<?php
/***********************************************************************
 * Example Forgot Password Page.
 * @author Camilo Tejeiro   ,=,e 
 ***********************************************************************/

    /*
     * Page requires and includes.
     */
    require_once('../shared_php/result_codes.php');
    require_once('../shared_php/user_forms_validation.php');
    require_once('../shared_php/mysql_database.php');
    require_once('../shared_php/user_membership.php');
    require_once('../shared_php/error_handling.php'); 

    /*
     * Vars declaraction and initialization.
     */    
    // Header variables.
    $page_title = 'Forgot Password - CAT';
    $page_description = 'Forgot password page';
    $page_author = 'CAT team';
    //$page_styles = 'css/login.css';

    //page script variables.
    $page_result_code = SUCCESS_NO_ERROR;
    $page_message = "Input your username, we will send you an email to reset your password";

    $user_name = "";

    
    session_start();
    
    // if a login session exists, make sure you redirect to the my account page. 
    if (check_login_session() == SUCCESS_NO_ERROR)
    {
        // redirect to the 'user_account' page
        // REMEMBER:
        // header() must be called before any actual output is 
        // sent, either by normal HTML tags, blank lines in a file, or from PHP.
        // plus addressess must be absolute (we need to change this)
        header("Location: ../user_account/index.php");
    }
    else
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            
            // Create short variable names. 
            $user_name = $_POST['user_name'];
            
            $page_result_code = validate_reset_password_form($user_name);
            
            // if validation was succesful
            if ($page_result_code == SUCCESS_NO_ERROR)
            {
                // generate a random password.
                // update password in users database.
                // send password.
                $page_result_code = reset_password($user_name);
                
                if ($page_result_code == SUCCESS_NO_ERROR)
                {
                    $page_message = "Password reset and sent to your e-mail";
                    
                    // redirect to the 'user_account' page
                    // REMEMBER:
                    // header() must be called before any actual output is 
                    // sent, either by normal HTML tags, blank lines in a file, or from PHP.
                    // plus addressess must be absolute (we need to change this)
                    header("Location: ../index.php");
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
    
    <?php require_once('../shared_php/page_header.php'); ?>
    
    <body>
        <h4>Forgot Password Page</h4>
        <p><?php echo "$page_message"; ?></p>
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
            Username: <input type="text" name="user_name"><br>
            <input type="submit" name="reset_password" value="reset password" /> 
        </form>
    </body>
</html>


