<?php 
    require_once "function.php";
    include('db_connect_Login.php');  
    session_start();  
    if($_SESSION["loggedIn"] == 0)
        header("location: index.php");
      $user_ = $_SESSION["user"];
    
    ?>
<html>
    <head>
        <!--  <meta http-equiv = "refresh" content = "10;url= front.php"/>  -->
        <link rel = "stylesheet" href= "BootStrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="navbar3.css">
        <script src="BootStrap/js/jQuery.min.js"></script>
        <script src= "BootStrap/js/bootstrap.min.js"></script>
        <script src="BootStrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="webcam/webmaster/webcam.js"></script>
        <style>
            html {
            position: relative;
            min-height: 100%;
            }body {
            /* Margin bottom by footer height */
            margin-bottom: 40px;
            }#head{
            text-decoration:underline;
            }input:required:invalid, input:focus:invalid, input:invalid {
            border-radius: 5px;
            border:soild 1px;
            }input:required:valid, input:valid {
            border-radius: 5px;
            }input[type='number'] {
            -moz-appearance:textfield;
            }input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            }.affix {
            top:0;
            width: 100%;
            z-index: 9999 !important;
            }
        </style>
    </head>
    <?php include('header.php'); ?>
    <body  onload=display_ct();>
        <?php

            $success =0;
            $barcode = '';
            $valid = 0;
            $succ_msg = $err_msg = $name_error = '';

            if(!$link){
                die("error". mysqli_link_error());
            }

            if (isset($_POST) && !empty($_POST)) {  

                //echo "<pre>"; print_r($_POST); exit;

                if (!empty($_POST['ID'])) { 
                    $ID = $_POST["ID"]; 

                    $current_date = date('Y-m-d');
                    $in_time = date("Y-m-d H:i:s");

                    $sql1 = "SELECT * FROM info_visitor WHERE barcode_ID = '$ID'";
                    $result1 = mysqli_query($link, $sql1);
                    $count1 = mysqli_num_rows($result1); //exit;
                    $row_info = mysqli_fetch_assoc($result1);
                
                } else{
                    $name_error = "Enter the ID Properly !"; 
                    $valid = 1;
                }  

                if ($valid == 0 && $count1 ==1) {

                    if ($row_info['status'] == 1) { 

                        $name = $row_info['name'];
                        $aadhar_no = $row_info['aadhar_no']; 

                        $sql2 = "SELECT * FROM in_out_visitor_info WHERE barcode_id = '$ID' ORDER BY id DESC ";
                        $result2 = mysqli_query($link, $sql2);
                        $count2 = mysqli_num_rows($result2);  
                        $row_info2 = mysqli_fetch_assoc($result2);
                        /*echo date('Y-m-d');
                        echo"<pre>"; print_r($row_info2); exit;*/

                        if ( $count2 > 0 && date("Y-m-d", strtotime($row_info2['in_time'])) == date('Y-m-d')  && $row_info2['out_time'] == '0000-00-00 00:00:00') {
                            $err_msg = 'This visitor is already in1.'; 
                        } else if ( $count2 > 0 && $row_info2['in_time'] != '0000-00-00 00:00:00'  && date("Y-m-d", strtotime($row_info2['in_time'])) == date('Y-m-d') && $row_info2['out_time'] == '0000-00-00 00:00:00') {
                            $err_msg = 'This visitor is already in2.'; 
                        } else { 

                            $sql = "INSERT INTO in_out_visitor_info(barcode_id, name, aadhar_no, in_time, status) VALUES ('$ID','$name','$aadhar_no','$in_time', 1)";

                            if(mysqli_query($link,$sql)){
                                $succ_msg = 'Add In Time visitor successfully.';   
                                 
                            }else{
                                //echo "Error: " . $sql . "<br>" . mysqli_error($link);
                                $err_msg = 'Something wrong. Please try again.'; 
                            } 
                            //header('location: index.php');
                        }
                    } else {
                        $err_msg = 'This visitor is currently Inactive. ID: '.$ID; 
                    }
                } else {
                    $err_msg = 'This visitor not found our record. ID: '.$ID;
                }

            }   
        ?>  
         
        <!-- time and date script --> 
        <script type="text/javascript"> 
            function display_c(){
            var refresh=1000; // Refresh rate in milli seconds
            mytime=setTimeout('display_ct()',refresh)
            }
            function display_ct() {
                  var date = new Date();
                    var hours = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
                    var am_pm = date.getHours() >= 12 ? "PM" : "AM";
                    hours = hours < 10 ? "0" + hours : hours;
                    var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
                    var seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
                    time = hours + ":" + minutes + ":" + seconds + " " + am_pm;
            document.getElementById('t1').innerHTML = time;
            var x = new Date()
            var x1=x.getMonth() + 1+ "/" + x.getDate() + "/" + x.getFullYear();
            document.getElementById('t2').innerHTML = x1;
            display_c();
            } 
        </script>  

        <div class="row" style="margin: 20px;">
            <div style= "float:right; margin: 20px;">
                <p id = "timeDisplay" > Time : <span id="t1"></span></p>
                <p id = "dateDisplay"> Date : <span id="t2"></span></p>
            </div>
            <div style="margin: 20px;">
                <h2>Add In Time Visitor</h2>
                <p id = "redBoxSyndrome">
                <p>
            </div>
            <div class="col-sm-12">
                <?php if($succ_msg !=''){ ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Success!</h4>
                        <?php echo $succ_msg; ?>
                    </div>
                <?php } ?>
                <?php if($err_msg !=''){ ?>
                    <div class="alert alert-danger  alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Error!</h4>
                        <?php echo $err_msg; ?>
                    </div>
                <?php } ?>
            </div>
            <div class="col-sm-4">
                <form autocomplete="off" class= "myForm" action= "<?php echo $_SERVER["PHP_SELF"];?>" method= "POST" id ="form">
                    <?echo $displayError ;?>

                    <div class="form-group">
                        <label for="name"> Barcode / ID :</label> 
                        <input class="form-control" type="text" name="ID" value=""  id="ID" required="" autofocus autocomplete="off">
                        <small>Please scan barcode or type ID.</small>
                        <p><small style="color: red"><?php echo $name_error; ?></small></p>
                    </div> 
                    
                    <div>
                        <a href="front.php" class="btn btn-primary">Back</a>
                        <input id="submitme" type="submit" name="submit_post" 
                            class="btn btn-success" value="Add In Time" />
                        <input autocomplete="off" id="mydata" type="hidden" name="mydata">
                    </div>
                </form> 
            </div>
 
        </div>    
    </body>
</html>