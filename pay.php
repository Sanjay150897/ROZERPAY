<?php
require('razorpay-php/Razorpay.php');
require_once("config.php");

if (!isset($_SESSION['email'])) {
    header("location:index.php");
    exit();
} else {
    $pid = $_SESSION['pid'];
}
?>

.
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pay</title>
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
                <?php
                include("gateway-config.php");

                use Razorpay\Api\Api;

                $api = new Api($keyId, $keySecret);

                $firstname = $_SESSION['fname'];
                $lastname = $_SESSION['lname'];
                $email = $_SESSION['email'];
                $mobile = $_SESSION['mobile'];
                $address = $_SESSION['address'];
                $note = $_SESSION['note'];

                $sql = "select * from products where pid = :pid";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
                $stmt->execute();
                $row = $stmt->fetch();

                $price = $row['price'];
                $_SESSION['price'] = $price;
                $title = $row['title'];
                $webtitle = "spatel : Razorpay payment Gateway";  // Change web Title
                $displayCurrency = "INR";
                $imageurl = "assets/uploads/ad.jpg";  //change logo from here

                $orderData = [
                    'receipt'         => $pid,
                    'amount'          => $price * 100, // 2000 rupees in paise
                    'currency'        => 'INR',
                    'payment_capture' => 1 // auto capture
                ];

                $razorpayOrder = $api->order->create($orderData);

                $razorpayOrderId = $razorpayOrder['id'];

                $_SESSION['razorpay_order_id'] = $razorpayOrderId;

                $displayAmount = $amount = $orderData['amount'];

                if ($displayCurrency !== 'INR') {
                    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
                    $exchange = json_decode(file_get_contents($url), true);

                    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
                }

                $data = [
                    "key"               => $keyId,
                    "amount"            => $amount,
                    "name"              => $webtitle,
                    "description"       => $title,
                    "image"             => $imageurl,
                    "prefill"           => [
                        "name"              => $firstname . ' ' . $lastname,
                        "email"             => $email,
                        "contact"           => $mobile,
                    ],
                    "notes"             => [
                        "address"           => $address,
                        "merchant_order_id" => "12312321",
                    ],
                    "theme"             => [
                        "color"             => "#F37254"
                    ],
                    "order_id"          => $razorpayOrderId,
                ];

                if ($displayCurrency !== 'INR') {
                    $data['display_currency']  = $displayCurrency;
                    $data['display_amount']    = $displayAmount;
                }

                $json = json_encode($data);
                ?>
                <div class="card px-4 py-1">
                    <div class="row pb-4">
                        <div class="col-8">
                            <h4> (Pay Details) </h4>
                            <div class="pt-4">
                            </div>
                            <div class="mb-3">
                                <label class="label">First Name</label>
                                <?php echo $firstname; ?>
                            </div>
                            <div class="mb-3">
                                <label class="label">Last Name</label>
                                <?php echo $lastname; ?>
                            </div>
                            <div class="mb-3">
                                <label class="label">Email</label>
                                <?php echo $email; ?>
                            </div>
                            <div class="mb-3">
                                <label class="label">Mobile Number</label>
                                <?php echo $mobile; ?>
                            </div>
                            <div class="mb-3">
                                <label class="label">Address</label>
                                <?php echo $address; ?>
                            </div>
                            <div class="mb-3">
                                <label class="label">Note</label>
                                <?php echo $note; ?>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center pt-5">
                            <?php
                            $sql = "select * from products where pid=:pid";
                            $stmt = $db->prepare($sql);
                            $stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
                            $stmt->execute();
                            $row = $stmt->fetch();
                            echo '<div class="card" style="width: 18rem;">
                    <img src="uploads/' . $row['image'] . '" class="card-img-top my-2" alt="Product Image" width="300px" height="200px">
                    <div class="card-body">
                        <h5 class="card-title">' . $row['title'] . '</h5>
                        <p class="card-text">' . $row['price'] . ' INR</p>                        
                    </div>
            </div>';

                            ?>
                            <div class="pt-3">
                                <center>
                                    <form action="verify.php" method="POST">
                                        <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="<?php echo $data['key'] ?>" data-amount="<?php echo $data['amount'] ?>" data-currency="INR" data-name="<?php echo $data['name'] ?>" data-image="<?php echo $data['image'] ?>" data-description="<?php echo $data['description'] ?>" data-prefill.name="<?php echo $data['prefill']['name'] ?>" data-prefill.email="<?php echo $data['prefill']['email'] ?>" data-prefill.contact="<?php echo $data['prefill']['contact'] ?>" data-notes.shopping_order_id="<?php echo $pid;?>" data-order_id="<?php echo $data['order_id'] ?>" <?php if ($displayCurrency !== 'INR') { ?> data-display_amount="<?php echo $data['display_amount'] ?>" <?php } ?> <?php if ($displayCurrency !== 'INR') { ?> data-display_currency="<?php echo $data['display_currency'] ?>" <?php } ?>>
                                        </script>
                                        <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
                                        <input type="hidden" name="shopping_order_id" value="<?php echo $pid; ?>">
                                    </form>
                                </center>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>