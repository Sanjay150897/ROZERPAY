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
    <title>Create Products</title>
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
            <div class="col-sm-3"></div>
            <div class="col-sm-6 form-container">
                <h1>Create Product</h1>
                <?php
                if (isset($_POST['submit_form'])) {
                    $title = $_POST['title'];
                    $price = $_POST['price'];
                    $folder = "uploads/";
                    $image_file = $_FILES['image']['name'];
                    $file = $_FILES['image']['tmp_name'];
                    $path = $folder . $image_file;
                    $target_file = $folder . basename($image_file);
                    //move image to the folder 
                    if ($file != '') {
                        move_uploaded_file($file, $target_file);
                    }
                    $sql = "INSERT into products(title,price,image) VALUES(:title,:price,:image)";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
                    $stmt->bindParam(':price', $price, PDO::PARAM_STR);
                    $stmt->bindParam(':image', $image_file, PDO::PARAM_STR);
                    $stmt->execute();
                    header("location:products.php");
                }
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="label">Product Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="label">Product Price</label>
                        <input type="number" name="price" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="label">Product Image</label>
                        <input type="file" name="image" accept="image/" class="form-control">
                    </div>
                    <a href="index.php" class="btn btn-success text-white" style="" ;>Home</a>
                    <button type="submit" name="submit_form" class="btn btn-primary">Create</button>

                </form>
            </div>
        </div>
    </div>

</body>

</html>