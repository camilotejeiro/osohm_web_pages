<?php
/***********************************************************************
 * Users My account page.
 * This is the users-only account page.
 **********************************************************************/
    require_once('../shared_php/UserMembership.php');
    
    $check_login_result_code = $osohm_user_membership->checkLogin();

    if (isset($_POST['submit']) == TRUE)
    {
        $logout_result_code = $osohm_user_membership->logout();
    }
    
?>
<html>
    <head>
        <!-- Basic Page Needs -->
        <meta charset="utf-8">
        <title>User Account - Osohm</title>
        <meta name="description" content="User Account">
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
        <!-- <link rel="stylesheet" href="css/user_account.css"> -->
        
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
                            <a class="navhead-link" id="navhead-link-current" href="http://osohm.com/user_account">My Account</a>
                        </div>
                    </div>                
                </div>
            </nav>            
            <div class="container">
                <div class="content" id="user-account-section">        
                    <?php if ($check_login_result_code == CHECK_LOGIN_SESSION_FOUND) : ?>
                        <p>
                            Alright you are logged in, you have access to your account.
                        </p>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input type="submit" name="submit" value="Logout" />
                        </form>
                    <?php else: ?>
                        <p>
                            You are not logged in.
                            <a href="../login/index.php">Login here</a>
                        </p>                
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
