<?php
//create, populate, connect to DB
require "scDB.php";
include "scFunctions.php";
?>
<!DOCTYPE html>
<html>

	<head>
		<title>Shopping Cart</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<link rel="stylesheet" href="cart.css" />

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	
	<body style= "background-color: #fffff";>
		<div class= "row" style= "margin-top: 50px">
			<div class= "col-sm-4"></div>
			<div class= "col-sm-4">
				<h2>Choose a Certification</h2>
			</div>
			<div class="col-sm-4"></div>
		</div>
		<div class="row" style= "margin-top: 20px">
			<div class="col-sm-9">
				<div class="container-fluid">
					
					<?php
						//query DB for products, place them into array
						$query = mysqli_query($mysqli, "SELECT * FROM products ORDER by id ASC");
						
						// if everything works
						if(mysqli_num_rows($query)>0):
							while($product = mysqli_fetch_assoc($query)):
                	?>
							
							<!-- Loop through the products and display them on the page -->
					<div class="col-sm-4 ">
						<form method="post" action="addToCart.php?id=add&id=<?php echo $product['id']; ?>">
							<div class="products">
								<img src="<?php echo $product['image']; ?>" class="img-responsive" />
								<h4 class="text-info">
									<?php echo $product['name']; ?>
								</h4>
								<h4>$
									<?php echo $product['price']; ?>
								</h4>
								<input type="text" name="quantity" class="form-control" value="1" />
								<input type="hidden" name="name" value="<?php echo $product['name']; ?>" />
								<input type="hidden" name="price" value="<?php echo $product['price']; ?>" />
								<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-info" value="Add to Cart" />
							</div>
						</form>
					</div>
				
				<?php
							endwhile;
						endif;   
        		?>

				</div>
			</div>
			
						<!-- Create shopping cart as a table -->
			<div class="col-sm-3">
				<form class= "paypal" method= "post" action="payments.php" id="paypal_form" target="_blank">
					<input type="hidden" name="cmd" value="_xclick" />
					<input type="hidden" name="no_note" value="1" />
					<input type="hidden" name="lc" value="US" />
					<input type="hidden" name="currency_code" value="USD" />
					<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
					<input type="hidden" name="first_name" value="Customer's First Name" />
					<input type="hidden" name="last_name" value="Customer's Last Name" />
					<input type="hidden" name="payer_email" value="customer@example.com" />
					<input type="hidden" name="item_number" value="123456" / >
					<?php getShoppingCart(); ?>
					<input type="submit" name="submit" value="Submit Payment"/>
				</form>
			</div>
		</div>
	</body>
</html>