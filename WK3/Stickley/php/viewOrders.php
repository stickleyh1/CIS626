<?php
  require("./init.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Bob's Auto Parts - Customer Orders</title>
    <link href="../css/style.css" rel="stylesheet"/>
  </head>
  <body>
  <img src="../images/logo.jpg"/>
  <h1>Bob's Auto Parts</h1>
    <h2>Customer Orders</h2> 
    <?php
      @$fp = fopen(dirname(__FILE__, 2)."/files/orders.csv", 'rb');
      flock($fp, LOCK_SH); // lock file for reading

      if (!$fp) {
        echo "<p><strong>No orders pending.<br />
              Please try again later.</strong></p>";
        exit;
      }
      echo "<table class='ordersTable'>";
      echo "<thead>";
      echo "<th>Date</th>";
      echo "<th>Tires</th>";
      echo "<th>Oil</th>";
      echo "<th>Spark Plugs</th>";
      echo "<th>Total</th>";
      echo "<th>Address</th>";
      echo "</thead>";
      while (!feof($fp)) {
        $order= explode(",",fgets($fp));
        if($order[0] == ""){
          continue;
        }
        echo "<tr>";
        $index = 0;
        foreach($order as $item){
          if($index != 0){
            $item = explode(" ", $item)[0];
          }
          echo "<td>".$item."</td>";  
          $index++;
        }
        echo "</tr>";         
      }
      echo "</table>";
      flock($fp, LOCK_UN); // release read lock
      fclose($fp); 

    ?>
  </body>
</html>