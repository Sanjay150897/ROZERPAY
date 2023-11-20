<?php
require_once("config.php");
$pid = $_GET['product_id'];

$sql = "select count(*) from products where pid=:pid";
$stmt = $db->prepare($sql);
$stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
$stmt->execute();
$count = $stmt->fetchcolumn();
if ($count == 0) {
    header("location:index.php");
    exit();
}
?>

.
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Checkout</title>
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
                <h1><span style="color:blue;font-weight:bolder;"> C H E<span style="color:red;font-weight:bolder;"> C K O</span><span style="color:green;font-weight:bolder;"> U T</span></h1>
                <hr>
                <?php
                if (isset($_POST['submit_form'])) {

                    $_SESSION['fname'] = $_POST['fname'];
                    $_SESSION['lname'] = $_POST['lname'];
                    $_SESSION['email'] = $_POST['email'];
                    $_SESSION['mobile'] = $_POST['mobile'];
                    $_SESSION['address'] = $_POST['address'];
                    $_SESSION['note'] = $_POST['note'];
                    $_SESSION['pid'] = $pid;

                    if ($_POST['email'] != '') {
                        header("location:pay.php");
                    }
                }

                ?>
                <div class="card px-4 py-1">
                    <div class="row pb-4">
                        <div class="col-8">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="pt-4">
                                </div>
                                <div class="mb-3">
                                    <label class="label">First Name</label>
                                    <input type="text" name="fname" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="label">Last Name</label>
                                    <input type="text" name="lname" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="label">Email</label>
                                    <input type="text" name="email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="label">Mobile Number</label>
                                    <input type="number" name="mobile" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="label">Address</label>
                                    <textarea name="address" class="form-control" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="label">Note</label>
                                    <textarea name="note" class="form-control" required></textarea>
                                </div>
                                <!-- <a href="index.php" class="btn btn-success text-white" style="">Home</a>
                        <button type="submit" name="submit_form" class="btn btn-primary">Create</button> -->

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
                            <div class="pT-3">
                                <button type="submit" class="btn btn-primary" name="submit_form">Place Order</button>
                                <button type="RESET" class="btn btn-danger">Reset</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>