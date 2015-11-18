<?php 
/***********************************************************************
 * Example Registration Page
 **********************************************************************/
    
    require_once('../shared_php/result_codes.php');
    require_once('../shared_php/user_forms_validation.php');
    require_once('../shared_php/mysql_database.php');
    require_once('../shared_php/user_membership.php');

    session_start();

    # Page Header variables.
    $page_title = 'Registration - CAT';
    $page_description = 'registration page';
    $page_author = 'CAT team';
    #$page_styles = 'css/registration.css';
        
    # Declare and initialize our variables.
    $user_email = "";
    $user_name = "";
    $user_password = "";
    $user_password2 = "";

    $validation_result = 0;
    $registration_result = 0;
    $registration_message = "please enter your information";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // Create short variable names. 
        $user_email = $_POST['user_email']; 
        $user_name = $_POST['user_name'];
        $user_password = $_POST['user_password'];
        $user_password2 = $_POST['user_password2'];
        
        $validation_result = validate_registration_form($user_email, $user_name, $user_password, $user_password2);
    
        // if validation was succesful
        if ($validation_result == SUCCESS_NO_ERROR)
        {
            $registration_result = register_user($user_name, $user_email, $user_password);
            
            if($registration_result == SUCCESS_NO_ERROR)
            {
                $registration_message = "registration successful"; 
                
                // redirect to the 'login' page
                // REMEMBER:
                // header() must be called before any actual output is 
                // sent, either by normal HTML tags, blank lines in a file, or from PHP.
                // plus addressess must be absolute (we need to change this)
                header("Location: ../index.php");
            }
            else
            {
                $registration_message = "registration not successful: $registration_result"; 
            }
        }
        else
        {   
            $registration_message = "validation not successful: $validation_result"; 
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
    
    <?php require_once('../shared_php/page_header.php'); ?>

    <body>
        <h4>Registration Page</h4>
        <p><?php echo "$registration_message"; ?></p>
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
