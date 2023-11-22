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
	<div class="head">
	<h2> MEDICINE ORDER LIST </h2>
	</div>
	</center>
	
	<table align="right" id="table1" style="margin-right:100px;">
		<tr>
			<th>Customer ID</th>
			<th>Full Name</th>
			<th>Order Date</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
            <?php 
                $sql = "SELECT * FROM orders WHERE Status = 'Pending'";
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
            ?>
            <tr> 
                <td><?php echo $row['USER_ID']; ?></td>
                <td><?php echo $row['F_Name'].' '.$row['L_Name']; ?></td>
                <td><?php echo $row['Order_date']; ?></td>
                <td><?php echo $row['Status']; ?></td>
                <td><a class='button1 edit-btn' href="pharm-med-info.php?user_id=<?php echo $row['USER_ID'];?>">Info</a>&nbsp;<a onclick="return confirm('Are you sure to delete?');" class='button1 del-btn' href="pharm-delete-order.php?user_id=<?php echo $row['USER_ID']; ?>&s_no=<?php echo $row['s_no']; ?>">Delete</a></td>
            </tr>
            <?php
                    }
                }
            ?>
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