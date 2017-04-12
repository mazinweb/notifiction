<?php
/**
 * Created by PhpStorm.
 * User: yaseen
 * Date: 09/04/17
 * Time: 03:38 م
 */

ob_start();
session_start();

$title = 'Categories';

if(isset($_SESSION['username'])){

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage'){

        // manage page ************************************************************************************************

        $sort = '';
        $order_r = array('ASC','DESC');
        if (isset($_GET['sort']) && in_array($_GET['sort'],$order_r)){
            $sort = $_GET['sort'];
        }

        $stmt = $con->prepare("select * from categories ORDER BY ordering $sort");
        $stmt->execute();
        $cats=$stmt->fetchAll(); ?>


          <h1 class="text-center">Manage Categories</h1>
          <div class="container cats">
              <div class="panel panel-default">
                  <div class="panel-heading">
                      Manage Categories
                      <div class="option pull-right">
                          ordering :
                          <a class="fa fa-sort-asc <?php if ($sort == "ASC"){ echo 'active'; }?>" href="categories.php?sort=ASC" > Asc </a>
                          <a class="fa fa-sort-desc <?php if ($sort == "DESC"){ echo 'active'; }?>" href="categories.php?sort=DESC">Desc </a>
                          View:
                          <span class="active" data-view="full">full</span>
                          <span >Classic</span>

                      </div>
                  </div>
                  <div class="panel-body">
                      <?php
                      foreach ($cats as $cat){
                          echo '<div class="cat">';
                                  echo '<div class="hidden-btn">';
                                       echo '<a href="categories.php?do=edit&catid='.$cat['id'].'" class="btn btn-primary btn-xs fa fa-edit"></a>';
                                       echo '<a href="categories.php?do=delete&catid='.$cat['id'].'" class="confirm  btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>';
                                  echo '</div>';
                                       echo '<h3>'. $cat['name'].'</h3>';
                                  echo '<div class="view">';
                                        if ($cat['description'] == ""){ echo '<p> This Category has no Description </p>'; }else{echo '<p>'.$cat['description'].'</p>';}
                                        if ($cat['visibility'] == 1){echo '<span class="vis">Hidden</span>';}
                                        if ($cat['allow_comment'] == 1){echo '<span class="com">Comment disabled</span>';}
                                        if ($cat['allow_ads'] == 1){echo '<span class="ads">ads disabled</span>';}
                                  echo '</div>';
                          echo '<hr></div>';
                      }
                      ?>
                  </div>
              </div>
              <a href="categories.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Categories</a>
          </div>


                                <?php
    }elseif ($do == 'add'){

        // add page*****************************************************************************************************
        ?>

        <h1 class="text-center">Add Ctegories </h1>
        <div class="container">
            <form class="form-horizontal" action="?do=insert" method="post">
                <!-- name -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Name</label>
                    <div class="col-md-10">
                        <input type="text" name="name" class="form-control" autocomplete="off" required="required">
                    </div>
                </div>
                <!-- description -->
                <div class="form-group">
                    <label class="col-md-2 control-label"> Description</label>
                    <div class="col-md-10">
                        <input type="text" name="desc" class=" form-control">

                    </div>
                </div>
                <!-- ordering -->
                <div class="form-group">
                    <label class="col-md-2 control-label"> Ordering</label>
                    <div class="col-md-10 ">
                        <input type="text" name="order" class="form-control">
                    </div>
                </div>
                <!--  visibility  -->
                <div class="form-group">
                    <label class="col-md-2 control-label"> Visibility  </label>
                    <div class="col-md-10">
                        <div>
                            <input type="radio" name="vis" id="vis-yes" value="0" checked>
                            <label for="vis-yes">Yes</label>
                        </div>
                        <div>
                            <input type="radio" name="vis" id="vis-no" value="1">
                            <label for="vis-no">No</label>
                        </div>
                    </div>
                </div>
                <!--  allow comment  -->
                <div class="form-group">
                    <label class="col-md-2 control-label"> commenting  </label>
                    <div class="col-md-10">
                        <div>
                            <input type="radio" name="com" id="com-yes" value="0" checked>
                            <label for="com-yes-yes">Yes</label>
                        </div>
                        <div>
                            <input type="radio" name="com" id="com-no" value="1">
                            <label for="com-no">No</label>
                        </div>
                    </div>
                </div>
                <!--  allow ads  -->
                <div class="form-group">
                    <label class="col-md-2 control-label"> Ads  </label>
                    <div class="col-md-10">
                        <div>
                            <input type="radio" name="ads" id="ads-yes" value="0" checked>
                            <label for="ads-yes">Yes</label>
                        </div>
                        <div>
                            <input type="radio" name="ads" id="ads-no" value="1">
                            <label for="ads-no">No</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-10 col-md-offset-2">
                        <button type="submit" class=" btn btn-primary"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>

            </form>

        </div>


        <?php
    }elseif ($do == 'insert'){

        //insert page**************************************************************************************************

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<div class="container">';
            // Get Variable from The From

            $name = $_POST['name'];
            $desc = $_POST['desc'];
            $order = $_POST['order'];
            $vis = $_POST['vis'];
            $com = $_POST['com'];
            $ads = $_POST['ads'];


            $check = checkItem("name", "categories", $name);
            if ($check == 1) {
                $msg = '<div class="alert alert-danger">This Categories Name already exist</div>';
                redirectHome($msg, 'back');
            } else {


                $stmt = $con->prepare('INSERT INTO categories 
                                                            (name, description, ordering, visibility, allow_comment,allow_ads)
                                                            VALUES (?, ?, ?, ?, ?, ?)');
                $stmt->execute(array(
                    $name,
                    $desc,
                    $order,
                    $vis,
                    $com,
                    $ads


                ));


                $msg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Added </div>';
                redirectHome($msg, 'back');


            }


        }else {
            $msg = 'you not allowed browser this page';
            redirectHome($msg);
        }


    }elseif ($do == 'edit'){

        //edit page ****************************************************************************************************



        // Check if GET Request userid Is Numeric & Get the Integer Value of it

        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

        //Select All Data Depend on this ID

        $stmt = $con->prepare(" SELECT * FROM categories  WHERE id = ? ");

        // Execute Query
        $stmt->execute(array($catid));
        // Fetch Data
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        //if id is found then show form
        if ($count > 0) {
            ?>
            <h1 class="text-center">Edit Categories </h1>
            <div class="container">
                <form class="form-horizontal" action="?do=update" method="post">
                    <!-- name -->
                    <div class="form-group">
                        <label class="col-md-2 control-label">Name</label>
                        <div class="col-md-10">
                            <input type="text" name="name" class="form-control" required="required" value="<?php echo $row['name'];?>">
                            <input type="hidden" name="id" value="<?php echo $catid;?>">
                        </div>
                    </div>
                    <!-- description -->
                    <div class="form-group">
                        <label class="col-md-2 control-label"> Description</label>
                        <div class="col-md-10">
                            <input type="text" name="desc" class=" form-control" value="<?php echo $row['description'];?>">

                        </div>
                    </div>
                    <!-- ordering -->
                    <div class="form-group">
                        <label class="col-md-2 control-label"> Ordering</label>
                        <div class="col-md-10 ">
                            <input type="text" name="order" class="form-control" value="<?php echo $row['ordering'];?>">
                        </div>
                    </div>
                    <!--  visibility  -->
                    <div class="form-group">
                        <label class="col-md-2 control-label"> Visibility  </label>
                        <div class="col-md-10">
                            <div>
                                <input type="radio" name="vis" id="vis-yes" value="0" <?php if ($row['visibility'] == 0){echo 'checked';} ?> >
                                <label for="vis-yes">Yes</label>
                            </div>
                            <div>
                                <input type="radio" name="vis" id="vis-no" value="1" <?php if ($row['visibility'] == 1){echo 'checked';} ?>  >
                                <label for="vis-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!--  allow comment  -->
                    <div class="form-group">
                        <label class="col-md-2 control-label"> commenting  </label>
                        <div class="col-md-10">
                            <div>
                                <input type="radio" name="com" id="com-yes" value="0" <?php if ($row['allow_comment'] == 0){echo 'checked';} ?>  >
                                <label for="com-yes-yes">Yes</label>
                            </div>
                            <div>
                                <input type="radio" name="com" id="com-no" value="1" <?php if ($row['visibility'] == 1){echo 'checked';} ?> >
                                <label for="com-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!--  allow ads  -->
                    <div class="form-group">
                        <label class="col-md-2 control-label"> Ads  </label>
                        <div class="col-md-10">
                            <div>
                                <input type="radio" name="ads" id="ads-yes" value="0" <?php if ($row['allow_ads'] == 0){echo 'checked';} ?>  >
                                <label for="ads-yes">Yes</label>
                            </div>
                            <div>
                                <input type="radio" name="ads" id="ads-no" value="1" <?php if ($row['allow_ads'] == 1){echo 'checked';} ?>  >
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-10 col-md-offset-2">
                            <input type="submit" class="btn btn-primary" value="Update">
                        </div>
                    </div>

                </form>

            </div>


            <?php
        } else {
            $msg = '<div class="alert alert-danger">no number</div>>';
            redirectHome($msg);
        }

    }elseif ($do == 'update'){

        // update page *********************************************************************************************

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo '<div class="container">';
            echo '<h1 class="text-center">Update  Categories </h1>';
            // Get Variable from The From

            $id = $_POST['id'];
            $name = $_POST['name'];
            $desc = $_POST['desc'];
            $order = $_POST['order'];
            $vis = $_POST['vis'];
            $com = $_POST['com'];
            $ads = $_POST['ads'];



                // Update Data in Data base

                $stmt = $con->prepare(" UPDATE categories 
                                                  SET 
                                                     name            = ?,
                                                     description     = ?, 
                                                     ordering        = ?, 
                                                     visibility      = ?, 
                                                     allow_comment   = ?,
                                                     allow_ads       = ?
                                                  WHERE 
                                                     id = ? ");
                $stmt->execute(array($name, $desc, $order, $vis, $com, $ads, $id));

                //echo success Message


                $msg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Update </div> ';
                redirectHome($msg, "back");




        } else {
            $error = 'you are not allowed browser this page';
            redirectHome($error);
            echo '</div>';
        }

    }elseif ($do == 'delete'){

        //delete page***********************************************************************************************
        echo '<div class="container">';
        echo '<h1 class="text-center">Delete  Members </h1>';


        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

        //check Depend on user id

        $_check = checkItem('id', 'categories', $catid );


        //if id is found then show form
        if ($_check > 0) {


            $stmt = $con->prepare('DELETE FROM categories  WHERE id = :zuser');
            $stmt->bindParam(':zuser', $catid);
            $stmt->execute();


            $msg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Delete </div>';
            redirectHome($msg, 'back');
            echo '</div>';


        }else {
            $ms = '<div class="alert alert-danger">This Id is not found </div>';
        }

    }

    include $tpl . 'footer.php';


}else{
    header('location: index.php');

    exit();
}
ob_end_flush();