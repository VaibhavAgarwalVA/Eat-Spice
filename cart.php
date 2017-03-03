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
	  font-size:50px;
	  color:grey;
	  opacity:1;
	background-color:rgba(0,0,0,0.9);
  }
  h1 span{
		background-color:black;
	 }
  body{
	background-image:url(Order_Page.jpg);
	background-size: 100% 100%;
  }
    </style>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

</head>

<body >
 
  <?php
  $User = $_SESSION['username'];
    if(isset($_POST['Order']))
    {
    	$sqlq = 'select * from current_cart';
    	$resultq=mysqli_query($dbconnect, $sqlq);
	 	if (mysqli_num_rows($resultq)) {
	 		$sqlo = 'select max(orderid) as max from cart';
	 		$resulto=mysqli_query($dbconnect, $sqlo);
	 		if(mysqli_num_rows($resulto)){
	 			$rowo = mysqli_fetch_assoc($resulto);
	 			$orderId = $rowo['max'] +1 ;
	 		}
	 		else{
	 			$orderId = 1;
	 		}
		    while($rowq = mysqli_fetch_assoc($resultq))
          	{
          		$sqli = 'insert into cart values('.$orderId.', '.$rowq['dishid'].', '.$rowq['quantity'].')';
          		$resulti = mysqli_query($dbconnect, $sqli);
          	}
          	$total_cart='select sum(quantity) as total_quantity, sum(quantity*cost) as total_cost from dish natural join current_cart';
			$resulttotalcart = mysqli_query($dbconnect, $total_cart);
			$rowtotaldata = mysqli_fetch_assoc($resulttotalcart);
		  	$sqlorder = 'insert into orders values('.$orderId.', '.$rowtotaldata['total_quantity'].', "Order Received")';
         	$resulttotalcart = mysqli_query($dbconnect, $sqlorder);
         	$sqlplace = 'insert into place values('.$orderId.', "'.$User.'")';
         	$resultplace = mysqli_query($dbconnect, $sqlplace);
         	$sqldel = 'insert into delivery values('.$orderId.', "'.$_GET['resid'].'", "Order Received")';
			$resultdel = mysqli_query($dbconnect, $sqldel);
         	$sqlrem = 'delete from current_cart';
          	$res = mysqli_query($dbconnect, $sqlrem);
	        header("Location: user.php"); //For that user
	        exit();
      	}
      	else{
      		echo "No item in the cart";
      		header("Location: user.php"); //For that user
          	exit();
      	}
    }
 ?>

 <div class="row full">
      <div class="col-sm-9 fs maincart">

 
		  
	<h1>Menu of <?php echo $_GET['resid'] ?></h1>

    <table class="table table-hover tab">
		<thead>
			<tr>
				<th><span>Name of Item</span></th>
				<th><span>Cuisine</span></th>
				<th><span>Cost</span></th>
				<th class="text-center"><span>Availability</span></th>
				
			</tr>
		</thead>
		<tbody>
		 <form class = "form-signin" role = "form" action = "<?php $_PHP_SELF ?>" method = "post">
    <?php
	    if(isset($_POST['Back'])){
	      header("Location: user.php");
	      exit();
	    }
	    
         $sql = 'select * from menu,dish where resid = "'.$_GET['resid'].'" and dish.dishid = menu.dishid'; 
         $_SESSION['resid']=$_GET['resid'];
          $result=mysqli_query($dbconnect, $sql);
		 	if (mysqli_num_rows($result)) {
		    // output data of each row
			    while($row = mysqli_fetch_assoc($result)) {
		 	       	echo '<tr><td><p>'.$row["name"].'</a></p></td>';
					echo '<td><p>'.$row["cuisine"].'</p></td>';
					echo '<td><p>'.$row["cost"].'</p></td>';
					echo '<td><p>'.$row["status"].'</p></td>';
					echo '<td><button class = "btn" type = "submit" name = "login'.$row['dishid'].'">+</button>
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
		  
<h1> Cart </h1>

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
	 $sql = 'select * from menu,dish where resid = "'.$_SESSION['resid'].'" and dish.dishid = menu.dishid'; 
	  $result=mysqli_query($dbconnect, $sql);
	 	if (mysqli_num_rows($result)) {
		    while($row = mysqli_fetch_assoc($result)) {
		 		if (isset($_POST['login'.$row['dishid']])){
				    unset($_POST['login'.$row['dishid']]);
		 			$sql2 = 'select * from current_cart where dishid ='.$row['dishid'];
		 			$result2=mysqli_query($dbconnect, $sql2);
		 			if(mysqli_num_rows($result2)){
		 				$cartinfo = mysqli_fetch_assoc($result2);
		 				$qty = $cartinfo['quantity'] + 1;
		 				$sql3 = 'update current_cart set quantity = '.$qty.' where dishid = '.$row['dishid'];
		 				$result3 = mysqli_query($dbconnect, $sql3);
		 			}
		 			else{
		 				$sql4 = 'insert into current_cart values('.$row['dishid'].', 1)';
		 				$result4 = mysqli_query($dbconnect, $sql4);	
		 			}
		 		}
		 	}
		 	$cartdata = 'select * from current_cart natural join dish';
		 	$resultcart = mysqli_query($dbconnect, $cartdata);
		 	while($rowdata = mysqli_fetch_assoc($resultcart)){
		 		echo '<tr><td><p>'.$rowdata["name"].'</p></td>';
				echo '<td><p>'.$rowdata["quantity"].'</p></td>';
				echo '<td><p>'.$rowdata["cost"].'</p></td></tr>';
			}
			$total_cart='select sum(quantity) as total_quantity, sum(quantity*cost) as total_cost from dish natural join current_cart';
			$resulttotalcart = mysqli_query($dbconnect, $total_cart);
			$rowtotaldata = mysqli_fetch_assoc($resulttotalcart);
			echo '<tr><td><p>Total</p></td>';
			echo '<td><p>'.$rowtotaldata['total_quantity'].'</p></td>';
			echo '<td><p>'.$rowtotaldata['total_cost'].'</p></td></tr>';
	 	}
 ?>
 </tbody>
 </table>
 <form method="post" >
			<button type="submit" class="btn btn-primary btn-block btn-large" name = "Order">Order</button>
		</form>
      </div>
</div>
  
    <script src="js/index.js"></script>

</body>
</html>
