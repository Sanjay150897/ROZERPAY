<?php
require_once("config.php");
?>

.
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Shop</title>
    <link rel="stylesheet" href="">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap CSS -->

    <!--CSS file -->

    <link rel="stylesheet" href="style.css">

    <style>
.navbar{
    background-color: aqua;
    color: black;
    font-weight: bolder;
}
ul,a{
    list-style-type: none;
    color: black;
}
    </style>
</head>

<body>
    <div class="container">
        <nav class="navbar justify-content-center d-flex">
            <ul id="menu"><a href="index.php">Home</a></ul>
            <ul id="menu"><a href="create_product.php">Create Product</a></ul>
            <ul id="menu"><a href="products.php">Products List</a></ul>
            <ul id="menu"><a href="payments.php">Payment Details</a></ul>
        </nav>
        <div class="row">
            <?php
            $sql = "select * from products order by pid desc";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach ($rows as $row) {
                echo '<div class="col-4 text-center my-2">
                <div class="card" style="width: 18rem;">
                    <img src="uploads/' . $row['image'] . '" class="card-img-top my-2" alt="Product Image" width="300px" height="200px">
                    <div class="card-body">
                        <h5 class="card-title">'.$row['title'].'</h5>
                        <p class="card-text">'.$row['price'].'</p>
                        <a href="checkout.php?product_id='.$row['pid'].'" class="btn btn-primary">Buy Now</a>
                    </div>
                </div>
            </div>';
            }
            ?>
        </div>
    </div>

</body>

</html>