<?php
  include("dbconnect.php");
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
  <style>
  .but {
      margin: 5px 0 0 0;
  }
  .Restbody {
      background-image: url("RestRadBackground.jpg");
  }
  .RRP{
      color: burlywood;
      text-shadow: 2px 2px 2px black;
      background-color: black;
      opacity: 0.7;
      font-size: 67px;
  }
  </style>
  </head>
  <body class="Restbody">
  <?php
    if(isset($_POST['Register']) && !empty($_POST['RestaurantName']) 
       && !empty($_POST['Password'])) {
          $pass = "insert into restaurant values('".$_POST['RestaurantName']."', '".$_POST['RestaurantUsername']."', ".$_POST['RestaurantPhoneNumber'].", '".$_POST['RestaurantAddress'].", '".$_POST['RestaurantCategory']."', '".$_POST['Password']."')"; //QUERY
          $query = mysqli_query($dbconnect, $pass);
          header("Location: home.php"); //For that user
          exit();
    }
  ?>
      <h1 class="text-center RRP">Restaurant Registeration Portal</h1>
      <div class="col-sm-3"></div>
      <div class="col-sm-6 text-center ">
      <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
        <input class="form-control" id="RestaurantName" name="RestaurantName" placeholder="Name" type="text" required>
        <input class="form-control" id="RestaurantUsername" name="RestaurantUsername" placeholder="Username" type="text" required>
        <input class="form-control" id="RestaurantPhoneNumber" name="RestaurantPhoneNumber" placeholder="Phone Number" type="number" required>
        <input class="form-control" id="RestaurantAddress" name="RestaurantAddress" placeholder="Address" type="text" required>
        <input class="form-control" id="RestaurantCategory" name="RestaurantCategory" placeholder="Open Hours" type="text" required>
        <input class="form-control" id="Password" name="Password" placeholder="Password" type="password" required>
        <button class = "btn but" type = "submit" name = "Register">Register</button>
        </form>
        </div>
      <div class="col-sm-3"></div>
  </body>
</html>
