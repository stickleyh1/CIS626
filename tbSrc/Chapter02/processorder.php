<?php
  // create short variable names
  $tireqty = (int) $_POST['tireqty'];
  $oilqty = (int) $_POST['oilqty'];
  $sparkqty = (int) $_POST['sparkqty'];
  $address = preg_replace('/\t|\R/',' ',$_POST['address']);
  $date = date('H:i, jS F Y');
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
      $echoString = "";
      $echoString .=  "<p>Order processed at ".date('H:i, jS F Y')."</p>";
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

      echo $echoString;

      $outputstring = $date."\t".$tireqty." tires \t".$oilqty." oil\t"
                      .$sparkqty." spark plugs\t\$".$totalamount
                      ."\t". $address."\n";

      // $receiptString = $echoString;
      $receiptString = "";
      $receiptString .= str_replace('<p>', '', $echoString);
      $receiptString = str_replace('</p>', '\n', $receiptString);
      $receiptString = str_replace('<br />', '\n', $receiptString);
      $receiptString = strip_tags($receiptString);

      // echo $receiptString;


      // open file for appending
      @$fp = fopen(dirname(__FILE__)."/orders/orders.txt", 'ab');

      if (!$fp) {
        echo "<p><strong> Your order could not be processed at this time.
               Please try again later.</strong></p>";
        exit;
      }

      flock($fp, LOCK_EX);
      fwrite($fp, $outputstring, strlen($outputstring));
      flock($fp, LOCK_UN);
      fclose($fp);

      echo "<p>Order written.</p>";
    ?>
  </body>
</html>

<?php
      ob_end_clean();

      $receipt = file_put_contents('receipt.txt', $receiptString);
      // flock($receipt, LOCK_EX);
      // fwrite($receipt, $receiptString, strlen($receiptString));
      // flock($receipt, LOCK_UN);
      // fclose($receipt);

      header('Content-type: application/x-download');
      header("Content-Disposition: attachment; filename=\"" . basename('receipt.txt') . "\"");
      header("Content-Type: application/force-download");
      header("Content-Length: " . strlen($receiptString));
      header("Connection: close");
?>

