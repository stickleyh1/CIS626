<?php
  //removes all unsafe formatting and whitespace
  function formatInput($field) {
    return htmlspecialchars(stripslashes(trim($field)));
  }

  //Validates non-blank input
  //Sets blank input to zero
  function validateInput($field) {
    return empty($field)? 0 : formatInput($field);
  }

  $tireqty = validateInput($_POST['tireqty']);
  $oilqty = validateInput($_POST['oilqty']);
  $sparkqty = validateInput($_POST['sparkqty']);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Bob's Auto Parts - Order Results</title>
  </head>
  <body>
    <h1>Bob's Auto Parts</h1>
    <h2>Order Results</h2> 
    <?php
    echo "<p>Order processed at ";
    echo date('H:i, jS F Y');
    echo "</p>";

    if(empty($tireqty) && empty($oilqty) && empty($sparkqty)){
      echo '<p>Your order was empty!</p>';
    }else{
      echo '<p>Your order is as follows: </p>';

      echo $tireqty.' tires<br />';
      echo $oilqty.' bottles of oil<br />';
      echo $sparkqty.' spark plugs<br />';

      $totalqty = 0;
      $totalqty = $tireqty + $oilqty + $sparkqty;
      echo "<p>Items ordered: ".$totalqty."<br />";
      $totalamount = 0.00;

      define('TIREPRICE', 100);
      define('OILPRICE', 10);
      define('SPARKPRICE', 4);

      $totalamount = $tireqty * TIREPRICE
                   + $oilqty * OILPRICE
                   + $sparkqty * SPARKPRICE;

      echo "Subtotal: $".number_format($totalamount,2)."<br />";
      
      $taxrate = 0.10;  // local sales tax is 10%
      $totalamount = $totalamount * (1 + $taxrate);
      echo "Total including tax: $".number_format($totalamount,2)."</p>";
    }
    ?>  
  </body>
</html>
