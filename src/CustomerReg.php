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
  .Custbody {
      background-image: url("CustRadBackground.jpg");
  }
  .CRP{
      color: moccasin;
      text-shadow: 10px 10px 10px black;
      opacity: 0.9;
      background-color: #29292c;
      font-size: 67px;
  }
  </style>
  </head>
  <body class="Custbody">
  <?php
    if(isset($_POST['Register']) && !empty($_POST['CustomerName']) 
       && !empty($_POST['Password'])) {
          $pass = "insert into customer values('".$_POST['CustomerName']."', '".$_POST['CustomerUsername']."', ".$_POST['CustomerPhoneNumber'].", '".$_POST['CustomerAddress']."', '".$_POST['CustomerEmail'].", '".$_POST['Password']."')"; //QUERY
          $query = mysqli_query($dbconnect, $pass);
          header("Location: home.php"); //For that user
          exit();
    }
  ?>
      <h1 class="text-center CRP">Customer Registeration Portal</h1>
      <div class="col-sm-3"></div>
      <div class="col-sm-6 text-center ">
      <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
        <input class="form-control" id="CustomerName" name="CustomerName" placeholder="Name" type="text" required>
        <input class="form-control" id="CustomerUsername" name="CustomerUsername" placeholder="Username" type="text" required>
        <input class="form-control" id="CustomerPhoneNumber" name="CustomerPhoneNumber" placeholder="Phone Number" type="number" required>
        <input class="form-control" id="CustomerEmail" name="CustomerEmail" placeholder="Email" type="text" required>
        <input class="form-control" id="CustomerAddress" name="CustomerAddress" placeholder="Address" type="text" required>
        <input class="form-control" id="Password" name="Password" placeholder="Password" type="password" required>
        <button class = "btn" type = "submit" name = "Register">Register</button>
        </form>
        <h4> <?php echo $msg ?> </h4>
        </div>
      <div class="col-sm-3"></div>
  </body>
</html>
