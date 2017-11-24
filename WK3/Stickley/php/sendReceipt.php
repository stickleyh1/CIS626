<?php
    require("./init.php");
        $filename = 'receipt_'.date('j-m-y').'.txt';
        if(isset($_SESSION['receipt'])){
        $str = $_SESSION['receipt'];

        $file = fopen($filename, "w");
        fwrite($file, $str);
        fclose($file);
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/force-download");
        header("Content-Type: application/download");
        header('Content-Disposition: attachment; filename='.basename($filename));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        readfile($filename);
        unlink($filename);
        unset($_SESSION['receipt']);
        }else{
            header('Location: processOrder.php');
        }
?>