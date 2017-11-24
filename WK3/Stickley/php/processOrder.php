<?php
  require("./init.php");
  require("./functions.php");
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $tireqty = $_SESSION['tireqty'] = (int) isSetHandler($_POST['tireqty'], 'number');
    $oilqty = $_SESSION['oilqty'] = (int) isSetHandler($_POST['oilqty'] , 'number');
    $sparkqty = $_SESSION['sparkqty'] = (int) isSetHandler($_POST['sparkqty'], 'number');
    $address = $_SESSION['address'] = isSetHandler($_POST['address'], 'string');
  }else{
    $tireqty = (int) isSetHandler($_SESSION['tireqty'], 'number');
    $oilqty = (int) isSetHandler($_SESSION['oilqty'], 'number');
    $sparkqty = (int) isSetHandler($_SESSION['sparkqty'], 'number');
    $address = isSetHandler($_SESSION['address'], 'string');
  }

  $date = date('H:i- jS F Y');
  $totalqty = 0;
  $totalamount = 0.00;

  define('TIREPRICE', 100);
  define('OILPRICE', 10);
  define('SPARKPRICE', 4);
  
  $totalqty = $tireqty + $oilqty + $sparkqty;

  $totalamount = $tireqty * TIREPRICE
  + $oilqty * OILPRICE
  + $sparkqty * SPARKPRICE;

?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="refresh" content="5;url=sendReceipt.php"/>
    <title>Bob's Auto Parts - Order Results</title>
    <link href="../css/style.css" rel="stylesheet"/>
  </head>
  <body>
    <img src="../images/logo.jpg"/>
    <h1>Bob's Auto Parts</h1>
    <h2>Order Results</h2> 
    <?php
      $echoString = "";

      if ($totalqty == 0) {
        $echoString .=  "You did not order anything on the previous page!<br />";
        echo $echoString;
        exit();
      } else {
        $echoString .=  "<p>Order processed at ".$date."</p>";
        $echoString .=  "<p>Your order is as follows: </p>";
        $echoString .=  "<p>Items ordered: ".$totalqty."<br />";
        if ($tireqty > 0) {
          $echoString .=  htmlspecialchars($tireqty).' tires<br />';
        }
        if ($oilqty > 0) {
          $echoString .=  htmlspecialchars($oilqty).' bottles of oil<br />';
        }
        if ($sparkqty > 0) {
          $echoString .=  htmlspecialchars($sparkqty).' spark plugs<br />';
        }
      }
     
      $echoString .=  "Subtotal: $".number_format($totalamount,2)."<br />";

      $taxrate = 0.10;  // local sales tax is 10%
      $totalamount = $totalamount * (1 + $taxrate);
      $echoString .=  "Total including tax: $".number_format($totalamount,2)."</p>";

      $echoString .=  "<p>Ship to address: ".htmlspecialchars($address)."</p>";

      //Echo Page Contents
      echo $echoString;

      // Reformat html page to txt
      $receiptString = "";
      $receiptString .= str_replace('<p>', "", $echoString);
      $receiptString = str_replace('</p>', "\n", $receiptString);
      $receiptString = str_replace('<br />', "\n", $receiptString);
      $receiptString = str_replace(' ', "\040", $receiptString);
      $receiptString = strip_tags($receiptString);

      //Save txt contents for file download
      $_SESSION['receipt'] = $receiptString;


      $outputstring = $date.","
                      .$tireqty." tires,"
                      .$oilqty." oil,"
                      .$sparkqty." spark plugs,$"
                      .$totalamount.","
                      .$address."\n";

      // open file for appending
      @$fp = fopen(dirname(__FILE__, 2)."/files/orders.csv", 'ab');

      if (!$fp) {
        echo "<p><strong> Your order could not be processed at this time.
               Please try again later.</strong></p>";
        exit;
      }
      if($fp){
        flock($fp, LOCK_EX);
        fwrite($fp, $outputstring, strlen($outputstring));
        flock($fp, LOCK_UN);
        fclose($fp);
      }
      echo "<p>Order written.</p>";
    ?>
    Your download should start automatically. If not click <a href="sendReceipt.php">here</a>.
  </body>
</html>