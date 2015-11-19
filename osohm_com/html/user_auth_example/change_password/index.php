<?php
/***********************************************************************
 * Example Change Password Page.
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
    $page_title = 'Change Password - CAT';
    $page_description = 'Change password page';
    $page_author = 'CAT team';
    //$page_styles = 'css/login.css';

    //page script variables.
    $page_result_code = SUCCESS_NO_ERROR;
    $page_message = "Fill in the form to change the password.";

    $old_password = "";
    $new_password = "";
    $new_password2 = "";

    /*
     * Page script logic
     */
    session_start();
    
    $page_result_code = check_login_session();
    
     // if a login session exists 
    if ($page_result_code == SUCCESS_NO_ERROR)
    {
        
        // first, check if we received a post request.
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            
            // Create short variable names. 
            $user_name = $_SESSION['validated_user']; 
            $old_password = $_POST['old_password'];
            $new_password = $_POST['new_password'];
            $new_password2 = $_POST['new_password2']; 
    
            $page_result_code = validate_change_password_form($old_password, $new_password, $new_password2);
                
            if ($page_result_code == SUCCESS_NO_ERROR)
            {
                $page_result_code = change_password($user_name, $old_password, $new_password);
                
                if($page_result_code == SUCCESS_NO_ERROR)
                {
                    $page_message = "changed password succesfully"; 
                    
                    // redirect to the 'my_account' page
                    // REMEMBER:
                    // header() must be called before any actual output is 
                    // sent, either by normal HTML tags, blank lines in a file, or from PHP.
                    // plus addressess must be absolute (we need to change this)
                    header("Location: ../user_account/index.php");
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
    else
    {   
        handle_result_code($page_result_code, $page_message); 
    }
?>

<!DOCTYPE html>
<html lang="en">
    
    <?php require_once('../shared_php/page_header.php'); ?>
    
    <body>
        <h4>Change Password Page</h4>
        <p><?php echo "$page_message"; ?></p>
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
            Old Password: <input type="password" name="old_password" maxlength=16><br>
            New Password (between 6 - 16 characters): <input type="password" name="new_password" maxlength=16><br>
            Repeat New Password: <input type="password" name="new_password2" maxlength=16><br>            
            <input type="submit" name="change_password" value="change password" /> 
        </form>
    </body>
</html>


