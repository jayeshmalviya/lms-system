<?php
include('db_connect_Login.php'); 
$resp = [];
if (isset($_POST) && !empty($_POST['barcode_id'])) {
	//echo "<pre>"; print_r($_POST); exit;
	$barcode_id = $_POST['barcode_id'];

	$sql_info = "SELECT * FROM info_visitor WHERE status = 1 AND barcode_ID	 = '$barcode_id'";  
    $result_info = mysqli_query($link, $sql_info);
    $count_info = mysqli_num_rows($result_info);
    $row_info = mysqli_fetch_assoc($result_info);  

    if ($count_info > 0) {
     	$resp['result'] = '<div style="text-align: left;"><img src="img/150x150.png"></div><br><br><br><br>
	        <table class="table">
	            <tbody>
	                <tr>
	                    <th>ID:</th>
	                    <td>'. $row_info['barcode_ID']. '</td>
	                </tr>
	                <tr>
	                    <th>Barcode:</th>
	                    <td><img id="bar_img" src="tmp/'. $row_info['barcode'].'" style="width: 200px;" /><br>'.$row_info['barcode_ID'] .'</td>
	                </tr>
	                <tr>
	                    <th>Aadhar Number:</th>
	                    <td>'. $row_info['aadhar_no'].'</td>
	                </tr>
	                <tr>
	                    <th>Name:</th>
	                    <td>'. $row_info['name'].'</td>
	                </tr>
	                <tr>
	                    <th>Date Of Birth:</th>
	                    <td>'. $row_info['dob'].'</td>
	                </tr>
	                <tr>
	                    <th>Address:</th>
	                    <td>'. $row_info['address'].'</td>
	                </tr>
	                <tr>
	                    <th>Date:</th>
	                    <td>'. $row_info['created_at'].'</td>
	                </tr>
	                
	            </tbody>
	        </table>
	    </div>';
 
		$resp['status'] = 1;
    } else{
    	$resp['status'] = 0;
    } 
}
echo json_encode($resp); exit;
?>