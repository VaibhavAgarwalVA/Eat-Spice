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
    <title>Orders</title>
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
      background-image: url("bakedGoods.jpg");
  }
  .CRP{
      color: moccasin;
      text-shadow: 10px 10px 10px black;
      opacity: 0.9;
      background-color: #29292c;
      font-size: 67px;
  }
  .tab{
    background-color: burlywood;
  }
  </style>
  </head>

  <body class="Custbody">

      <?php 
          if(isset($_POST['Back'])){
            header("Location: restaurant.php");
            exit();
          }
         $sql = 'select orderid,name,phone,address,email,total,status from customer inner join (select * from place natural join (select * from orders natural join (select orderid, resid from delivery where delivery.resid ="'.$_SESSION['username'].'") as a1) as a2) as a3 on customer.username = a3.custid';
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
              if (isset($_POST['Update'.$row['orderid']])){
                  unset($_POST['Update'.$row['orderid']]);
                  $sql1 = 'update orders set status="'.$_POST['Status'].'" where orderid='.$row['orderid'];
                  $conn->query($sql1);
              }
            }
          }
       ?>

      <h1 class="text-center CRP">View Orders Portal</h1>
      <div class="col-sm-3"></div>
      <div class="col-sm-6 text-center ">
      
        
        <?php
          $sql = 'select orderid,name,phone,address,email,total,status from customer inner join (select * from place natural join (select * from orders natural join (select orderid, resid from delivery where delivery.resid ="'.$_SESSION['username'].'") as a1) as a2) as a3 on customer.username = a3.custid';
          $query = $conn->query($sql);
        ?>
        <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
        <button class = "btn" type = "submit" name = "Back">Back to home!</button>
        <table class="table table-hover tab">
        <thead>
          <tr>
            <th>Customer Name</th>
            <th>Phone Number</th>
            <th>Delivery Address</th>
            <th>Email</th>
            <th>Total Bill</th>
            <th>Current Status</th>
            <th>Update</th>
          </tr>
        </thead>
        <tbody> 
        <?php
          if ($query->num_rows > 0) {
            while($row = $query->fetch_assoc()) { 
         echo ' <tr>
            <td>'.$row['name'].'</td>
            <td>'.$row['phone'].'</td>
            <td>'.$row['address'].'</td>
            <td>'.$row['email'].'</td>
            <td>'.$row['total'].'</td>
            <td><input type="text" name="Status" value="'.$row['status'].'"></td>
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
      <div class="col-sm-3"></div>
  </body>
</html>
