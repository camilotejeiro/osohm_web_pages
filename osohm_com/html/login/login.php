<?php
    require_once('../shared_php/UserMembership.php');
    
    if ( $_GET['action'] == 'logout' ) 
    {
        $loggedout = $j->logout();
    }
    
    $logged = $j->login('index.php');
?>
<html>
    <head>
        <title>Login Form</title>
        <style type="text/css">
            body { background: #c7c7c7;}
        </style>
    </head>

    <body>
        <div>
            <?php if ( $logged == 'invalid' ) : ?>
                <p>
                    The username password combination you entered is incorrect. Please try again.
                </p>
            <?php endif; ?>
            <?php if ( $_GET['reg'] == 'true' ) : ?>
                <p>Your registration was successful, please login below.</p>
            <?php endif; ?>
            <?php if ( $_GET['action'] == 'logout' ) : ?>
                <?php if ( $loggedout == true ) : ?>
                    <p>You have been successfully logged out.</p>
                <?php else: ?>
                    <p>There was a problem logging you out.</p>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ( $_GET['msg'] == 'login' ) : ?>
                <p>
                    You must log in to view this content. Please log in below.
                </p>
            <?php endif; ?>
        
            <h3>Login</h3>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <table>
                    <tr>
                        <td>Username:</td>
                        <td><input type="text" name="username" /></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input type="password" name="password" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Register" /></td>
                    </tr>
                </table>
            </form>
            <p>Not a member? <a href="register.php">Register here</a></p>
        </div>
    </body>
</html>

