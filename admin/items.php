<?php
    /**
     * Created by PhpStorm.
     * User: yaseen
     * Date: 09/04/17
     * Time: 03:38 م
     */

    ob_start();
    session_start();

    $title = 'Items';

    if(isset($_SESSION['username'])){

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

        if ($do == 'manage'){

            // manage page

        }elseif ($do == 'add'){

            // add page*************************************************************************************************
                        ?>

            <h1 class="text-center">Add Items </h1>
            <div class="container">
                <form class="form-horizontal" action="?do=insert" method="post">
                <!-- name -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Name</label>
                    <div class="col-md-10">
                        <input type="text" name="name" class="form-control" autocomplete="off" required="required">
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Name</label>
                    <div class="col-md-10">
                        <input type="text" name="desc" class="form-control" autocomplete="off" required="required">
                    </div>
                </div>

                <!-- Price -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Price</label>
                    <div class="col-md-10">
                        <input type="text" name="price" class="form-control" autocomplete="off" required="required">
                    </div>
                </div>

                <!-- Country -->

                <div class="form-group">
                    <label class="col-md-2 control-label">Price</label>
                    <div class="col-md-10">
                        <input type="text" name="price" class="form-control" autocomplete="off" required="required">
                    </div>
                </div>

                <!-- Status -->

                <div class="form-group">
                    <label class="col-md-2 control-label">Status</label>
                    <div class="col-md-10">
                       <select class="form-control" name="country">
                            </option>
                           <option value="0"> ... </option>
                           <option value="1">New</option>
                           <option value="2">Like New </option>
                           <option value="3">used</option>
                           <option value="4">old</option>

                       </select>
                    </div>
                </div>



                <!-- Status -->

                <div class="form-group">
                    <div class="col-md-10 col-md-offset-2">
                        <button type="submit" class=" btn btn-primary"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>

            </form>

        </div>
                <?php

    }elseif ($do == 'insert'){

        //insert page

    }elseif ($do == 'edit'){

        //edit page

    }elseif ($do == 'update'){

        // update page

    }elseif ($do == 'delete'){

        //delete page

    }elseif ($do == 'activate'){

        // activate page
    }
    include $tpl.'footer.php';


  }else{
    header('location: index.php');

    exit();
  }
ob_end_flush();