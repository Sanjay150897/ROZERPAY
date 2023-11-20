<?php
require('razorpay-php/Razorpay.php');
require_once("config.php");

$pid = $_SESSION['pid'];

?>

.
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Payment Verify</title>
    <link rel="stylesheet" href="">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap CSS -->

    <!--CSS file -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row py-2">
            <div class="col-sm-12 form-container">
                <h1><span style="color:blue;font-weight:bolder;"> P A Y<span style="color:red;font-weight:bolder;"> M </span><span style="color:blueviolet;font-weight:bolder;">E N T</span></h1>
                
                <hr>

                <div class="card px-4 py-1">
                    <div class="row pb-4">
                        <div class="col-8">                            
                            <h4>Payment status</h4>                            
                            <?php

                            include("gateway-config.php");

                            use Razorpay\Api\Api;
                            use Razorpay\Api\Errors\SignatureVerificationError;

                            $success = true;

                            $error = "Payment Failed";

                            if (empty($_POST['razorpay_payment_id']) === false) {
                                $api = new Api($keyId, $keySecret);

                                try {
                                    // Please note that the razorpay order ID must
                                    // come from a trusted source (session here, but
                                    // could be database or something else)
                                    $attributes = array(
                                        'razorpay_order_id' => $_SESSION['razorpay_order_id'],
                                        'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                                        'razorpay_signature' => $_POST['razorpay_signature']
                                    );

                                    $api->utility->verifyPaymentSignature($attributes);
                                } catch (SignatureVerificationError $e) {
                                    $success = false;
                                    $error = 'Razorpay Error : ' . $e->getMessage();
                                }
                            }

                            if ($success === true) {

                                $firstname = $_SESSION['fname'];
                                $lastname = $_SESSION['lname'];
                                $email = $_SESSION['email'];
                                $mobile = $_SESSION['mobile'];
                                $address = $_SESSION['address'];
                                $note = $_SESSION['note'];

                                $posted_hash = $_SESSION['razorpay_order_id'];

                                if (isset($_POST['razorpay_payment_id'])) {

                                    $txnid = $_POST['razorpay_payment_id'];
                                    $amount = $_SESSION['price'];
                                    $status = "success";
                                    $eid = $_POST['shopping_order_id'];
                                    $subject = "Your payment has benn successfull...";
                                    $key_value = 'okpmt';
                                    $currency = "INR";
                                    $date = new DateTime(null, new DateTimezone("Asia/kolkata"));
                                    $payment_date = $date->format("d-m-Y H:i:s");

                                    $sql = "select count(*) from payments where txnid=:txnid";
                                    $stmt = $db->prepare($sql);
                                    $stmt->bindParam(':txnid', $txnid, PDO::PARAM_STR);
                                    $stmt->execute();
                                    $counts = $stmt->fetchColumn();

                                    if ($txnid != '') {
                                        if ($counts <= 0) {
                                            $sql = "insert into payments(firstname,lastname,amount,status,txnid,pid,payer_email,
                                            currency,mobile,address,note,payment_date) values(:firstname,:lastname,:amount,:status,:txnid,
                                            :pid,:payer_email,:currency,:mobile,:address,:note,:payment_date)";
                                            $stmt = $db->prepare($sql);
                                            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
                                            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
                                            $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
                                            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
                                            $stmt->bindParam(':txnid', $txnid, PDO::PARAM_STR);
                                            $stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
                                            $stmt->bindParam(':payer_email', $email, PDO::PARAM_STR);
                                            $stmt->bindParam(':currency', $currency, PDO::PARAM_STR);
                                            $stmt->bindParam(':mobile', $mobile, PDO::PARAM_STR);
                                            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
                                            $stmt->bindParam(':note', $note, PDO::PARAM_STR);
                                            $stmt->bindParam(':payment_date', $payment_date, PDO::PARAM_STR);
                                            $stmt->execute();
                                        }
                                        // start 
                                        echo ' <h2 style="color:#33FF00";>' . $subject . '</h2>   <hr>';

                                        echo '<table class="table">';
                                        echo '<tr> ';
                                        $rows = $sql = "SELECT * from payments WHERE txnid=:txnid";
                                        $stmt = $db->prepare($sql);
                                        $stmt->bindParam(':txnid', $txnid, PDO::PARAM_STR);
                                        $stmt->execute();
                                        $rows = $stmt->fetchAll();
                                        foreach ($rows as $row) {
                                            $dbdate = $row['payment_date'];
                                        }
                                        echo '<tr>  
                                      <th>Transaction ID:</th>
                                    <td>' . $txnid . '</td> 
                                </tr>
                                 <tr> 
                                    <th>Paid Amount:</th>
                                    <td>' . $amount . ' ' . $currency . '</td> 
                                </tr>
                                <tr>
                                   <th>Payment Status:</th>
                                    <td>' . $status . '</td> 
                               </tr>
                               <tr> 
                                   <th>Payer Email:</th>
                                   <td>' . $email . '</td> 
                               </tr>
                                <tr> 
                                   <th>Name:</th>
                                   <td>' . $firstname . ' ' . $lastname . '</td>
                               </tr>
                               <tr> 
                                   <th>Address:</th>
                                   <td>' . $address . '</td>
                               </tr>
                               <tr> 
                                   <th>Note:</th>
                                   <td>' . $note . '</td>
                               </tr>
                            
                               <tr>
                                   <th>Date :</th>
                                   <td>' . $dbdate . '</td> 
                              </tr>
                              </table>';
                                    } else {
                                        $html = "<p><div class='errmsg'>Invalid Transaction. Please Try Again</div></p>";
                                        $error_found = 1;
                                    }
                                }
                            } else {
                                $html = "<p><div class='errmsg'>Invalid Transaction. Please Try Again</div></p>
                                  <p>{$error}</p>";
                                $error_found = 1;
                            }
                            if (isset($html)) {
                                echo $html;
                            }
                            ?>
                        </div>
                        <div class="col-sm-4 text-center pt-5">
                        <?php
                        if (!isset($error_found)) {
                            $sql = "SELECT * from products WHERE pid=:pid";
                            $stmt = $db->prepare($sql);
                            $stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
                            $stmt->execute();
                            $row = $stmt->fetch();
                            echo '<div class="card" style="width: 18rem;">
                                <img class="card-img-top" src="uploads/' . $row['image'] . '" alt="Card image cap">
                                <div class="card-body">
                                  <h5 class="card-title">' . $row['title'] . '</h5>
                                  <p class="card-title">' . $row['price'] . ' INR</p>
                                </div>
                              </div>';
                        }
                        ?>
                        <br>
                            <a href="index.php" class="btn btn-warning text-right">Go To Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>