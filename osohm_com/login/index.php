<?php
/***********************************************************************
 * Osohm.com/login webpage
***********************************************************************/

    require_once('../shared_php/UserMembership.php');    

    $check_login_result_code = $osohm_user_membership->checkLogin();
 
    // initialize our result code.
    $login_result_code = NULL;
 
    if (isset($_POST['submit']) == TRUE)
    {
        $login_result_code = $osohm_user_membership->login();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Basic Page Needs -->
        <meta charset="utf-8">
        <title>Login - Osohm</title>
        <meta name="description" content="Login">
        <meta name="author" content="the Osohm team">

        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- FONT -->
        <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

        <!-- Domain/Platform General CSS -->
        <link rel="stylesheet" href="../shared_css/normalize.css">
        <link rel="stylesheet" href="../shared_css/skeleton.css">
        <link rel="stylesheet" href="../shared_css/navigation.css">
        <link rel="stylesheet" href="../shared_css/content.css">
                        
        <!-- Page Specific CSS -->
        <link rel="stylesheet" href="css/login.css">
        
        <!-- Favicon -->
        <!-- <link rel="icon" type="image/png" href="images/favicon.png"> -->

    </head>

    <body>
        <div class="wrapper">
            <nav class="navhead">
                <div class="container">
                    <div class="row">
                        <div class="three columns">
                            <a class="navhead-link" href="http://osohm.com">Osohm</a>
                        </div>
                        <div class="three columns">
                            <a class="navhead-link" href="http://osohm.com/create_project">Create Project</a>
                        </div>
                        <div class="three columns">
                            <a class="navhead-link" href="http://osohm.com/search_projects">Search Projects</a>
                        </div>
                        <div class="three columns">
                            <a class="navhead-link" id="navhead-link-current" href="http://osohm.com/login">Login</a>
                        </div>
                    </div>                
                </div>
            </nav>            
            <div class="container">
                <div class="content" id="login-section">
                    <h4 id="login-section-title">
                        Login Page
                    </h4>
                    <?php if ($check_login_result_code === CHECK_LOGIN_SESSION_FOUND) : ?>
                        <p>
                            You are already logged in.
                            <a href="../user_account/index.php">Go to your account</a>
                            (we will redirect you in the future)
                        </p>
                    <?php elseif ( $login_result_code === LOGIN_SUCCESSFUL ) : ?> 
                        <p>
                            Alright you are logged in.
                            <a href="../user_account/index.php">Go to your account</a>
                            (we will redirect you in the future)
                        </p>
                    <?php else: ?>
                        <?php if ($login_result_code === NULL) : ?>
                            <p>Please enter your username and password.</p>
                        <?php elseif ( $login_result_code === LOGIN_EMPTY_DATA ): ?>
                            <p> Forms were empty, please try again.</p>
                        <?php elseif ( $login_result_code === LOGIN_USER_NOT_FOUND ): ?>
                            <p>Username does not exist.</p>
                        <?php elseif ( $login_result_code === LOGIN_WRONG_USER_PASSWORD): ?>
                            <p> Username/password combination does not match our records.</p>
                        <?php else: ?>
                            <p>Unknown Login page error.</p>                
                        <?php endif; ?>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input type="text" name="username" placeholder="Username">
                            <input type="password" name="password" placeholder="Password">
                            <input type="submit" name="submit" value="Login" />
                        </form>
                        <p>Not a member? <a href="../register/index.php">Register here</a></p>
                        <p><a href="../forgot/index.php">Forgot Password</a></p>
                     <?php endif; ?>   
                </div>    
            </div>
            <div class="push"></div>
        </div>
        <nav class="navfoot">
            <div class="container">
                <div class="row">
                    <div class="three columns">
                        <a class="navfoot-link" href="http://osohm.com/blog">Blog</a>
                    </div>
                    <div class="three columns">
                        <a class="navfoot-link" href="http://osohm.com/faq">FAQ</a>
                    </div>
                    <div class="three columns">
                        <a class="navfoot-link" href="http://osohm.com/about">About Us</a>
                    </div>
                    <div class="three columns">
                        <a class="navfoot-link" href="http://osohm.com/credits">Credits</a>
                    </div>
                </div>    
            </div>    
        </nav>
    </body>
</html>
