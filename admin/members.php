<?php
/**
 * =====================================================================================================================
 * Date: 01/04/17  Time: 03:58 م
 *
 * Manage Members page
 * =====================================================================================================================
 */
ob_start();
session_start();
$title = "Members";

if (isset($_SESSION['username'])) // if is session already  Register
{
    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
    // ************************************** Manage Page **************************************************************
    $query = "";
    if (isset($_GET['page']) && $_GET['page'] == "pending") {
        $query = 'AND regstatus = 0';
    }

    if ($do == 'manage') {
        $stmt = $con->prepare("SELECT * FROM users WHERE groupID != 1 $query");
        $stmt->execute();
        $rows = $stmt->fetchAll();


        ?>
        <div class="container">
            <h1 class="text-center">Manage Page</h1>
            <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>ID</td>
                        <td>User Name</td>
                        <td>Emaile</td>
                        <td>Full name</td>
                        <td>Register Date</td>
                        <td>Control</td>
                    </tr>

                    <?php
                    foreach ($rows as $row) {


                        echo '<tr>
                                      <td>' . $row['userID'] . '</td>
                                      <td>' . $row['username'] . '</td>
                                      <td>' . $row['email'] . '</td>
                                      <td>' . $row['fullname'] . '</td>
                                      <td>' . $row['date'] . '</td>
                                      <td> 
                                        <a href="members.php?do=edit&userid=' . $row['userID'] . '" class="btn btn-primary"><i class="fa fa-edit"> </i> </a>
                                        <a href="members.php?do=delete&userid=' . $row['userID'] . '"  class="btn btn-danger confirm "><i class="fa fa-remove"> </i> </a>';
                        if ($row['regstatus'] == 0) {

                            echo '
                                        <a href="members.php?do=active&userid=' . $row['userID'] . '" class="btn btn-info"><i class="fa fa-truck"> </i> </a>';
                        }
                        echo '</td>
                                     
                                  </tr>';
                        ?>


                    <?php } ?>
                    </tr>

                </table>
            </div>
            <a href="?do=add" class="btn btn-primary"> <i class="fa fa-plus">Add new Member </i> </a>
        </div>


        <?php

        //******************************** Add  Page *******************************************************************

    } elseif ($do == 'add') { ?>


        <h1 class="text-center">Add Members </h1>
        <div class="container">
            <form class="form-horizontal" action="?do=insert" method="post">
                <!-- username -->
                <div class="form-group">
                    <label class="col-md-2 control-label">User Name</label>
                    <div class="col-md-10">
                        <input type="text" name="username" class="form-control" autocomplete="off" required="required">
                    </div>
                </div>
                <!-- Password -->
                <div class="form-group">
                    <label class="col-md-2 control-label"> Password</label>
                    <div class="col-md-10">
                        <input type="password" name="password" class=" password form-control" autocomplete="off"
                               required="required"> <i class="show-pass  fa fa-eye"></i>

                    </div>
                </div>
                <!-- Email -->
                <div class="form-group">
                    <label class="col-md-2 control-label"> Email</label>
                    <div class="col-md-10 ">
                        <input type="text" name="email" class="form-control" autocomplete="off" required="required">
                    </div>
                </div>
                <!-- Full Name -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Full Name </label>
                    <div class="col-md-10">
                        <input type="text" name="fullname" class="form-control" autocomplete="off" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-10 col-md-offset-2">
                        <input type="submit" class="btn btn-primary" value="Add">
                    </div>
                </div>

            </form>

        </div>


        <?php
        //************************************************ Insert Page *************************************************

    } elseif ($do == 'insert') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<div class="container">';
            // Get Variable from The From

            $user = $_POST['username'];
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $fullname = $_POST['fullname'];


            $shapass = sha1($pass);


            // Validate data from side server
            $arrayerror = array();


            if (empty($user)) {
                $arrayerror[] = " User Name Required ";

            }
            if (empty($pass)) {
                $arrayerror[] = " Password  Required ";

            }

            if (empty($email)) {
                $arrayerror[] = " Email Required ";
            }
            if (empty($fullname)) {
                $arrayerror[] = " Full Name Required ";
            }
            foreach ($arrayerror as $error)
                echo '<div class=" fa fa-warning alert alert-danger">' . $error . '</div>';

            if (empty($arrayerror)) {

                $check = checkItem("username", "users", $user);
                if ($check == 1) {
                    $msg = '<div class="alert alert-danger">This User Name already exist</div>';
                    redirectHome( $msg, 'back');
                } else {


                    $stmt = $con->prepare('INSERT INTO users
                                                            (username, password, email, fullname, regstatus,date)
                                                            VALUES (:zuser, :zpass, :zemail, :zfullname,1, now())');
                    $stmt->execute(array(
                        'zuser' => $user,
                        'zpass' => $shapass,
                        'zemail' => $email,
                        'zfullname' => $fullname,

                    ));


                    $msg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Update </div>';
                    redirectHome($msg, 'back');


                }


            }
        } else {
            $msg = 'you not allowed browser this page';
            redirectHome($msg);
        }


        // *********************************************** Edit Page ***************************************************

    } elseif ($do == 'edit') {
        // edit page
        // Check if GET Request userid Is Numeric & Get the Integer Value of it

        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        //Select All Data Depend on this ID

        $stmt = $con->prepare(" SELECT * FROM users WHERE userID = ? LIMIT 1 ");

        // Execute Query
        $stmt->execute(array($userid));
        // Fetch Data
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        //if id is found then show form
        if ($count > 0) {
            ?>
            <h1 class="text-center">Edit Members </h1>
            <div class="container">
                <form class="form-horizontal" action="?do=update" method="post">
                    <!-- user id -->
                    <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                    <!-- username -->
                    <div class="form-group">
                        <label class="col-md-2 control-label">User Name</label>
                        <div class="col-md-10">
                            <input type="text" name="username" class="form-control"
                                   value="<?php echo $row['username']; ?>" autocomplete="off" required="required">
                        </div>
                    </div>
                    <!-- Password -->
                    <div class="form-group">
                        <label class="col-md-2 control-label"> Password</label>
                        <div class="col-md-10">
                            <input type="password" name="newpassword" class="form-control" autocomplete="off">
                            <input type="hidden" name="oldpassword" value="<?php echo $row['password']; ?>">
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="form-group">
                        <label class="col-md-2 control-label"> Email</label>
                        <div class="col-md-10 ">
                            <input type="text" name="email" class="form-control" value="<?php echo $row['email']; ?>"
                                   autocomplete="off" required="required">
                        </div>
                    </div>
                    <!-- Full Name -->
                    <div class="form-group">
                        <label class="col-md-2 control-label">Full Name </label>
                        <div class="col-md-10">
                            <input type="text" name="fullname" class="form-control"
                                   value="<?php echo $row['fullname']; ?>" autocomplete="off" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-10 col-md-offset-2">
                            <input type="submit" class="btn btn-primary" value="Save">
                        </div>
                    </div>

                </form>

            </div>


            <?php
        } else {
            $msg = 'no number';
            redirectHome($msg);
        }
        // ****************************************** Update Page ******************************************************
    } elseif ($do == 'update') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo '<div class="container">';
            echo '<h1 class="text-center">Update  Members </h1>';
            // Get Variable from The From

            $id = $_POST['userid'];
            $user = $_POST['username'];
            $email = $_POST['email'];
            $fullname = $_POST['fullname'];


            // Password Track
            $pas = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);


            // Validate data from side server
            $arrayerror = array();


            if (empty($user)) {
                $arrayerror[] = " User Name Required ";
            }
            if (empty($email)) {
                $arrayerror[] = " Email Required ";
            }
            if (empty($fullname)) {
                $arrayerror[] = " Full Name Required ";
            }
            foreach ($arrayerror as $error)
                echo '<div class=" fa fa-warning alert alert-danger">' . $error . '</div>';

            if (empty($arrayerror)) {


                // Update Data in Data base

                $stmt = $con->prepare(" UPDATE users SET username = ?, email = ?, fullname = ?, password  = ?  WHERE  userID = ? ");
                $stmt->execute(array($user, $email, $fullname, $pas, $id));

                //echo success Message


                $msg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Update </div> ';
                redirectHome($msg, "back");

            }


        } else {
            $error = 'you are not allowed browser this page';
            redirectHome($error);
            echo '</div>';
        }
        //***************************************** Delete Page ********************************************************


    } elseif ($do == 'delete') {
        echo '<div class="container">';
        echo '<h1 class="text-center">Delete  Members </h1>';


        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        //check Depend on user id

        $_check = checkItem('userID', 'users', $userid);


        //if id is found then show form
        if ($_check > 0) {


            $stmt = $con->prepare('DELETE FROM users WHERE userID = :zuser');
            $stmt->bindParam(':zuser', $userid);
            $stmt->execute();


            $msg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Delete </div>';
            redirectHome($msg, 'back');
            echo '</div>';


        }


    } elseif ($do == 'active') {

        echo '<div class="container">';
        echo '<h1 class="text-center">Delete  Members </h1>';


        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        //check Depend on user id

        $_check = checkItem('userID', 'users', $userid);


        //if id is found then show form
        if ($_check > 0) {


            $stmt = $con->prepare('UPDATE  users SET regstatus = 1  WHERE userID = ?');
            $stmt->execute(array($userid));


            $msg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Update </div>';
            RedirectHome($msg, 'back');
            echo '</div>';


        }


        include $tpl . 'footer.php';


    } else {
        header('location: index.php ');
    }
}
ob_end_flush();
