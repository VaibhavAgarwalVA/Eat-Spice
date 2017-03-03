<?php
	session_start();
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
      background-color:red;
      opacity: 1;
  }
  .sidecart{
      background-color:green;
      opacity: 0.8;
  }
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

  </head>
  <body>
      <!--<div class="row">
      <div class="col-sm-12 test">
      </div></div>-->
      <div class="row full">
      <div class="col-sm-8 fs maincart">
          <?php
          if(isset($_POST['Go'])){
              $selected_table = $_POST['Type'];
              $_SESSION['selected_table']=$selected_table;
              $table_form="desc ".$selected_table;
              $result=mysqli_query($dbconnect, $table_form);
              $array=array();
              if (mysqli_num_rows($result)) {
			    // output data of each row
                echo '<form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER[\'PHP_SELF\']); ?>" method = "post">
                <table class="table table-hover tab">
                <thead>
                <tr>';
			    while($row = mysqli_fetch_assoc($result)) {
                    echo '<th>'.$row["Field"].'</th>';
                    $array[]=$row["Field"];
			  		  }
                    echo '</tr>
                    </thead>';
					}
                $table_Data='select * from '.$selected_table;
                // echo $table_Data;
                $resul=mysqli_query($dbconnect, $table_Data);
                $num=count($array);
                $i=0;
                // echo mysqli_num_rows($resul);
                if (mysqli_num_rows($resul)) {
                    while($row = mysqli_fetch_assoc($resul)) {
                        echo '<tr>';
                        $j=0;
                        $i=0;
                        while($i<$num){
                            echo '<td><input type="text" name="Status'.$i.''.$j.'" value="'.$row[$array[$i]].'" disabled="disabled"></td>';
                            $i=$i+1;
                        }
                        $j=$j+1;
                        // echo '
                        // <td><button class = "btn" type = "submit" name = "Update'.$j.'">Update</button></td>';
                        echo '</tr>';
                    }
                }
            echo '
                    </table>';
          }
          ?>
      </div>
      <div class="col-sm-4 fs sidecart">
           <form method="post">
               <select name="Type" class="form-control" id="Typeselect">
            <?php
				$sql = "show tables";
				$result=mysqli_query($dbconnect, $sql);
			 		echo "<option>All</option>";		
			 	if (mysqli_num_rows($result)) {
			    // output data of each row
			    while($row = mysqli_fetch_assoc($result)) {
                    // echo $row["tables_in_test"];
			 	       	echo "<option>".$row["Tables_in_test"]."</option> ";
			  		  }
					} else {
			 		echo "<option>else</option>";
			    }		
			?>
        </select>
        <div ><button type="submit" class="btn btn-primary btn-block btn-large" name = "Go">Go</button></div>
    </form>

      </div>
      </div>
  </body>
</html>