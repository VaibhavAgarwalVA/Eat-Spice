<?php
  session_start();
  $dbconnect = mysqli_connect("10.5.18.104", "14CS10059", "btech14", "test");
  if(mysqli_connect_errno()) {
    echo "Connection failed:".mysqli_connect_error();
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script type="text/javascript">
               $(document).ready(function(){
               $('#LModal').modal('show');
          });
</script>
  <style>
  .container {
      padding: 80px 120px;
  }
.carousel-inner img{
      /*-webkit-filter: grayscale(90%);*/
      /*filter: grayscale(90%);  make all photos black and white  */
      width: 100%; /* Set width to 100% */
      margin: auto;
      background-color: black;
  }
  .carousel-caption h3 {
      color: #fff !important;
  }
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
  </style>
  </head>

<body>

<?php
  $msg = '';
  if (isset($_POST['Alogin']) && !empty($_POST['AUsername']) 
     && !empty($_POST['APassword'])) {
    unset($_POST['Alogin']);
      
      $pass = "select * from admin where loginid = '".$_POST['AUsername']."'"; //QUERY
      $query = mysqli_query($dbconnect, $pass);
      $data=mysqli_fetch_assoc($query);
      if($data['password'] == $_POST['APassword']){
          $_SESSION['username']=$_POST['AUsername'];
          $_SESSION['valid'] = true;
          $_SESSION['timeout'] = time();
          $msg = '';
          header("Location: adminPage.php"); //For that user
          exit();
        }
      else{
        $msg = 'Wrong username or password';
      }
  }


  else if (isset($_POST['login']) && !empty($_POST['Username']) 
     && !empty($_POST['Password'])) {
    unset($_POST['login']);
    
    if($_POST['Type'] == "Customer"){
      $pass = "select * from customer where username = '".$_POST['Username']."'"; //QUERY
      $query = mysqli_query($dbconnect, $pass);
        $data=mysqli_fetch_assoc($query);
        if($data['password'] == $_POST['Password']){
          $_SESSION['username']=$_POST['Username'];
          $_SESSION['valid'] = true;
          $_SESSION['timeout'] = time();
          $msg = '';
          header("Location: user.php"); //For that user
          exit();
        }
       else{
        $msg = 'Wrong username or password';
        }
    }
    else{
      $pass = "select * from restaurant where username = '".$_POST['Username']."'"; //QUERY
      $query = mysqli_query($dbconnect, $pass);
      
        $data=mysqli_fetch_assoc($query);
        echo $data['Username'];
        echo $data['Password'];
        if($data['password'] == $_POST['Password']){
          $_SESSION['username']=$_POST['Username'];
          $_SESSION['valid'] = true;
          $_SESSION['timeout'] = time();
          $msg = '';
          header("Location: restaurant.php"); //For that user
          exit();
        }
       else{
        $msg = 'Wrong username or password';
        }
    } 
  }
  else{
    $msg = '';
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
      <ul class="nav navbar-nav navbar-right">
          <li><a href="#" data-toggle="modal" data-target="#AModal">ADMIN</a></li>
          <li><a href="#" data-toggle="modal" data-target="#LModal">LOGIN</a></li>
          <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">REGISTER
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="RestaurantReg.php">Restaurant</a></li>
            <li><a href="CustomerReg.php">Customer</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>


<!-- AModal -->
<div id="AModal" class="modal fade" role="dialog">
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Admin Login</h4>
    </div>
    <div class="modal-body">
        <!-- The login buttons-->
        <div class="row text-center";margin:200px>
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                 <form class = "form-signin" role = "form" action = "<?php $_PHP_SELF ?>" method = "post">
                    <input class="form-control" id="Username" name="AUsername" placeholder="Username" type="text" required>
                    <input class="form-control" id="Password" name="APassword" placeholder="Password" type="password" required>
                    <button class = "btn" type = "submit" name = "Alogin">Login</button>
                 </form>
                
                <h4><?php echo $msg; ?></h4>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </div>
</div>
</div>



<!-- LModal -->
<div id="LModal" class="modal fade" role="dialog">
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Login</h4>
    </div>
    <div class="modal-body">
        <!-- The login buttons-->
        <div class="row text-center";margin:200px>
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                 <form class = "form-signin" role = "form" action = "<?php $_PHP_SELF ?>" method = "post">
                    <select name="Type" class="form-control" id="Typeselect">
                        <option value = "Customer">Customer</option>
                        <option value = "Restaurant">Restaurant</option>
                    </select>
                    <input class="form-control" id="Username" name="Username" placeholder="Username" type="text" required>
                    <input class="form-control" id="Password" name="Password" placeholder="Password" type="password" required>
                    <button class = "btn" type = "submit" name = "login">Login</button>
                 </form>
                
                <h4><?php echo $msg; ?></h4>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </div>

</div>
</div>
<!-- Carousel of images-->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="img1.jpg" alt="Cuisine"  height:900px >
        <div class="carousel-caption">
          <h3>Cuisine</h3>
          <p>Select from our range of finest cuisine</p>
        </div>      
      </div>

      <div class="item">
        <img src="img2.jpg" alt="Restaurant" >
        <div class="carousel-caption">
          <h3>Restaurant</h3>
          <p>Restaurants you love just a click away</p>
        </div>      
      </div>
    
      <div class="item">
        <img src="img3.jpg" alt="Tracking" >
        <div class="carousel-caption">
          <h3>Reliable</h3>
          <p>No worries about deliver and payment hassles</p>
        </div>      
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
</div>

</body>

</html>