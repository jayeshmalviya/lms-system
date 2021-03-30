<?php  
    include('db_connect_Login.php');
    include('visitor_out.php');
    
    $user_ = $_SESSION["user"];
    
    if($_SESSION["loggedIn"] == 0){

        header("location: index.php");
    }

    $succ_msg = $err_msg = ''; 
 
    if (isset($_REQUEST['did']) && !empty($_REQUEST['did']) && isset($_REQUEST['sts'])) {
        $did = $_REQUEST['did'];
        $sts = $_REQUEST['sts'];
        //$sql = "DELETE FROM info_visitor WHERE id = '$did'";
        $sql = "UPDATE info_visitor SET status = '$sts' WHERE id = '$did' ";
   
        if (mysqli_query($link, $sql)) {
            if ($sts == 1) { 
                $succ_msg = "visitor active successfully";
            }else{
                $succ_msg = "visitor inactive successfully";
            }
        } else {
            $err_msg = "Something wrong. Please try again.";
        }
    }   

    $sql1 = "SELECT * FROM info_visitor ORDER BY id DESC";
    $result1 = mysqli_query($link, $sql1);
    $count1 = mysqli_num_rows($result1);
    
    ?>
<!DOCTYPE HTML5>
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
        <!-- create PDF -->  
     
    </head> 
    <body> 
    <?php include('header.php'); ?>
        <div class="container"> 
            <div class="row">
                <div class="col-sm-12">
                    <h2>Visitors</h2>
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
                <br><br>
                <div class="col-sm-12" style="margin-top: 30px" class="">
                    <div style="float: right;">
                        <label>
                            Status: 
                            <select name="status" class='status' style=" border: 1px solid #aaa;border-radius: 3px;padding: 5px;background-color: transparent;margin-left: 3px;">
                                <option value="Active">Active</option> 
                                <option value="Inactive">Inactive</option> 
                            </select>
                        </label>
                    </div>
                    <table class="table table-responsive" id="vts_table">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>ID</th>
                                <th>Barcode</th>
                                <th>Aadhar Number</th> 
                                <th>Name</th>
                                <th>Date Of Birth</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if ($count1 > 0) { 
                                    $i = 0;
                                    while ($row = mysqli_fetch_assoc($result1)) {
                                        $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['barcode_ID']; ?></td>
                                <td><img src="tmp/<?php echo $row['barcode']; ?>" style="width: 200px;"></td>
                                <td><?php echo $row['aadhar_no']; ?></td>
                                <td><?php echo $row['name']; ?></td>   
                                <td><?php echo $row['dob']; ?></td>   
                                <td><?php echo $row['address']; ?></td>   
                                <td><?php echo ($row['status']==1)?'Active':'Inactive'; ?></td>    
                                <td><?php echo $row['created_at']; ?></td>   
                                <td style="width: 200px;"><a class="vs_print btn btn-success" href="pdf_print.php?ID=<?php echo $row['barcode_ID']; ?>" value="<?php echo $row['barcode_ID']; ?>">Print</a> <a class="btn btn-primary" href="visitor_edit.php?eid=<?php echo $row['id']; ?>">Edit</a>  <a class="btn <?php echo ($row['status']==0)?'btn-info':'btn-warning'; ?>" href="?did=<?php echo $row['id']; ?>&sts=<?php echo ($row['status']==0)?1:0; ?>" onclick="return confirm('Are you sure?')"><?php echo ($row['status']==0)?'Active':'Inactive'; ?></a></td> 
                            </tr> 
                            <?php 
                                    }
                                } else { echo '<tr>No record found.</tr>'; } 
                            ?>
                        </tbody> 
                    </table>
                </div>   
            </div>     
            
        </div>
        <div class="row">
            <div class="col-sm-8"> 
                <!--startprint-->
                <div style="display: none;"> 
                    <div style="text-align: right;"><a href="javascript:void(0);" id="print_btn" class="btn btn-default"><i class="fa fa-print"></i> Print</a></div><br>
                    <div class="table-responsive" id="barcode_print">
                        
                    </div> 
                </div>
                <!--endprint-->
            </div>
        </div>
    <body/>
<html/>
<script type="text/javascript">
    $(document).ready(function(){
        $(".vs_print").click(function(){ 
            var barcode_id = $(this).attr('value'); 
            $.ajax({
                type: 'POST',
                url: 'ajax_script.php',
                dataType: "json",
                data: { barcode_id : barcode_id },
                success: function(data) { 
                    if (data.status == 1) { 
                            $('#barcode_print').html(''); 
                            $('#barcode_print').html(data.result); 
                            $('#print_btn').trigger("click");
                        /*setTimeout(function(){ 
                            createPDF();
                        }, 5000);*/
                    }  
                }
            });
        });
    });
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script type="text/javascript">
        $("body").on("click", "#print_btn", function () {
            html2canvas($('#barcode_print')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    console.log('data',data); 
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    //pdfMake.createPdf(docDefinition).download("cutomer-details.pdf");
                    pdfMake.createPdf(docDefinition).print({}, window.frames['printPdf']);
                }
            });

        });
    </script>

    <!-- Data Table --> 
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script> 
    <script type="text/javascript">
        $(document).ready(function() { 
            
            var table = $('#vts_table').DataTable( {
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                order: []

            } );

            $('.status').change(function(){ 
                table.column(7).search(this.value).draw();
            })

            

        } );
    </script>