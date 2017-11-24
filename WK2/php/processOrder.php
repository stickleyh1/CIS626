<?php
  error_reporting(E_ALL);
  session_start();
  session_unset();
  //removes all unsafe formatting and whitespace
  function formatInput($field) {
    return htmlspecialchars(stripslashes(trim($field)));
  }

  //Validates non-blank input
  //Sets blank input to zero
  function validateInput($field) {
    return empty($field)? 0 : formatInput($field);
  }

    $tireqty = $_SESSION['tireqty'] = (int) isset($_POST['tireqty'])?validateInput($_POST['tireqty']):0;
    $oilqty = $_SESSION['oilqty'] = (int) isset($_POST['oilqty'])?validateInput($_POST['oilqty']):0;
    $sparkqty = $_SESSION['sparkqty'] = (int) isset($_POST['sparkqty'])?validateInput($_POST['sparkqty']):0;
    $address = $_SESSION['address'] = isset($_POST['address'])?preg_replace('/\t|\R/',' ', validateInput($_POST['address'])): "";

  $date = date('H:i, jS F Y');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="refresh" content="5;url=sendReceipt.php"/>
    <title>Bob's Auto Parts - Order Results</title>
  </head>
  <body>
    <h1>Bob's Auto Parts</h1>
    <h2>Order Results</h2> 
    <?php
      $echoString = "";
      $echoString .=  "<p>Order processed at ".$date."</p>";
      $echoString .=  "<p>Your order is as follows: </p>";

      $totalqty = 0;
      $totalamount = 0.00;

      define('TIREPRICE', 100);
      define('OILPRICE', 10);
      define('SPARKPRICE', 4);

      $totalqty = $tireqty + $oilqty + $sparkqty;
      $echoString .=  "<p>Items ordered: ".$totalqty."<br />";

      if ($totalqty == 0) {
        $echoString .=  "You did not order anything on the previous page!<br />";
        echo $echoString;
        exit();
      } else {
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


      $totalamount = $tireqty * TIREPRICE
                   + $oilqty * OILPRICE
                   + $sparkqty * SPARKPRICE;

      $echoString .=  "Subtotal: $".number_format($totalamount,2)."<br />";

      $taxrate = 0.10;  // local sales tax is 10%
      $totalamount = $totalamount * (1 + $taxrate);
      $echoString .=  "Total including tax: $".number_format($totalamount,2)."</p>";

      $echoString .=  "<p>Address to ship to is ".htmlspecialchars($address)."</p>";

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


      $outputstring = $date."\t".$tireqty." tires \t\t\t".$oilqty." oil\t\t\t"
                      .$sparkqty." spark plugs\t\t\t\$".$totalamount
                      ."\t\t\t". $address."\n";

      // open file for appending
      @$fp = fopen(dirname(__FILE__, 2)."/orders/orders.txt", 'ab');

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