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
            .search-box .fa-search{
                float: right;
                position: relative;
                top: -25px;
                right: 15px;
            }
            .search-box input{
                padding-right: 35px;
            }
            .card{
                width: 190px;
                display: flex;
                float: left;
                margin: 10px;
            }
            .card .card-body img{
                width: 100px;
                position: relative;
                top: 30px;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            .card .card-footer{
                display: flex;
                justify-content: center;
            }
            #result{
                margin-top: 40px;
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
                        <li class="text-white"><a href="customer-card-page.php" class="text-white"><i class="fa fa-cart-plus"></i><span class="cart-data"><?php 
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
        <div class="container-fluid">
            <div class="container">
                <div class="search-box mt-3">
                    <input type="search" class="form-control" placeholder="Enter Medicine Name ..... " id="serach-data"><i class="fa fa-search"></i>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container">
                <div id="result">
                    <hr><h5>Result.......(  ) </h5><hr>
                    
                </div>
            </div>
        </div>


        <script>
            $(document).on('keyup','#serach-data',function(){
                let SearchText = $('#serach-data').val();
                //console.log(SearchText);
                let SearchData='';
                $.ajax({
                    url : "customer-meds-search.php",
                    method : "post",
                    data : {SearchData, SearchText},
                    success : function(data){
                        $('#result').html(data);
                    }
                })
            })
            
            $(document).on('click','.MED_ID',function(){
                let MED_ID = $(this).attr('id');
                //console.log(MED_ID);
                let AddToCard = '';
                $.ajax({
                    url : "customer-meds-search.php",
                    method : "post",
                    data : {AddToCard, MED_ID},
                    success : function(data){
                        $('.cart-data').html(data);
                    }
                })
            })


            
        </script>
    </body>
</html>