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

            if (isset($_POST) && !empty($_POST)) {  

                //echo "<pre>"; print_r($_POST); exit;

                if (!empty($_POST['ID'])) {
                    $barcode = generateBarcode($data = array('ID'=>$_POST['ID']), 'tmp');
                    $barcode_name = basename($barcode);
                    $ID = $_POST["ID"]; 
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

                $sql1 = "SELECT * FROM info_visitor WHERE barcode_ID = '$ID'"; 
                $result1 = mysqli_query($link, $sql1);
                $count1 = mysqli_num_rows($result1); //exit;

                $sql2 = "SELECT * FROM info_visitor WHERE aadhar_no = '$Aadhaar_no'";
                $result2 = mysqli_query($link, $sql2);
                $count2 = mysqli_num_rows($result2);  

                if ($valid == 0 && $count1 ==0) {

                    if ($count2 ==0) { 
                        $sql = "INSERT INTO info_visitor(barcode_ID, name, aadhar_no, dob, address, status, barcode) VALUES ('$ID','$name','$Aadhaar_no','$DOB',
                        '$address', 1, '$barcode_name')";

                        if(mysqli_query($link,$sql)){
                            $succ_msg = 'Add new visitor successfully.';   
                            $last_id = mysqli_insert_id($link); 
                            $sql_info = "SELECT * FROM info_visitor WHERE id = '$last_id'";
                            $result_info = mysqli_query($link, $sql_info);
                            $count_info = mysqli_num_rows($result_info);
                            $row_info = mysqli_fetch_assoc($result_info); 
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
        ?> 
        <!-- create PDF --> 
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
        <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
        <script>  
            $( document ).ready(function() {  
                var bs = $('#barcode_print'),  
                 cache_width = bs.width(),   
                 a4 = [595.28, 2000]; // for a4 size paper width and height  
          
                $('#print_btn').on('click', function () {  
                    $('body').scrollTop(0);  
                    createPDF();  
                });  
                 
                //create pdf  
                function createPDF() { 
                     
                    getCanvas().then(function (canvas) {  
                        var  
                         img = canvas.toDataURL("image/png"),  
                         doc = new jsPDF({  
                             unit: 'px',  
                             format: 'a4',
                             compress: true  
                         });   
                        doc.addImage(img, 'JPEG', 20, 20);   
                        //doc.save('Bhavdip-html-to-pdf.pdf');  
                        //doc.output('dataurlnewwindow');
                        var string = doc.output('datauristring');
                        var embed = "<embed width='100%' height='100%' src='" + string + "'/>"
                        var x = window.open();
                        x.document.open();
                        x.document.write(embed);
                        x.document.close();  
                        //bs.width(cache_width);  
                    });  
                }  
          
                // create canvas object  
                function getCanvas() {  
                    /*bs.width((a4[0] * 1.33333) - 80).css('max-width', 'none'); 
                    bs.height((a4[0] * 1.33333) - 80).css('max-width', 'none');  */
                    bs.width((450 * 1.33333) - 80).css('max-width', 'none');  
                    bs.height((450 * 1.33333) - 80).css('max-width', 'none');  
                    return html2canvas(bs[0], {  
                        imageTimeout: 2000,  
                        removeContainer: true  
                    });  
                }    
            });

        </script>  
        <script>  
            /* 
         * jQuery helper plugin for examples and tests 
         */  
            (function ($) {  
                $.fn.html2canvas = function (options) {  
                    var date = new Date(),  
                    $message = null,  
                    timeoutTimer = false,  
                    timer = date.getTime();  
                    html2canvas.logging = options && options.logging;  
                    html2canvas.Preload(this[0], $.extend({  
                        complete: function (images) {  
                            var queue = html2canvas.Parse(this[0], images, options),  
                            $canvas = $(html2canvas.Renderer(queue, options)),  
                            finishTime = new Date();  
          
                            $canvas.css({ position: 'absolute', left: 0, top: 0 }).appendTo(document.body);  
                            $canvas.siblings().toggle();  
          
                            $(window).click(function () {  
                                if (!$canvas.is(':visible')) {  
                                    $canvas.toggle().siblings().toggle();  
                                    throwMessage("Canvas Render visible");  
                                } else {  
                                    $canvas.siblings().toggle();  
                                    $canvas.toggle();  
                                    throwMessage("Canvas Render hidden");  
                                }  
                            });  
                            throwMessage('Screenshot created in ' + ((finishTime.getTime() - timer) / 1000) + " seconds<br />", 4000);  
                        }  
                    }, options));  
          
                    function throwMessage(msg, duration) {  
                        window.clearTimeout(timeoutTimer);  
                        timeoutTimer = window.setTimeout(function () {  
                            $message.fadeOut(function () {  
                                $message.remove();  
                            });  
                        }, duration || 2000);  
                        if ($message)  
                            $message.remove();  
                        $message = $('<div ></div>').html(msg).css({  
                            margin: 0,  
                            padding: 10,  
                            background: "#000",  
                            opacity: 0.7,  
                            position: "fixed",  
                            top: 10,  
                            right: 10,  
                            fontFamily: 'Tahoma',  
                            color: '#fff',  
                            fontSize: 12,  
                            borderRadius: 12,  
                            width: 'auto',  
                            height: 'auto',  
                            textAlign: 'center',  
                            textDecoration: 'none'  
                        }).hide().fadeIn().appendTo('body');  
                    }  
                };  
            })(jQuery);  
          
        </script> 
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
                <h2>Add Visitor</h2>
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
                <form class= "myForm" action= "<?php echo $_SERVER["PHP_SELF"];?>" method= "POST" id ="form">
                    <?echo $displayError ;?>

                    <div class="form-group">
                        <label for="name"> ID :</label> 
                        <input class="form-control" type="text" name="ID" value="<?php echo mt_rand(100000,999999);  ?>"  id="ID"  readonly="">
                    </div>

                    <div class="form-group">
                        <label for="name"> Aadhaar Number :</label> 
                        <input autocomplete="off" class="form-control" type="text" name="Aadhaar_no" placeholder="Enter Visitor's Aadhaar Number." required="" id="Aadhaar_no"  >
                    </div>

                    <div class="form-group">
                        <label for="name"> Name :</label> 
                        <input autocomplete="off" class="form-control" type="text" name="name" placeholder="Enter Visitor's Name." required="" id="name"  >
                    </div>

                    <div class="form-group">
                        <label for="name"> Date Of Birth :</label> 
                        <input autocomplete="off" class="form-control" type="date" name="DOB" placeholder="Enter Visitor's Date Of Birth." required="" id="DOB"  >
                    </div>

                    <div class="form-group">
                        <label for="name"> Address :</label>  
                        <textarea class="form-control" name="address" placeholder="Enter Visitor's Address." required="" id="address"></textarea>
                    </div>
                    
                    <div>
                        <input id="submitme" type="submit" name="submit_post" 
                            class="btn btn-success" value="Submit" />
                        <input autocomplete="off" id="mydata" type="hidden" name="mydata">
                    </div>
                </form>
            </div>

            <div class="col-sm-8"> 
                <!--startprint-->
                <div>
                <?php 
                    if( $barcode !='' && isset($_POST) && $count1 ==0 && $count2 ==0) { ?> 
                        <div style="text-align: right;"><a href="javascript:void(0);"  id="print_btn" class="btn btn-default"><i class="fa fa-print"></i> Print</a></div><br>
                        <div class="table-responsive" id="barcode_print" style="font-size: 12px;">
                            <!-- <div style="text-align: left;"><img src="img/150x150.png"></div><br><br><br><br> --> 
                            <!-- <div style="text-align: center;"><h3>LABOUR PASS</h3></div><hr> -->
                            <div class="col-md-8">
                                <table class="table">
                                    <tbody> 
                                        <tr>
                                            <th style="line-height: 1px;font-size: 11px !important;">Number</th>
                                            <td style="line-height: 1px;font-size: 12px !important;">: <?php echo $row_info['barcode_ID']; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="line-height: 1px;font-size: 12px !important;">Barcode</th>
                                            <td style="line-height: 1px;font-size: 12px !important;">: <img src="tmp/<?php echo $row_info['barcode']; ?>" style="width: 150px;" /><br>&nbsp; <?php //echo $row_info['barcode_ID'] ?></td>
                                        </tr>
                                        <!-- <tr>
                                            <th>Aadhar Number</th>
                                            <td>: <?php //echo $row_info['aadhar_no']; ?></td>
                                        </tr> -->
                                        <tr>
                                            <th style="line-height: 1px;font-size: 12px !important;">Name</th>
                                            <td style="line-height: 1px;font-size: 12px !important;">: <?php echo $row_info['name']; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="line-height: 1px;font-size: 12px !important;">DOB</th>
                                            <td style="line-height: 1px;font-size: 12px !important;">: <?php echo $row_info['dob']; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="font-size: 12px !important;">Address</th>
                                            <td style="font-size: 12px !important;">: <?php echo $row_info['address']; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="line-height: 1px;font-size: 12px !important;">Date</th>
                                            <td style="line-height: 1px;font-size: 12px !important;">: <?php echo $row_info['created_at']; ?></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <img src="img/150x150.png">
                            </div>
                        </div>
                <?php } ?>
                </div>
                <!--endprint-->
            </div>
        </div>    
    </body>
</html>