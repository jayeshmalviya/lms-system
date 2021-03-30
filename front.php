<?php  
    include('db_connect_Login.php');
    include('visitor_out.php');
    
    $user_ = $_SESSION["user"];
    
    if($_SESSION["loggedIn"] == 0){ 
        header("location: index.php");
    }

    $succ_msg = $err_msg = ''; 
    
    $sql1 = "SELECT * FROM in_out_visitor_info WHERE status = 1 ORDER BY id DESC";
    $result1 = mysqli_query($link, $sql1);
    $count1 = mysqli_num_rows($result1);  

    /*if (isset($_REQUEST['did']) && !empty($_REQUEST['did'])) {
        $did = $_REQUEST['did'];
        $sq2 = "DELETE FROM in_out_visitor_info WHERE id = '$did'";
   
        if (mysqli_query($link, $sq2)) {
            $succ_msg = "Record deleted successfully";
        } else {
            $err_msg = "Something wrong. Please try again.";
        }
    } */  
    
    ?>
<!DOCTYPE HTML5>
<html>
    <head>
        <link rel = "stylesheet" href= "BootStrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="navbar3.css">
        <script src="BootStrap/js/jQuery.min.js"></script>
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
    <body> 
    <?php include('header.php'); ?>
        <div class="container"> 
            <div class="row">
                <div class="col-md-12">
                    <!-- <h2>LMS Management</h2> -->
                    <p></p>
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
                            <h4><i class="icon fa fa-ban"></i> Success!</h4>
                            <?php echo $err_msg; ?>
                        </div>
                    <?php } ?>
                </div> 
                <div class="col-md-12 text-right" >
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <a href="in_time_visitor.php" class="btn btn-success">In Time</a>
                        <a href="out_time_visitor.php" class="btn btn-success">Out Time</a>
                    </div> 
                </div>
                <div class="col-md-12" style="margin-top: 30px;">
                    <div class="col-md-12 text-right input-group input-daterange">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"> 
                            <label>From Date: </label>
                            <input type="text" id="min-date" class="date-range-filter" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd"> 
                        </div>
                        <div class="col-md-4"> 
                            <label>To Date: </label>
                            <input type="text" id="max-date" class="date-range-filter" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
                            <button id="reset-date">Reset</button>
                        </div>
                    </div><br> 
                    <!-- <a href="#" id="Export">Export</a> -->  
                    <table class="table" id="vts_table1">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>ID</th>
                                <th>Barcode</th>
                                <th>Name</th>
                                <th>Aadhar Number</th>
                                <th>In Time</th>
                                <th>Out Time</th>
                                <th>Total Hrs</th>
                                <th>Status</th>
                                <th>Date</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if ($count1 > 0) {  
                                    $i = 0;
                                    while ($row = mysqli_fetch_assoc($result1)) {
                                        $i++;
                                        $barcode_id = $row['barcode_id'];
                                        $sql2 = "SELECT * FROM info_visitor WHERE status = 1 AND barcode_ID = '$barcode_id'";
                                        $result2 = mysqli_query($link, $sql2);
                                        $count2 = mysqli_num_rows($result2);  
                                        if($count2>0){
                                            $row2 = mysqli_fetch_assoc($result2);

                                            $path = "tmp/".$row2['barcode'];
                                            $type = pathinfo($path, PATHINFO_EXTENSION);
                                            $data = file_get_contents($path);
                                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['barcode_id']; ?></td>
                                <!-- <td><img class="bar_img" src="http://localhost/lms-system/tmp/<?php //echo $row2['barcode'] ?>" style="width: 200px;"></td> -->
                                <td><img class="bar_img" src="<?php echo $base64 ?>" style="width: 200px;"></td>
                                <td><?php echo $row['name']; ?></td>   
                                <td><?php echo $row['aadhar_no']; ?></td>
                                <td><?php echo (!empty($row['in_time']))?date("H:i:s", strtotime($row['in_time'])):'' ?></td>   
                                <td><?php echo (!empty($row['out_time']))?date("H:i:s", strtotime($row['out_time'])):'' ?></td>   
                                <td><?php echo $row['total_hrs']; ?></td>   
                                <td><?php echo ($row['status']==1)?'Active':'Inactive'; ?></td>   
                                <td><?php echo $row['created_at']; ?></td>   
                                <!-- <td><a class="btn btn-primary" href="in_out_info_edit.php?eid=<?php //echo $row['id']; ?>">Edit</a> <a class="btn btn-danger" href="?did=<?php //echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a></td>  -->
                            </tr> 
                            <?php 
                                        } else { /*echo '<tr>No record found.</tr>';*/ }
                                    }
                                } else { /*echo '<tr>No record found.</tr>';*/ } 
                            ?>
                           
                        </tbody>
                    </table> 
                    
                </div>
            </div>    
        </div> 
    <body/>
<html/>
<!-- Data Table --> 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script> 
<!-- data table export -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script> 
<!-- <script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.24/filtering/row-based/range_dates.js"></script>  -->

<script src="jquery.table2excel.js"></script>
<script src="jquery.table2excel.min.js"></script>
 
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>


<script type="text/javascript">
    $(document).ready(function() {

        var role = "<?php echo $_SESSION['role']; ?>";
         
        if(role != 'admin'){ 
            setTimeout(function(){
                $('.dt-buttons').hide();
            }, 1000);
        }

        $("#reset-date").click(function(){
            $('.date-range-filter').val("").datepicker("update");
        })

        // Bootstrap datepicker
        $('.input-daterange input').each(function() {
          $(this).datepicker( {
             autoclose: true,
             todayHighlight: true
          });
        });

        var table = $('#vts_table1').DataTable( {
            processing: true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            order: [],
            dom: 'Bfrtip',
            buttons: [
                //'copy', 'csv', 'excel', 'pdf', 'print'
                //'excel', 'pdf'
               
                {
                    extend: 'excelHtml5',
                    text: 'Excel', 
                    title: 'Labour In Out Report', 
                },
                /*{
                    extend: 'pdfHtml5',
                    text: 'PDF', 
                    title: 'Labour In Out Report', 
                }*/ 
                { 
                    extend : 'pdfHtml5',
                    text: 'PDF', 
                    title: 'Labour In Out Report',
                    orientation: 'portrait',
                    pageSize: 'A4', //A3 , A5 , A6 , legal , letter
                    customize: function(doc) {
                        //find paths of all images, already in base64 format 

                        
                        if (table.rows({selected: true}).count() == 0) {
                            // nothing selected, so do your current code
                        }
                        else {
                            var arr2 = $('.bar_img').map(function(){
                                return this.src;
                            }).get();

                            // then your for loop
                            for (var i = 0, c = 1; i < arr2.length; i++, c++) {
                                doc.content[1].table.body[c][1] = { 
                                    alignment: 'center',
                                    image: arr2[i],
                                    width: 50,
                                    height: 50, 
                                }

                            }
                        }
                     },
                    exportOptions : {
                        //stripHtml: false, 
                    }
                }
            ],
            /*exportOptions: {
                stripHtml: false,
            }*/ 
        } );


        // Extend dataTables search
        $.fn.dataTable.ext.search.push(
          function(settings, data, dataIndex) {
            var min = $('#min-date').val();
            var max = $('#max-date').val();
            var createdAt = data[7] || 0; // Our date column in the table

            if (
              (min == "" || max == "") ||
              (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
            ) {
              return true;
            }
            return false;
          }
        );

        // Re-draw the table when the a date range filter changes
        $('.date-range-filter').change(function() {
          table.draw();
        });

        $('#my-table_filter').hide();  

        /*$("#Export").click(function(e) {
            $("#vts_table1").table2excel({

              exclude:".noExl", 
              name:"Worksheet Name", 
              filename:"SomeFile", 
              fileext:".xls", 
              exclude_img:true, 
              exclude_links:true, 
              exclude_inputs:true

            });
 
        });*/

    } );
</script>