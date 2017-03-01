<?php
	$dbconnect = mysqli_connect("10.5.18.104", "14CS10059", "btech14", "test");
	if(mysqli_connect_errno()) {
		echo "Connection failed:".mysqli_connect_error();
		exit;
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
      background-color: #29292c;
      font-size: 67px;
  }
  </style>
  </head>
  <body class="Custbody">
  <?php
    if(isset($_POST['AddDish'])) {
    	echo "here";
    	$curr_user = $_SESSION['username']; 
    	echo $curr_user;
        // header("Location: restaurant_add.php?username=".$_GET['username']);
        // exit();
    }
  ?>
      <h1 class="text-center CRP">Restaurant Portal</h1>
      <div class="col-sm-3"></div>
      <div class="col-sm-6 text-center ">
      <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
        <button class = "btn" type = "submit" name = "AddDish">Add new dishes!</button>
        <button class = "btn" type = "submit" name = "UpdateInfo">Update Info</button>
        <button class = "btn" type = "submit" name = "ViewOrders">View Previous Orders</button>
      </form>

        <h4> 
        <?php
	        // $curr_user = $_GET['username']; 
        	//         	echo $curr_user;
        ?> 
        </h4>
        
        </div>
      <div class="col-sm-3"></div>
  </body>
</html>
