<?php
/***********************************************************************
 * Example User Account Page.
 * @author Camilo Tejeiro   ,=,e 
 ***********************************************************************/

    /*
     * Page requires and includes.
     */
    require_once('../shared_php/result_codes.php');
    require_once('../shared_php/mysql_database.php');
    require_once('../shared_php/user_membership.php');
    require_once('../shared_php/error_handling.php'); 

    /*
     * Vars declaraction and initialization.
     */
    // Page Header variables.
    $page_title = 'User Account - CAT';
    $page_description = 'User account age';
    $page_author = 'CAT team';
    // $page_styles = 'css/login.css';
    
    // page script variables.
    $page_result_code = SUCCESS_NO_ERROR;
    $page_message = "";
    
    $user_name = "";
    
    /*
     * Page script logic
     */
    session_start();
    
    $page_result_code = check_login_session();
    
     // if a login session exists 
    if ($page_result_code == SUCCESS_NO_ERROR)
    {
        // get short variable names.
        $user_name = $_SESSION['validated_user'];
        
        $page_message = "Welcome ".$user_name.", this is your account";
        
        // first, check if logout var is set, then if it is 1.
        if ((isset($_GET["logout"]) == TRUE) && ($_GET["logout"] == 1))
        {
            $page_result_code = logout_user();
                
            if ($page_result_code == SUCCESS_NO_ERROR)
            {
                $page_message = "successfully logged out";
                
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
        <h4>User Account Page</h4>
        <p><?php echo "$page_message"; ?></p>
        <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?logout=1'); ?>">Logout</a>
        <a href="../change_password/index.php">Change Password</a>
    </body>
    
</html>


