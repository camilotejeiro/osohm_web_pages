<?php
/***********************************************************************
 * Example User Account Page.
 ***********************************************************************/

    require_once('../shared_php/result_codes.php');
    require_once('../shared_php/mysql_database.php');
    require_once('../shared_php/user_membership.php');

    session_start();
     
    # Header variables.
    $page_title = 'User Account - CAT';
    $page_description = 'User account age';
    $page_author = 'CAT team';
    # $page_styles = 'css/login.css';

    # Declare and initialize our variables.
    $user_name = "";

    $check_login_result = SUCCESS_NO_ERROR;
    $user_account_message = "";
    
    $check_login_result = check_login_session();
    
     // if a login session exists 
    if ($check_login_result == SUCCESS_NO_ERROR)
    {
        // create short variable names.
        $user_name = $_SESSION['validated_user'];
        
        $user_account_message = "Welcome ".$user_name.", this is your account";

    }
    else
    {   
        $user_account_message = "This page is for members only, please login first."; 
    }
    
?>

<!DOCTYPE html>
<html lang="en">
    
    <?php require_once('../shared_php/page_header.php'); ?>
    
    <body>
        <h4>User Account Page</h4>
        <p><?php echo "$user_account_message"; ?></p>
        <a href="../index.php">Logout</a>
    </body>
    
</html>


