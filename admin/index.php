
<?php
  session_start();
   $nonavbar = "";
   $title = 'Login';
  if (isset($_SESSION['username'])) // if is session already  Register
  {
      header('location: dashboard.php');

  }
  include 'init.php';

  ?>
<?php

      // Check if User Coming From HTTP Post Request

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashepass = sha1($password);

      // Check If User Exist In Database

        $stmt = $con->prepare(" SELECT 
                                              userID, username, password
                                          FROM 
                                              users 
                                          WHERE 
                                               username = ? 
                                          AND 
                                              password = ? 
                                          AND 
                                              groupID = 1
                                          LIMIT 1 " );

        $stmt->execute(array($username,$hashepass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        // If Count > 0 This Mean The Database Contain Record Abut this username

        if ( $count > 0 )
        {
            $_SESSION['username'] = $username;            // Register session name
            $_SESSION['id'] = $row['userID'];           // Register session id
            header('location: dashboard.php');
            exit();

        }

    }






?>



<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <h3 class="text-center text-primary">Admin Login</h3>

    <input class="form-control" type="text" name="user" placeholder="user name" autocomplete="off">
    <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-passowrd">
    <input class="btn btn-primary btn-block" type="submit" value="login">
</form>


<?php include $tpl.'footer.php'; ?>
