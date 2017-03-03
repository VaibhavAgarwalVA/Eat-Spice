<?php
  session_start();
  $dbconnect = mysqli_connect("10.5.18.104", "14CS10059", "btech14", "test");
  if(mysqli_connect_errno()) {
    echo "Connection failed:".mysqli_connect_error();
    exit;
  }
    $conn = new mysqli("10.5.18.104", "14CS10059", "btech14", "test");
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Restaurant</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  /* Add a dark background color with a little bit see-through */
.navbar {
    margin-bottom: 0;
    background-color: #2d2d30;
    border: 0;
    font-size: 11px !important;
    letter-spacing: 4px;
    opacity:0.9;
}
/* Add a gray color to all navbar links */
.navbar li a, .navbar .navbar-brand {
    color: #d5d5d5 !important;
}
/* On hover, the links will turn white */
.navbar-nav li a:hover {
    color: #fff !important;
}
/* The active link */
.navbar-nav li.active a {
    color: #fff !important;
    background-color:#29292c !important;
}
/* Remove border color from the collapsible button */
.navbar-default .navbar-toggle {
    border-color: transparent;
}
/* Dropdown */
.open .dropdown-toggle {
    color: #fff ;
    background-color: #555 !important;
}
/* Dropdown links */
.dropdown-menu li a {
    color: #000 !important;
}
/* On hover, the dropdown links will turn red */
.dropdown-menu li a:hover {
    background-color: red !important;
}
  .but {
      margin: 5px 0 0 0;
  }
  .Custbody {
      background-image: url("raspberries.jpg");
  }
  .CRP{
      color: moccasin;
      text-shadow: 10px 10px 10px black;
      opacity: 0.9;
      font-size: 70px;
  }
  .tab{
    background-color: burlywood;
  }
  .pad{
    margin-top:10vh;
  }
  </style>
  </head>
  <body class="Custbody">
  <?php
    if(isset($_POST['Logout'])) {
    session_destroy();
    header("Location: home.php");
        exit();
    }
  ?>
  <!--Navbar-->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Eat&Spice</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-center">
        <li><a href="#">Restaurant Portal</a></li>
        </ul>
      <ul class="nav navbar-nav navbar-right">
          <li><a href="restaurant_add.php">ADD DISH</a></li>
          <li><a href="restaurant_update.php">ACCOUNT INFORMATION</a></li>
          <li><a href="#" data-toggle="modal" data-target="#LModal">LOGOUT</a></li>
      </ul>
    </div>
  </div>
</nav>
<!-- LModal -->
<div id="LModal" class="modal fade" role="dialog">
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Logout</h4>
    </div>
    <div class="modal-body">
        <!-- The login buttons-->
        <div class="row text-center";margin:200px>
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                 <form class = "form-signin" role = "form" action = "<?php $_PHP_SELF ?>" method = "post">
                    <p>Are you sure you want to log out?</p>
                    <button class = "btn" type = "submit" name = "Logout">Logout</button>
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                 </form>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
    </div>

</div>
</div>
<div class="row pad container-fluid">
      <div class="col-sm-3"></div>
      <div class="col-sm-6 text-center ">
        <?php 
         $sql = 'select orderid,name,phone,address,email,total,status from customer inner join (select * from place natural join (select * from orders natural join (select orderid, resid from delivery where delivery.resid ="'.$_SESSION['username'].'") as a1) as a2) as a3 on customer.username = a3.custid';
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
              if (isset($_POST['Update'.$row['orderid']])){
                  unset($_POST['Update'.$row['orderid']]);
                  $sql1 = 'update orders set status="'.$_POST['Status'.$row['orderid']].'" where orderid='.$row['orderid'];
                  // echo $sql1;
                  $conn->query($sql1);
              }
            }
          }
       ?>

      <div class="col-sm-10 text-center ">
      <h1 class="text-center CRP">Current Orders</h1>
      
        
        <?php
          $sql = 'select orderid,name,phone,address,email,total,status from customer inner join (select * from place natural join (select * from orders natural join (select orderid, resid from delivery where delivery.resid ="'.$_SESSION['username'].'") as a1) as a2) as a3 on customer.username = a3.custid order by orderid';
          $query = $conn->query($sql);
        ?>
        <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
        <table class="table table-hover tab">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Phone Number</th>
            <th>Delivery Address</th>
            <th>Email</th>
            <th>Total Quantity</th>
            <th>Current Status</th>
            <th>Update</th>
          </tr>
        </thead>
        <tbody> 
        <?php
          if ($query->num_rows > 0) {
            while($row = $query->fetch_assoc()) { 
         echo ' <tr>
            <td>'.$row['orderid'].'</td>
            <td>'.$row['name'].'</td>
            <td>'.$row['phone'].'</td>
            <td>'.$row['address'].'</td>
            <td>'.$row['email'].'</td>
            <td>'.$row['total'].'</td>
            <td><input type="text" name="Status'.$row['orderid'].'" value="'.$row['status'].'"></td>
            <td><button class = "btn" type = "submit" name = "Update'.$row['orderid'].'">Update</button></td>
          </tr>';
            }
          }
          else{
            echo "No records found!";
          }
          $conn->close();
        ?>
        </tbody>
        </table>

      </form>
        
        
        </div>
      <div class="col-sm-2"></div>
      </div>
  </body>
</html>