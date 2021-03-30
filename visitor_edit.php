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
            /*html {
            position: relative;
            min-height: 100%;
            }body {*/
            /* Margin bottom by footer height */
            /*margin-bottom: 40px;
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
            }*/
            body
            {
                font-family: Arial;
                font-size: 10pt;
            }
            table
            {
                /*border: 1px solid #ccc;*/
                border-collapse: collapse; 
            }
            table th
            {
                /*background-color: #F7F7F7;*/
                color: #333;
                font-weight: bold;
            }
            table th, table td
            {
                padding: 5px;
                /*border: 1px solid #ccc;*/
            }
            .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
                border-top: none !important;
            }
            hr { 
                /*margin-top: 15px;*/
                margin-bottom: 10px;
                border: 0;
                border-top: 1px solid #000;
            }
        </style>
    </head>
    <?php include('header.php'); ?>
    <body  onload=display_ct();>
        <?php

            $success =0;
            $barcode = '';
            $valid = 0;
            $succ_msg = $err_msg = '';

            if(!$link){
                die("error". mysqli_link_error());
            }

            if (isset($_POST) && !empty($_POST) ) { 

                if (!empty($_POST['ID'])) { 
                    $ID = $_POST["ID"]; 
                } else{
                    $name_error = "Enter the ID Properly !"; 
                    $valid = 1;
                }  
                 

                if (!empty($_POST['name'])) { 
                    $name = $_POST["name"]; 
                } else{
                    $name_error = "Enter the Name Properly !"; 
                    $valid = 1;
                }

                if (!empty($_POST['Aadhaar_no'])) { 
                    $Aadhaar_no = $_POST["Aadhaar_no"]; 
                } else{
                    $Aadhaar_no_error = "Enter the Aadhaar Number Properly !"; 
                    $valid = 1;
                }

                if (!empty($_POST['DOB'])) { 
                    $DOB = $_POST["DOB"]; 
                } else{
                    $DOB_error = "Enter the Date Of Birth Properly !";
                    $valid = 1; 
                }

                if (!empty($_POST['address'])) { 
                    $address = $_POST["address"]; 
                } else{
                    $address_error = "Enter the Address Properly !"; 
                    $valid = 1;
                } 

                $sql2 = "SELECT * FROM info_visitor WHERE aadhar_no = '$Aadhaar_no' AND barcode_ID <> '$ID'";
                $result2 = mysqli_query($link, $sql2);
                $count2 = mysqli_num_rows($result2);  

                if ($valid == 0) {

                    if ($count2 ==0) { 
                        $sql = "UPDATE info_visitor SET barcode_ID = '$ID', name = '$name', aadhar_no = '$Aadhaar_no', dob = '$DOB', address = '$address'  WHERE barcode_ID = '$ID'"; 

                        if(mysqli_query($link,$sql)){
                            $succ_msg = 'Edit visitor successfully.';   
                        }else{
                            //echo "Error: " . $sql . "<br>" . mysqli_error($link);
                            $err_msg = 'Something wrong. Please try again.'; 
                        } 
                        //header('location: index.php');
                    }else{
                        $err_msg = 'This Aadhar number is already exist. Aadhar No.: '.$Aadhaar_no; 
                    }
                }

            }   

            if (isset($_REQUEST['eid']) && !empty($_REQUEST['eid'])) {

                $eid = $_REQUEST['eid'];

                $sql3 = "SELECT * FROM info_visitor WHERE id = '$eid'";
                $result3 = mysqli_query($link, $sql3);
                $count3 = mysqli_num_rows($result3);  
                $row3 = mysqli_fetch_assoc($result3); 

                if ($count3 == 0) { 
                    header('location: visitor.php');
                }
            } else{
                header('location: visitor.php');
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
                <h2>Edit Visitor</h2>
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
                <form class= "myForm" action= "" method= "POST" id ="form">
                    <?echo $displayError ;?>

                    <div class="form-group">
                        <label for="name"> ID :</label> 
                        <input class="form-control" type="text" name="ID" value="<?php echo $row3['barcode_ID'];?>"  id="ID"  readonly="">
                    </div>

                    <div class="form-group">
                        <label for="name"> Aadhaar Number :</label> 
                        <input autocomplete="off" class="form-control" type="text" name="Aadhaar_no" placeholder="Enter Visitor's Aadhaar Number." required="" id="Aadhaar_no"  value="<?php echo $row3['aadhar_no'];?>">
                    </div>

                    <div class="form-group">
                        <label for="name"> Name :</label> 
                        <input autocomplete="off" class="form-control" type="text" name="name" placeholder="Enter Visitor's Name." required="" id="name" value="<?php echo $row3['name'];?>" >
                    </div>

                    <div class="form-group">
                        <label for="name"> Date Of Birth :</label> 
                        <input autocomplete="off" class="form-control" type="date" name="DOB" placeholder="Enter Visitor's Date Of Birth." required="" id="DOB" value="<?php echo date('Y-m-d', strtotime($row3['dob']));?>" >
                    </div>

                    <div class="form-group">
                        <label for="name"> Address :</label>  
                        <textarea class="form-control" name="address" placeholder="Enter Visitor's Address." required="" id="address"> <?php echo $row3['address'];?></textarea>
                    </div>
                    
                    <div>
                        <input id="submitme" type="submit" name="submit_post" 
                            class="btn btn-success" value="Submit" />
                        <input autocomplete="off" id="mydata" type="hidden" name="mydata">
                    </div>
                </form>
            </div> 
        </div>    
    </body>
</html>