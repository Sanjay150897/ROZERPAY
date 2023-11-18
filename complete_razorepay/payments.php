<?php require_once("config.php");?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Payments | Orders - Techno Smarter </title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 form-container">
				<h1>Payments | Orders</h1>
				<hr>
				<table class="table">
					<tr>
						 <th>Paid By </th>
						 <th>Payer Email</th>
						  <th>Txn Id </th>
						<th>Product Image</th>
						<th>Title</th>
						<th>Paid Amount</th>
							<th>Address</th>
							<th>Mobile</th>
								<th>Note</th>
							 <th>Order Date</th>
					</tr>
				<?php 
					 $sql="SELECT * from products,payments WHERE products.pid=payments.pid order by payments.payid DESC "; 
         $stmt = $db->prepare($sql);
           $stmt->execute();
           $rows=$stmt->fetchAll();
           foreach ($rows as $row) {
           echo '<tr>
           <td>'.$row['firstname'].' '.$row['lastname'].'</td>
           <td>'.$row['payer_email'].'</td>
            <td>'.$row['txnid'].'</td>
              <td><img src="uploads/'.$row['image'].'" height="100"></td>
               <td>'.$row['title'].'</td>
               <td>'.$row['amount'].' INR</td>
               <td>'.$row['address'].'</td>
               <td>'.$row['mobile'].'</td>
               <td>'.$row['note'].'</td>
               <td>'.$row['payment_date'].'</td>
           </tr>';
           }
				?> 
		</table> 
		</div>
	</div>
	
</div>
</body>
</html>