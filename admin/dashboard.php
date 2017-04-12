<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 31/03/17
 * Time: 11:59 م
 */

session_start();
$title = 'Dashboard';
if (isset($_SESSION['username'])) // if is session already  Register
{
    include 'init.php';


    ?>




     <div class="container">
         <h1>Dashboard</h1>
         <div class="home-stat text-center animated bounceIn">
             <div class="row">
                    <div class="col-md-3">
                        <div class="stat st-members ">
                        Total Members
                            <span><a href="members.php"> <?php echo CountItem("userID", "users")?></a></span>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="stat st-pending">
                        Pending Members
                            <span><a href="members.php?page=pending" ><?php echo CheckItem("regstatus","users",0)?></a></span>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="stat st-items">
                        Total Items
                        <span>63</span>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="stat st-comments">
                        Total Comments
                        <span>241</span>
                        </div>

                    </div>
             </div>
         </div>

     </div>
    <div class="container">
        <div class="latest">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-users"></i> Latest Users Added
                        </div>
                        <div class="panel-body">
                            <?php
                              $latest = getLatest("*", "users", "userID");
                              echo '<div class="list-unstyled latest-user" >';
                              foreach ($latest as $user){
                                  echo '<li>'
                                      .$user['username'].
                                      ' <div class="btn btn-info pull-right"><a href="members.php?do=edit&userid='.$user['userID'].'" >
                                        <i class="fa fa-edit"></i>Edit</a></div>';
                                  if ($user['regstatus'] == 0) {

                                      echo '
                                        <a href="members.php?do=active&userid=' . $user['userID'] . '" class="btn btn-success pull-right"> activate </a>';
                                  }
                                  echo '</li>';

                              }
                              echo '</div>';
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tags"></i> Latest Items
                        </div>
                        <div class="panel-body">
                            test
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>








  <?php  include $tpl.'footer.php';

}else {
    header('location: index.php ');
}