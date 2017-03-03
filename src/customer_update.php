<?php
  session_start();
  $conn = new mysqli("10.5.18.104", "14CS10059", "btech14", "test");
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Update Details</title>
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
      background-image: url("pieCake.jpg");
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
    if(isset($_POST['Register']) && !empty($_POST['CustomerName']) 
       && !empty($_POST['Password'])&& !empty($_POST['CustomerAddress'])&& !empty($_POST['CustomerPhoneNumber'])&& !empty($_POST['CustomerOpenHours'])) {

          $curr = $_SESSION['username'];

          $pass = 'delete from customer where username="'.$curr.'"';
          $query = $conn->query($pass);
          
          $pass = "insert into customer values('".$_POST['CustomerName']."', '".$_SESSION['username']."', ".$_POST['CustomerPhoneNumber'].", '".$_POST['CustomerAddress']."', '".$_POST['CustomerEmail']."', '".$_POST['Password']."')";
          $query = $conn->query($pass);

          header("Location: user.php");
          exit();
    }
  ?>
      <h1 class="text-center RRP">Details Update Portal</h1>
      <div class="col-sm-3"></div>
      <div class="col-sm-6 text-center ">

      <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
      
      <?php
        $sql1='select * from customer where username = "'.$_SESSION['username'].'"';
        $query = $conn->query($sql1);
        $result = $query->fetch_assoc();
        echo $result->num_rows;

        echo '<h4> Name <input class="form-control" id="CustomerName" name="CustomerName" placeholder="Name" type="text" value="'.$result['name'].'" required> </h4>
        <h4> Username <input class="form-control" id="CustomerUsername" name="CustomerUsername" placeholder="Username" type="text" value="'.$result['username'].'" required disabled="disabled"> </h4>
        <h4> Phone <input class="form-control" id="CustomerPhoneNumber" name="CustomerPhoneNumber" placeholder="Phone Number" type="number" value='.$result['phone'].' required> </h4>
        <h4> Address <input class="form-control" id="CustomerAddress" name="CustomerAddress" placeholder="Address" type="text" value="'.$result['location'].'" required> </h4>
        <h4> Email <input class="form-control" id="CustomerEmail" name="CustomerEmail" placeholder="Email" type="text" value="'.$result['email'].'" required> </h4>
        <h4> Password <input class="form-control" id="Password" name="Password" placeholder="Password" type="password" value="'.$result['password'].'" required> </h4>

        <button class = "btn but" type = "submit" name = "Register">Update</button>
        </form>';
      ?>
        </div>
      <div class="col-sm-3"></div>
  </body>
</html>
