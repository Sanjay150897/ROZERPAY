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
    <title>Product Details</title>
    <link rel="stylesheet" href="">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap CSS -->

    <!--CSS file -->

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8 form-container">
                <h1>Create Product</h1>
                <hr>
                <a href="index.php" class="btn btn-info text-white" style="float: right;">Home</a>
                <a href="create_product.php" class="btn btn-secondary" style="float: right;margin-right:5px;" >Create New</a>
                <table class="table">
                    <tr>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Image</th>
                    </tr>
                    <?php
                    $sql = "select * from products order by pid desc";
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                    $rows = $stmt->fetchAll();
                    foreach ($rows as $row) {
                        echo '<tr>
                    <td> <img src="uploads/' . $row['image'] . '" height="100"></td>
                    <td>' . $row['title'] . '</td>
                    <td> ' . $row['price'] . ' </td> 
                    </tr>';
                    }
                    ?>

                </table>

            </div>
        </div>
    </div>

</body>

</html>