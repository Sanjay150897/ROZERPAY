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
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Payment Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 form-container">
        <h1?>Payment</h1>
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

          $sql = "SELECT * from products WHERE pid=:pid";
          $stmt = $db->prepare($sql);
          $stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
          $stmt->execute();
          $row = $stmt->fetch();
          $price = $row['price'];
          $_SESSION['price'] = $price;
          $title = $row['title'];
          $_SESSION['title'] = $title;
          $webtitle = "Payment Gateway";
          $displayCurrency = 'INR';
          $imageurl = 'data:image/jpeg;base64,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'; //change logo from here

          $orderData = [
            'receipt'         => 3456,
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
          <div class="row">
            <div class="col-8">
              <h4>( Pay details )</h4>
              <div class="mb-3">
                <label class="label">First Name</label>
                <?php echo $firstname; ?>
              </div>
              <div class="mb-3">
                <label class="label">Last Name</label>                
                <?php echo $lastname; ?>
              </div>

              <div class="mb-3">
                <label class="label">Email </label>
                <?php echo $email; ?>
              </div>
              <div class="mb-3">
                <label class="label">Mobile</label>
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
            <div class="col-4 text-center">
              <?php
              $sql = "SELECT * from products WHERE pid=:pid";
              $stmt = $db->prepare($sql);
              $stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
              $stmt->execute();
              $row = $stmt->fetch();
              echo '<div class="card" style="width: 18rem;">
           <img class="card-img-top" src="uploads/' . $row['image'] . '" alt="Card image cap">
           <div class="card-body">
              <h5 class="card-title">' . $row['title'] . '</h5>
              <p class="card-text">' . $row['price'] . ' INR</p>
           </div>
          </div>';
              ?>
              <br>
              <center>
              <form action="verify.php" method="POST">
  <script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="<?php echo $data['key']?>"
    data-amount="<?php echo $data['amount']?>"
    data-currency="INR"
    data-name="<?php echo $data['name']?>"
    data-image="<?php echo $data['image']?>"
    data-description="<?php echo $data['description']?>"
    data-prefill.name="<?php echo $data['prefill']['name']?>"
    data-prefill.email="<?php echo $data['prefill']['email']?>"
    data-prefill.contact="<?php echo $data['prefill']['contact']?>"
    data-notes.shopping_order_id="<?php echo $pid; ?>"
    data-order_id="<?php echo $data['order_id']?>"
    <?php if ($displayCurrency !== 'INR') { ?> data-display_amount="<?php echo $data['display_amount']?>" <?php } ?>
    <?php if ($displayCurrency !== 'INR') { ?> data-display_currency="<?php echo $data['display_currency']?>" <?php } ?>
  >
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
</body>

</html>