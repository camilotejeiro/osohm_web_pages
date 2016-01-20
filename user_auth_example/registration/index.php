<?php 
/***********************************************************************
 * Example Registration Page
 * @author Camilo Tejeiro   ,=,e 
 **********************************************************************/
    
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
    // Page Header variables.
    $page_title = 'Registration - CAT';
    $page_description = 'registration page';
    $page_author = 'CAT team';
    //$page_styles = 'css/registration.css';
        
    // page script variables.
    $page_result_code = 0;
    $page_message = "Please enter your registration information";
    
    $user_email = "";
    $user_name = "";
    $user_password = "";
    $user_password2 = "";

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
        header("Location: ../user_account/index.php");
    }
    else
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            // Create short variable names. 
            $user_email = $_POST['user_email']; 
            $user_name = $_POST['user_name'];
            $user_password = $_POST['user_password'];
            $user_password2 = $_POST['user_password2'];
            
            $page_result_code = validate_registration_form($user_email, $user_name, $user_password, $user_password2);
        
            // if validation was succesful
            if ($page_result_code == SUCCESS_NO_ERROR)
            {
                $page_result_code = register_user($user_name, $user_email, $user_password);
                
                if($page_result_code == SUCCESS_NO_ERROR)
                {
                    $page_message = "registration successful"; 
                    
                    // redirect to the 'login' page
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
        <h4>Registration Page</h4>
        <p><?php echo "$page_message"; ?></p>
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
            E-mail Address: <input type="text" name="user_email"><br>
            Username (max 16 characters): <input type="text" name="user_name" maxlength=16><br>
            Password (between 6 and 16 characters): <input type="password" name="user_password" maxlength=16><br>
            Repeat Password: <input type="password" name="user_password2" maxlength=16><br>
            <input type="submit" name="register" value="Register" />            
        </form>
        <a href="../index.php">Already have an account, login?</a>
    </body>

</html>
