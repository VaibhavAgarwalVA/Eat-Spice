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
  .tab{
    background-color: burlywood;
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
    if(isset($_POST['Back'])){
      header("Location: restaurant.php");
      exit();
    }
    if(isset($_POST['Add']) && !empty($_POST['DishName'])) {
      
      if(empty($_POST['DishPrice'])){
        $_POST['DishPrice'] = 0;
      }
      $curr_user = $_SESSION['username'];
      $max = 1;
      $get = "select dishid from dish order by dishid desc";
      $result = $conn->query($get);
      if ($result->num_rows > 0) {
          $firstrow = $result->fetch_assoc();
          $max = $firstrow['dishid'] + 1; 
      }
          $pass = "insert into dish values('".$_POST['DishName']."', '".$_POST['Cuisine']."', ".$_POST['DishPrice'].", '".$max."')";
          $query = $conn->query($pass);
          $pass = "insert into menu values('".$curr_user."','".$max."','Available')"; 
          $query = $conn->query($pass);
          header("Location: restaurant_add.php");
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

        <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
          <button class = "btn" type = "submit" name = "Back">Back to home!</button>
        </form>
        <!--<h4> <?php echo $msg ?> </h4>-->

         <?php
            $get = 'select dish.name,cuisine,cost,dish.dishid,status from dish inner join 
            (select * from restaurant, menu where restaurant.username = menu.resid and 
              restaurant.username = "'.$_SESSION['username'].'") as a1 on dish.dishid = a1.dishid order by status';
            $result = $conn->query($get);
         ?>

            <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars
            ($_SERVER['PHP_SELF']); ?>" method = "post">

            <table class="table table-bordered tab">
              <h3>Menu</h3>
              <thead>
                <tr>
                  <th>Dish ID</th>
                  <th>Dish Name</th>
                  <th>Cuisine</th>
                  <th>Dish Cost</th>
                  <th>Status</th>
                </tr>
              </thead>

            <tbody>
            <?php
             if($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) { 
                  echo ' <tr>
                    <td>'.$row['dishid'].'</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['cuisine'].'</td>
                    <td>'.$row['cost'].'</td>
                    <td>'.$row['status'].'</td>
                  </tr>';
              }      
            }
            else{
              echo "There is nothing in the menu currently";
            }
          $conn->close();
         ?> 
        </tbody>
        </table>
        </form>

        </div>
      <div class="col-sm-3"></div>
  </body>
</html>