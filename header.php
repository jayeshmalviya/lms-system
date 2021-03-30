<?php 
date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$end_url = array_slice(explode('/', $actual_link), -1)[0];
?>
<!-- Left and right controls -->
<nav class="navbar navbar-default"  data-offset-top="228">
    <div class="container-fluid">
        <div class="navbar-header">
            <!-- <a class="navbar-brand" href="#" id = "lii"><span  >LMS MANAGEMENT</span></a> -->
        </div>
        <ul class="nav navbar-nav navbar-right">
            <?php 
             
                if($_SESSION["role"] == 'admin' || $_SESSION["role"] == 'gate'){  
            ?>
                <li class="<?php if($end_url =='front.php'){echo 'active';}?>" ><a id="li" href="<?php echo $base_url; ?>/lms-system/front.php">Home</a></li>
            <?php 
                }  
                if($_SESSION["role"] == 'admin'){  
            ?>
                <li class="<?php if($end_url =='add_visitor.php'){echo 'active';}?>" ><a id="li" href="<?php echo $base_url; ?>/lms-system/add_visitor.php" >Add Visitor</a></li>
                <!-- <li><a id = "li" href="logoutform.php" >Checked Out Visitors</a></li> -->
                <li class="<?php if($end_url =='visitors.php'){echo 'active';}?>" ><a id="li" href="<?php echo $base_url; ?>/lms-system/visitors.php" >View Visitor</a></li>
            <?php } ?>
            <li class="<?php if($end_url =='logout.php'){echo 'active';}?>" ><a id="li" href="<?php echo $base_url; ?>/lms-system/logout.php" >Logout</a></li>
            <li><a id="li" href="javascript:void(0)" ><img src="defaultPic.jpg" class="user-image" alt="User Image" style="  width: 25px;height: 25px;"> <?php echo $user_; ?></a></li>
        </ul>
    </div> 
</nav> 
