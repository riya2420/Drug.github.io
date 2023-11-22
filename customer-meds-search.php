<?php
require "config.php";
session_start();
// if(!$_SESSION['customer']){
//     header("location: customer-login.php");
// }
if(isset($_POST['SearchData'])){
    $SearchText = $_POST['SearchText'];
    echo "<hr><h5>Result for .......( $SearchText ) </h5><hr>";
    if($SearchText != null){
        $sql = "SELECT * FROM meds where MED_NAME like '%$SearchText%'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
            ?>
            <div class="card">
                <div class="card-title text-center p-2">
                    <h5><?php echo $row['MED_NAME']; ?></h5>
                </div>
                <div class="card-body">
                    <img src="emp.png">
                    <p><?php echo $row['MED_PRICE']; ?> /-</p>
                </div>
                <div class="card-footer">
                    <button class="btn btn-info MED_ID" id="<?php echo $row['MED_ID']; ?>">Add to Cart</button>
                </div>
            </div>
            <?php
        }
    }
    else{
        echo "<div class='alert alert-info text-center'>No Result Found...</div>";
    }
    }
    else{
        echo "<div class='alert alert-info text-center'>Please Write Somthing on search bar</div>";
    }
}

if(isset($_POST['AddToCard'])){
    $USER_ID = $_SESSION['customer'];
    $MED_ID = $_POST['MED_ID'];
    $quantity = 1;

        $sql = "INSERT INTO `cards` (`s_no`, `USER_ID`, `MED_ID`, `MED_QUANTITY`) VALUES (NULL, '$USER_ID', '$MED_ID', '$quantity')";
        $result = mysqli_query($conn,$sql);
    
    $sql = "select * from cards where USER_ID = '$USER_ID'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        echo mysqli_num_rows($result);
    }
    else{
        echo "0";
    }
}


if(isset($_POST['DeleteMedBySNo'])){
    $s_no = $_POST['s_no'];
    $sql = "delete from cards where s_no = $s_no";
    $result = mysqli_query($conn,$sql);
    if($result){
        echo "<div class='alert alert-info text-center'>Data Deleted ....</div>";
    }
    else{
        echo "<div class='alert alert-warning'>Somthing went wrong !!!!!</div>";
    }
}

if(isset($_POST['EditMeditionBySNo'])){
    $s_no = $_POST['s_no'];
    $sql = "select MED_QUANTITY from cards where s_no = $s_no";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
        ?>
            <input type='number' name="quantity" value='<?php echo $row['MED_QUANTITY']; ?>'class="form-control"/>
            <input type="number" name="s_no" value="<?php echo $s_no; ?>" class="d-none"/>
        <?php
        }
    }
}

if(isset($_POST['MED_Card_Update'])){
    $quantity = $_POST['quantity'];
    $s_no = $_POST['s_no'];
    $sql = "UPDATE cards set MED_QUANTITY = $quantity WHERE s_no = $s_no";
    $result = mysqli_query($conn,$sql);
    if($result){
        header("location: customer-card-page.php");
    }
    else{
        echo "somthing wrong";
    }
}

if(isset($_POST['Order_Place'])){
    $Fname = $_POST['Fname'];
    $Lname = $_POST['Lname'];
    $Mobile = $_POST['Mobile'];
    $Email = $_POST['Email'];
    $Address = $_POST['Address'];
    $Pin_code = $_POST['Pin_code'];
    $Office_Home = $_POST['Office_Home'];
    $USER_ID = $_SESSION['customer'];
    //echo $Fname."<br>".$Lname."<br>".$Mobile."<br>".$Email."<br>".$Address."<br>".$Pin_code."<br>".$Office_Home;
    $sql = "select * from cards where USER_ID = $USER_ID";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $MED_ID = $row['MED_ID'];
            $MED_QUANTITY = $row['MED_QUANTITY'];
            $sql1 = "INSERT INTO `order_med_list` (`s_no`, `USER_ID`, `MED_ID`, `MED_QUANTITY`) VALUES (NULL, '$USER_ID', '$MED_ID', '$MED_QUANTITY');";
            mysqli_query($conn,$sql1);
        }
    }
    // echo $MED_ID_ARRAY;
    // echo "<br>";
    // echo $MED_QUANTITY_ARRAY;
    $sql = "INSERT INTO `orders` (`s_no`, `F_Name`, `L_Name`, `Mobile_No`, `E_mail`, `Address`, `Pin_Code`, `O_H`, `Status`, `Order_date`, `Delever_date`, `USER_ID`) VALUES (NULL, '$Fname', '$Lname', '$Mobile', '$Email', '$Address', '$Pin_code', '$Office_Home', 'Pending', current_timestamp(), '', '$USER_ID')";
    $result = mysqli_query($conn,$sql);
    if($result){
        $sql = "delete from cards where USER_ID = $USER_ID";
        $result = mysqli_query($conn,$sql);
        if($result){
            header("location: customer-card-page.php");
        }
    }
}
?>