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
    <title>Restaurant Add Dish</title>
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
      background-image: url("RestRadBackground.jpg");
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
    if(isset($_POST['Add']) && !empty($_POST['DishName'])) {
    	
      if(empty($_POST['DishPrice'])){
    		$_POST['DishPrice'] = 0;
    	}

      $curr_user = $_GET['username'];

      $max = 1;
    	$get = "select dishid from dish order by dishid desc";
      $result = mysqli_query($dbconnect, $get);
    	if ($result->num_rows > 0) {
          $firstrow = $result->fetch_assoc();
          $max = $firstrow['dishid'] + 1; 
      }

          $pass = "insert into dish values('".$_POST['DishName']."', '".$_POST['Cuisine']."', ".$_POST['DishPrice'].", '".$max."')"; 
          $query = mysqli_query($dbconnect, $pass);

          $pass = "insert into menu values('".$curr_user."', '".$max."')"; 
          $query = mysqli_query($dbconnect, $pass);

          header("Location: restaurant_add.php?username=".$curr_user);
          exit();
    }
  ?>
      <h1 class="text-center CRP">Add Food Item Portal</h1>
      <div class="col-sm-3"></div>
      <div class="col-sm-6 text-center ">
      <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
        <input class="form-control" id="DishName" name="DishName" placeholder="Name" type="text" required>
        <input class="form-control" id="Cuisine" name="Cuisine" placeholder="Cuisine" type="text" required>
        <input class="form-control" id="DishPrice" name="DishPrice" placeholder="Price of Dish (INR)" type="number" required>
        
        <button class = "btn" type = "submit" name = "Add">Add</button>
        </form>
        <h4> <?php echo $msg ?> </h4>
        </div>
      <div class="col-sm-3"></div>
  </body>
</html>
