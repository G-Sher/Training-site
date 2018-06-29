<?php

// Include Functions and DB connection
include 'scDB.php';
include("functions.php");
session_start();

// PayPal settings
$paypal_email = 'GSher2512@gmail.com';
$return_url = 'http://geoffsher.com/success.html';
$cancel_url = 'http://geoffsher.com/cancel.html';
$notify_url = 'http://geoffsher.com/payments.php';
$total = $_SESSION['total'];

$item_name = 'Shopping Cart Total';
$item_amount = $total;


// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){
    $querystring = '';

    // Firstly Append paypal account to querystring
    $querystring .= "?business=".urlencode($paypal_email)."&";

    // Append amount& currency (£) to quersytring so it cannot be edited in html

    //The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
    $querystring .= "item_name=".urlencode($item_name)."&";
    $querystring .= "amount=".urlencode($item_amount)."&";

    //loop for posted values and append to querystring
    foreach($_POST as $key => $value){
        $value = urlencode(stripslashes($value));
        $querystring .= "$key=$value&";
    }

    // Append paypal return addresses
    $querystring .= "return=".urlencode(stripslashes($return_url))."&";
    $querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
    $querystring .= "notify_url=".urlencode($notify_url);

    // Append querystring with custom field
    //$querystring .= "&custom=".USERID;

    // Redirect to paypal IPN
    header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
    exit();
} else{
    // Response from Paypal
    
    // read the post from PayPal system and add 'cmd'
    $req = 'cmd=_notify-validate';
    foreach ($_POST as $key => $value) {
        $value = urlencode(stripslashes($value));
        $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
        $req .= "&$key=$value";
    }

    // assign posted variables to local variables
    $data['item_name']          = $_POST['item_name'];
    $data['item_number']        = $_POST['item_number'];
    $data['payment_status']     = $_POST['payment_status'];
    $data['payment_amount']     = $_POST['mc_gross'];
    $data['payment_currency']   = $_POST['mc_currency'];
    $data['txn_id']             = $_POST['txn_id'];
    $data['receiver_email']     = $_POST['receiver_email'];
    $data['payer_email']        = $_POST['payer_email'];
    $data['custom']             = $_POST['custom'];

    // post back to PayPal system to validate
    $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
 
    $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

    if (!$fp) {
        // HTTP ERROR
    } else {
        
    //    fputs($fp, $header . $req);
    //    while (!feof($fp)) {
    //        $res = fgets ($fp, 1024);
    //        if (strcmp($res, "VERIFIED") == 0) {

                // Used for debugging
                 

                // Validate payment (Check unique txnid & correct price)
                $valid_txnid = check_txnid($data['txn_id']);
                $valid_price = check_price($data['payment_amount'], $data['item_number']);

                // PAYMENT VALIDATED & VERIFIED!
                if ($valid_txnid && $valid_price) {
            
                    $orderid = updatePayments($data);

                    if ($orderid) {
                        //database updated successfully
                        mail('gsher2512@gmail.com', 'Transaction Posted', 'Good work!', 'from you');
                    } 
                    else {
                        
                        // Error inserting into DB
                        // E-mail admin or alert user
                         mail('gsher2512@gmail.com', 'PAYPAL POST - INSERT INTO DB WENT WRONG', 'You suck!', "from you");
                    }
                } else {
                    // Payment made but data has been changed
                    // E-mail admin or alert user
                    mail('gsher2512@gmail.com', 'User '.$data['payer_email'].' did not pay the correct amount', print_r($data, true));
                }

    //        } else if (strcmp ($res, "INVALID") == 0) {
    //            mail('gsher2512@gmail.com', "Didn't work after FsockOpen", "yea, look at the subject, dummy", 'from you');
                // PAYMENT INVALID & INVESTIGATE MANUALY!
                // E-mail admin or alert user

                // Used for debugging
                //@mail("user@domain.com", "PAYPAL DEBUGGING", "Invalid Response
    //            $data =
    //            "<pre>".print_r($post, true)."</pre>";
    //        }
    //        else{
    //            mail('gsher2512@gmail.com','nothing works anymore', 'hello darkness my old friend ' . $res . ' stupid.', 'from you');
    //        }
    //    }
    fclose ($fp);
    }
}  
                