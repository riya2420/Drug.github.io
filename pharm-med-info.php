<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href="table1.css">
<link rel="stylesheet" type="text/css" href="nav2.css">
<title>
Pharmacist Dashboard
</title>
</head>
<style>
body {font-family:Arial;}
.table{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
}
</style>

<body>

	<div class="sidenav">
			<h2 style="font-family:Arial; color:white; text-align:center;"> Drug Store Management System </h2>
			<p style="margin-top:-20px;color:white;line-height:1;font-size:12px;text-align:center">Developed by, Sourav Law Riya Rochit, JRU, 2022</p>
			<a href="pharmmainpage.php">Dashboard</a>

			<a href="pharm-order-list.php">View Order</a>
			<a href="pharm-inventory.php">View Inventory</a>
			<a href="pharm-pos1.php">Add New Sale</a>
			<button class="dropdown-btn">Customers
			<i class="down"></i>
			</button>
			<div class="dropdown-container">
				<a href="pharm-customer.php">Add New Customer</a>
				<a href="pharm-customer-view.php">View Customers</a>
			</div>
	</div>
	
	<?php
	
	include "config.php";
	session_start();
	
	$sql="SELECT E_FNAME from EMPLOYEE WHERE E_ID='$_SESSION[user]'";
	$result=$conn->query($sql);
	$row=$result->fetch_row();
	
	$ename=$row[0];
		
	?>

	<div class="topnav">
		<a href="logout1.php">Logout(signed in as <?php echo $ename; ?>)</a>
	</div>
	
	<center>
	<div class="head" align="center">
	<h2> MEDICINE ORDER LIST </h2>
	</div>
	</center>
    <table align="right" id="table1" style="margin-right: 100px;">
    <?php 
        $USER_ID = $_GET['user_id'];
        $sql = "select * from orders where USER_ID = $USER_ID";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
    ?>
        <tr>
            <th colspan="2">User Information</th>
        </tr>
        <tr>
            <th>Name :</th>
            <td><?php echo $row['F_Name'].'&nbsp;'.$row['L_Name']; ?></td>
        </tr>
        <tr>
            <th>Phone Number :</th>
            <td><?php echo $row['Mobile_No']; ?></td>
        </tr>
        <tr>
            <th>E-mail Id :</th>
            <td><?php echo $row['E_mail']; ?></td>
        </tr>
        <tr>
            <th>Address :</th>
            <td><?php echo $row['Address']; ?></td>
        </tr>
        <tr>
            <th>Office_Home :</th>
            <td><?php echo $row['O_H']; ?></td>
        </tr>
        <?php
            }
        } 
        ?>
    </table>
	<table align="right" id="table1" style="margin-right:100px;">
		<tr>
			<th>Medicine Id</th>
			<th>Name</th>
			<th>Qunatity</th>
			<th>Price</th>
		</tr>
        <?php 
            $USER_ID = $_GET['user_id'];
            $total = 0;
            $total_MED = 0;
            $sql = "SELECT * from order_med_list inner join meds ON order_med_list.MED_ID = meds.MED_ID where USER_ID = $USER_ID";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $total += $row['MED_PRICE']*$row['MED_QUANTITY'];
                    $total_MED += $row['MED_QUANTITY'];
            ?>
                <tr>
                    <td><?php echo $row['MED_ID']; ?></td>
                    <td><?php echo $row['MED_NAME']; ?></td>
                    <td><?php echo $row['MED_QUANTITY']; ?></td>
                    <td><?php echo $row['MED_PRICE']*$row['MED_QUANTITY']; ?></td>
                </tr>
            <?php
                }
            }
        ?> 
        <tr>
            <th colspan="2">Total</th>
            <th><?php echo $total_MED; ?> Unit</th>
            <th><?php echo $total; ?> /-</th>
        </tr> 
        <tr>
            <td colspan="4"><a class='button1 edit-btn' style="float: right;">Accept</a></td>
        </tr>
    </table>
    
</body>

<script>

	var dropdown = document.getElementsByClassName("dropdown-btn");
	var i;

		for (i = 0; i < dropdown.length; i++) {
		  dropdown[i].addEventListener("click", function() {
		  this.classList.toggle("active");
		  var dropdownContent = this.nextElementSibling;
		  if (dropdownContent.style.display === "block") {
		  dropdownContent.style.display = "none";
		  } 
		  else {
		  dropdownContent.style.display = "block";
		  }
		});
	}
	
</script>

</html>