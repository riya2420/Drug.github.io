<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href="login1.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

<style>
	#div_login{
		width: auto;
        height: 440px;
	}
    
</style>
<div class="header">
<h1>Drug Store Management System</h1>
 <p style="margin-top:-20px;font-size:30px;">A Web Based Project</p>
 <p style="margin-top:-20px;font-size:20px;">Department of Computer Science and IT</p>
</div>
<title>
Pharmacia 
</title>
</head>

<body>

	<br><br>
	<div class="container">
		<form method="post" action="">
			<div id="div_login">
				<h1>Customer Register</h1>
				<center>
				<div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <input type="text" class="textbox" id="uname" name="Fname" placeholder="Enter First Name" />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <input type="text" class="textbox" id="uname" name="Lname" placeholder="Enter Last Name" />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <select class="textbox" name="age">
                            <option>--------- Select Age ----------</option>
                            <?php 
                                for($i = 10; $i <= 30; $i++){
                                    echo '<option value='.$i.'>'.$i.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <select class="textbox" name="gender">
                            <option>---------- Select Gender ----------</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Others</option>
                        </select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <input type="text" class="textbox" id="uname" name="mobile" placeholder="Enter Mobile Number" />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <input type="email" class="textbox" id="uname" name="email" placeholder="Enter Email Id" />
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <input type="password" class="textbox" id="pwd" name="pwd" placeholder="Enter Password"/>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <input type="password" class="textbox" id="pwd1" name="pwd1" placeholder="Re-Enter Password"/>
                    </div>
                </div>
				<div>
					<input type="submit" value="Submit" name="submit" id="submit"/>
                    <p>If you have an account  !! <a href="customer-login.php">Login Here</a></p>
				</div>
                <?php
include "config.php";

if(isset($_POST['submit'])){
    $fname = $_POST['Fname'];
    $lname = $_POST['Lname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $pass = $_POST['pwd'];
    $pass1 = $_POST['pwd1'];
    $C_ID = 0;

    $sql = "select * from customer";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['C_ID'];
        }
        $C_ID = $id + 1;
    }
    else{
        $C_ID = 100000;
    }
  

    if($pass == $pass1){
        $sql = "insert into customer(C_ID, C_FNAME, C_LNAME, C_AGE, C_SEX, C_PHNO, C_MAIL, C_PASSWORD) value ('$C_ID','$fname','$lname','$age','$gender','$mobile','$email','$pass')";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo "<p style='color:green;'>Login Success!</p>";
        }
        else{
            echo "<p style='color:red;'>Check again!</p>";
        }
    }
    else{
        echo "<p style='color:red;'>Check again!</p>";
    }
    
}

?>

				</center> 
			</div>
		</form>
	</div>
	<div class="footer">
	<br>
	Developed by, Sourav Law Riya Rochit, JRU, Ranchi, 2022 
	<br><br>
	</div>
    
</body>

</html>