<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href="login1.css">
<style>
	#div_login{
		width: auto;
	}
</style>
<div class="header">
<h1>Drug Store Management System</h1>
 <p style="margin-top:-20px;line-height:1;font-size:30px;">A Web Based Project</p>
 <p style="margin-top:-20px;line-height:1;font-size:20px;">Department of Computer Science and IT</p>
</div>
<title>
Pharmacia 
</title>
</head>

<body>

	<br><br><br><br>
	<div class="container">
		<form method="post" action="">
			<div id="div_login">
				<h1>Customer Login</h1>
				<center>
				<div>
					<input type="text" class="textbox" id="uname" name="uname" placeholder="Username" />
				</div>
				<div>
					<input type="password" class="textbox" id="pwd" name="pwd" placeholder="Password"/>
				</div>
				<div>
					<input type="submit" value="Submit" name="submit" id="submit" />
				</div>
			 
			<p>If you don't have an account !! <a href="customer-reg.php">Register here</a></p>	
	<?php
				
		include "config.php";
		if(isset($_POST['submit'])){
			$username = $_POST['uname'];
			$password = $_POST['pwd'];
			$sql = "SELECT * FROM customer where C_ID = $username and C_PASSWORD = '$password'";
			$result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)){
					$username1 = $row['C_ID'];
					$password1 = $row['C_PASSWORD'];
				}
				if($username == $username1 && $password == $password1){
					session_start();
					$_SESSION['customer'] = $username1;
					header("location: customer-dashbord.php");
				}
				else{
					echo "<p style='color:red;'>Invalid username or password!</p>";
				}
			}
			else{
				echo "<p style='color:red;'>Invalid username or password!</p>";
			}
		}
		
	?>

				</center> 
			</div>
		</form>
	</div>
	<div class=footer>
	<br>
	Developed by, Sourav Law Riya Rochit, JRU, Ranchi, 2022 
	<br><br>
	</div>

</body>

</html>