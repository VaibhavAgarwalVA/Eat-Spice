<?php
  session_start();
  include("dbconnect.php");
 //   if(!isset($_SESSION['user']))
  // {
  //  header("Location: login-full.php");
  $flag=0;
  // }
if(isset($_POST['Type']))
{
  $selected_category = $_POST['Type'];
  // $url = "http://52.11.181.227/py/DeleteMatch.py?".$matchID;
  // $content = file_get_contents($url);
  //echo $selected_category;
  if($selected_category == "All")
  {
    $flag = 0;
  }
  else
  {
    $flag = 1;
  }
}
?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="js/index.js"></script>
  
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
.main{
  margin-top:10vh;
}
body{
  background-image:url(Userhome.jpg);
  background-repeat:no-repeat;
  background-size: 100%;
}
table{
  background-color:rgba(240,220,200,0.8);
}
.hblack{
  text-align:center;
}
.hblack span{
    text-align:center;
    color:black;
    opacity:1;
    background-color:rgba(0,0,0,0.5);
  }
    </style>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

</head>

<body>
<?php
    if(isset($_POST['Logout'])) {
    session_destroy();
    header("Location: home.php");
        exit();
    }
  ?>

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
          <li><a href="history.php">VIEW ORDERS</a></li>
          <li><a href="fav.php">FAVOURITES</a></li>
          <li><form class = "form-signin" role = "form" action = "<?php $_PHP_SELF ?>" method = "post">
                    <button class="btn btn-danger navbar-btn" name="Logout">Logout</button>
                 </form></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid main">
  <h1><span>Hi <?php echo $_SESSION['username']; ?>, feeling hungry? Let's Order </span></h1>
  <h1 class = "hblack"><span>Choose cuisine</span></h1>
    <form method="post">
       <div class="col-sm-10 "><select name="Type" class="form-control" id="Typeselect">
            <?php
        $sql = "select cuisine from dish";
        $result=mysqli_query($dbconnect, $sql);
        echo "<option>All</option>";    
        if (mysqli_num_rows($result)) {
          while($row = mysqli_fetch_assoc($result)) {
                echo "<option>".$row["cuisine"]."</option> ";
              }
          } 
        else {
          echo "<option>else</option>";
        }   
      ?>
        </select></div>
        <div class="col-sm-2"><button type="submit" class="btn btn-primary btn-block btn-large" name = "Go">Go</button></div>
    </form>

    <table class="table">
    <thead>
      <tr>
        <th><!-- <a href="#"> --><span>Restaurant ID</span></a></th>
        <th><!-- <a href="#"> --><span>Restaurant Name</span></a></th>
        <th><span>Address</span></th>
        <!-- <th><a href="#"><span>TEAM B</span></a></th> -->
        <th class="text-center"><span>Open Time</span></th>
        
      </tr>
    </thead>
    <tbody>
    <?php
      if($flag == 1){
         $sql = 'select * from restaurant,menu,dish where cuisine = "'.$_POST['Type'].'" and dish.dishid = menu.dishid and restaurant.username = menu.resid'; 
       //  echo $sql; 
       }
      else{
        $sql = "select * from restaurant";
        //echo $sql;
      } 
          $result=mysqli_query($dbconnect, $sql);
      if (mysqli_num_rows($result)) {
        // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
              echo '<tr><td><p><a href = cart.php?resid='.$row["username"].'>'.$row["username"].'</a></p></td>';
          echo '<td><p>'.$row["name"].'</p></td>';
          echo '<td><p>'.$row["location"].'</p></td>';
          echo '<td><p>'.$row["open_hours"].'</p></td></tr>';
          }
      } 
      else {
        echo "<option>else</option>";
        }
  ?>
  </tbody>
</table>
  </div>

</body>
</html>