<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#abc" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="dashboard.php"><?php  echo '<div class="x">'.lang('admin-home').'</div>';?></a>
        </div>
        <div class="collapse navbar-collapse" id="abc">
            <ul class="nav navbar-nav">
                <li><a href="categories.php"><?php  echo lang('CATEGORIES');?></a></li>
                <li><a href="items.php"><?php  echo lang('ITEMS');?></a></li>
                <li><a href="members.php"><?php  echo lang('MEMBERS');?></a></li>
                <li><a href="#"><?php  echo lang('STATISTICS');?></a></li>
                <li><a href="#"><?php  echo lang('LOGS');?></a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['username'];?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="members.php?do=edit&userid=<?php echo $_SESSION['id'] ?>">Edit Profile</a></li>
                        <li><a href="#">Settings</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>