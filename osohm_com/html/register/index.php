<?php
    require_once('../shared_php/UserMembership.php');

    $check_login_result_code = $osohm_user_membership->checkLogin();
    
    if (isset($_POST['submit']) == TRUE)
    {
        $register_result_code = $osohm_user_membership->register();
    }
?>

<html>
    <head>
        <!-- Basic Page Needs -->
        <meta charset="utf-8">
        <title>Registration - Osohm</title>
        <meta name="description" content="Registration">
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
        <!-- <link rel="stylesheet" href="css/registration.css"> -->
        
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
                            <a class="navhead-link" id="navhead-link-current" href="http://osohm.com/registration">Registration</a>
                        </div>
                    </div>                
                </div>
            </nav>            
            <div class="container">
                <div class="content" id="registration-section">        
                    <h3>Register</h3>
                    <?php if ($check_login_result_code == CHECK_LOGIN_SESSION_FOUND) : ?>
                        <p>
                            You are already logged in.
                            <a href="../user_account/index.php">Go to your account</a>
                            (we will redirect you in the future)
                        </p>
                    <?php else: ?>
                        <?php if (isset($_POST['submit']) == FALSE) : ?>
                            <p>Please fill in the fields to register</p>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <input type="text" name="name" placeholder="Name">
                                <input type="text" name="username" placeholder="Username">
                                <input type="password" name="password" placeholder="Password">
                                <input type="text" name="email" placeholder="e-mail">
                                <input type="hidden" name="date" value="<?php echo time(); ?>" />
                                <input type="submit" name="submit" value="Register" />
                            </form>  
                            <p>Already a member? <a href="../login/index.php">Log in here</a></p>
                        <?php elseif ($register_result_code == REGISTRATION_SUCCESSFUL): ?>
                            <p>
                                Registration Successful.
                                <a href="../login/index.php">Proceed to login.</a>
                                (we will redirect you in the future)
                            </p>         
                        <?php else: ?>
                            <p>Registration Error, check your entries</p>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <input type="text" name="name" placeholder="Name">
                                <input type="text" name="username" placeholder="Username">
                                <input type="password" name="password" placeholder="Password">
                                <input type="text" name="email" placeholder="e-mail">
                                <input type="hidden" name="date" value="<?php echo time(); ?>" />
                                <input type="submit" name="submit" value="Register" />
                            </form>
                            <p>Already a member? <a href="../login/index.php">Log in here</a></p>
                        <?php endif; ?>
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
