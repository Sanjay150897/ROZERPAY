<?php
require_once("config.php");
$pid = $_GET['product_id'];

$sql = "select count(*) from products where pid=:pid";
$stmt = $db->prepare($sql);
$stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
$stmt->execute();
$count = $stmt->fetchcolumn();
if($count == 0){
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
         
        </div>
    </div>

</body>

</html>