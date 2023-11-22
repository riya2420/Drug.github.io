<?php 
session_start();
require "config.php";
if(!$_SESSION['customer']){
    header("location: customer-login.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User Dashbord</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <style>
            a:hover{
                text-decoration: none;
            }
            .top-nav{
                padding: 10px 0px;
            }
            .top-nav ul{
                display: flex;
                list-style: none;
            }
            .top-nav .nav-bar{
                position: absolute;
                top: 10px;
                float: right;
                right: 220px;
            }
            .top-nav .nav-bar li{
                padding: 10px;
            }
            .top-nav .nav-bar .cart-data{
                position: relative;
                top: -5px;
                padding: 5px;
            }
            .table .fa-pencil{
                color: #13abd8;
            }
            .table .fa-trash{
                color: orange;
            }            

        </style>
    </head>
    <body>
        <div class="container-fluid bg-primary">
            <div class="container">
                <div class="top-nav">
                    <ul>
                        <li>
                            <h5 class="text-white">Drug Store Management System</h5>
                        </li>
                    </ul>
                    
                    <ul class="nav-bar">
                        <li class="text-while"><a href="customer-dashbord.php"><i class="fa fa-search text-white"></i></a></li>
                        <li class="text-white"><a href="customer-logout.php" class="text-white">Logout ( 
                            <?php 
                                  $USER_ID = $_SESSION['customer']; 
                                  $sql = "select * from customer where C_ID = '$USER_ID'";
                                  $result = mysqli_query($conn, $sql);
                                  if(mysqli_num_rows($result) > 0){
                                      while($row = mysqli_fetch_assoc($result)){
                                          echo $row['C_FNAME']."&nbsp;".$row['C_LNAME'];
                                      }
                                  }  
                            ?>
                            )</a></li>
                        <li class="text-white"><a href="#" class="text-white"><i class="fa fa-cart-plus"></i><span class="cart-data"><?php 
                        $USER_ID = $_SESSION['customer']; 
                        $sql = "select * from cards where USER_ID = '$USER_ID'";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){
                            echo mysqli_num_rows($result);
                        }
                        ?></span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th>NAME</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php 
            $USER_ID = $_SESSION['customer']; 
            $sql = "select * from meds inner join cards where meds.MED_ID = cards.MED_ID and cards.USER_ID = $USER_ID";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td><?php echo $row['MED_NAME'] ?></td>
                    <td><?php echo $row['MED_QUANTITY']; ?></td>
                    <td><span id="price" price="<?php echo $row['MED_PRICE']*$row['MED_QUANTITY']; ?>"><?php echo $row['MED_PRICE']*$row['MED_QUANTITY'] ."/-"; ?></span></td>
                    <td><i class="fa fa-pencil" id="<?php echo $row['s_no']; ?>" data-toggle="modal" data-target="#EditModal"></i>&nbsp;&nbsp;<i class="fa fa-trash" id="<?php echo $row['s_no']; ?>"></i></td>
                </tr>
                <?php
                }
            }
            ?>
            <tr>
                <th>Total</th>
                <th></th>
                <th class="total_price">
                    <?php 
                    $USER_ID = $_SESSION['customer'];
                    $sql = "select * from meds inner join cards where meds.MED_ID = cards.MED_ID and cards.USER_ID = $USER_ID";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0){
                        $price = 0;
                        while($row = mysqli_fetch_assoc($result)){
                            $price += $row['MED_PRICE']*$row['MED_QUANTITY'];
                        }
                        echo $price."/-";
                    }
                    else{
                        echo "0 /-";
                    }
                    ?>
                </th>
            </tr>
            </tbody>
        </table>
        <botton class="btn btn-info d-flex" style="float: right;"  data-toggle="modal" data-target="#OrderModal">Check Out</botton>
        <div id="Delete_result"></div>
        </div>
        
        <!-- Model -->
        <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Medicine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="customer-meds-search.php" method="post">
                    <div class="modal-body">
                        <div id="med_result"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="MED_Card_Update">Save changes</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!-- /model -->

        <!-- Model -->
        <div class="modal fade" id="OrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Medicine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="customer-meds-search.php" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-2">
                                <input type="text" class="form-control" name='Fname' placeholder="Enter First Name.." required/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-2">
                                <input type="text" class="form-control" name="Lname" placeholder="Enter Last Name.." required/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-2">
                                <input type="text" class="form-control" name='Mobile' placeholder="Enter Mobile Number.." required/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-2">
                                <input type="text" class="form-control" name="Email" placeholder="Enter E-mail Id.." required/>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 p-2">
                                <textarea type="text" class="form-control" name="Address" placeholder="Enter Address" required></textarea>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-2">
                                <input type="text" class="form-control" name="Pin_code" placeholder="Enter Pin-Code.." required/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-2">
                                <input type="radio" name="Office_Home" value="Office"> Office &nbsp; <input type="radio" name="Office_Home" value="Home"> Home
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="Order_Place">Order Place</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!-- /model -->

        <script>
            $(document).on('click','.fa-pencil',function(){
                let s_no = $(this).attr('id');
                let EditMeditionBySNo = '';
                //console.log(s_no);
                $.ajax({
                    url : "customer-meds-search.php",
                    method : "post",
                    data : {EditMeditionBySNo,s_no},
                    success : function(data){
                        $('#med_result').html(data);
                    }
                })
            })

            $(document).on('click','.fa-trash',function(){
                let s_no = $(this).attr('id');
                let DeleteMedBySNo = '';
                //console.log(s_no);
                $.ajax({
                    url : "customer-meds-search.php",
                    method : "post",
                    data : {DeleteMedBySNo, s_no},
                    success : function(data){
                        $('#Delete_result').html(data);
                    }
                })
                location.reload();
            })
        </script>
    </body>
</html>