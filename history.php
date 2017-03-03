<?php
	session_start();
  include("dbconnect.php");
?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  
      <style>
	  .tab{
	  	margin-top:10vh;
    background-color: burlywood;
  }
     .test{
      position:fixed;
      width: 100%;
      height:100%;
      background-color: blue;
      z-index: 1;
  }
  .full{
      width:100%;
  }
  .fs{
      position:relative;
      height: 100vh;
      z-index: 2;
  }
  .maincart{
      /*opacity: 0.8;*/
  }
  .sidecart{
      background-color:rgba(0,0,0,0.9);
      /*opacity: 0.9;*/
  }
  .sidecart p{
	  color:grey;
  }
  .sidecart th{
	  color:grey;
  }
  h1{
	  text-align:center;
	  font-size:40px;
	  color:grey;
	  opacity:1;
	background-color:rgba(0,0,0,0.9);
  }
  h1 span{
		background-color:black;
	 }
  body{
	background-image:url(pieCake.jpg);
	background-size: 100% 100%;
  }
    </style>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

</head>

<body >
<h1>Hi <?php echo $_SESSION['username']; ?>, your orders are </h1>
 <div class="row full">
      <div class="col-sm-9 fs maincart">

 
	    <table class="table tab">
		<thead>
			<tr>
				<th><!-- <a href="#"> --><span>OrderID</span></th>
				<th><!-- <a href="#"> --><span>Quantity</span></th>
				<!-- <th><a href="#"><span>TEAM B</span></a></th> -->
				<th><span>Status</span></th>
				<th><span>View Order</span></th>				
			</tr>
		</thead>
		<tbody>
		<form class = "form-signin" role = "form" action = "<?php $_PHP_SELF ?>" method = "post">
    <?php
			if(isset($_POST['Back'])){
		      header("Location: user.php");
		      exit();
		    }
		    
    	  $sql = "select * from place natural join orders where custid = '".$_SESSION['username']."'";
          $result=mysqli_query($dbconnect, $sql);
		 	if (mysqli_num_rows($result)) {
		    // output data of each row
			    while($row = mysqli_fetch_assoc($result)) {
		 	       	echo '<tr><td><p>'.$row["orderid"].'</p></td>';
					echo '<td><p>'.$row["total"].'</p></td>';
					echo '<td><p>'.$row["status"].'</p></td>';
			  		echo '<td><button class = "btn" type = "submit" name = "login'.$row['orderid'].'">View</button>
					</tr>';
			  	}
			} 
			else {
		 		echo "<option>else</option>";
	    	}
  ?>
  </form>

  <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
          <button class = "btn" type = "submit" name = "Back">Back to home!</button>
   </form>

	</tbody>
</table>
      </div>
      <div class="col-sm-3 fs sidecart">
		  
<h1> Order Summary </h1>

<table class="table table-hover">
		<thead>
			<tr>
				<th><span>Name of Item</span></th>
				<th><span>Quantity</span></th>
				<th><span>Cost</span></th>
			</tr>
		</thead>
		<tbody>
<?php 

	 $sql = "select * from place natural join orders where custid = '".$_SESSION['username']."'";
	 $result=mysqli_query($dbconnect, $sql);
	 if (mysqli_num_rows($result)) {
	    while($row = mysqli_fetch_assoc($result)) {
		 		if (isset($_POST['login'.$row['orderid']])){
				    unset($_POST['login'.$row['orderid']]);
		 			$cartdata = 'select * from cart natural join dish where orderid ='.$row['orderid'];
		 			$resultcart = mysqli_query($dbconnect, $cartdata);
		 			while($rowdata = mysqli_fetch_assoc($resultcart)){
				 		echo '<tr><td><p>'.$rowdata["name"].'</p></td>';
						echo '<td><p>'.$rowdata["quantity"].'</p></td>';
						echo '<td><p>'.$rowdata["cost"].'</p></td></tr>';
					}
					$total_cart='select sum(quantity) as total_quantity, sum(quantity*cost) as total_cost from cart natural join dish where orderid ='.$row['orderid'];
					$resulttotalcart = mysqli_query($dbconnect, $total_cart);
					$rowtotaldata = mysqli_fetch_assoc($resulttotalcart);
					echo '<tr><td><p>Total</p></td>';
					echo '<td><p>'.$rowtotaldata['total_quantity'].'</p></td>';
					echo '<td><p>'.$rowtotaldata['total_cost'].'</p></td></tr>';
		 		}
		 	}
	 	}
 ?>

      </div>
</div>
  
    <script src="js/index.js"></script>

</body>
</html>
