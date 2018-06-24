<?php

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
	
<body>

	<div class="container-fluid">
		<?php
				
			$query = mysqli_query($mysqli, "SELECT * FROM products ORDER by id ASC");
				
				if(mysqli_num_rows($query)>0):
					while($product = mysqli_fetch_assoc($query)):
        ?>
			<div class="col-sm-4 col-md-3">
				<form method="post" action="cart.php?action=add&id=<?php echo $product['id']; ?>">
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

		<div style="clear:both"></div>
<!-- 					<div class="banner">
						<div>
							Enter the promo code
							<strong style="color:green">APPLE50</strong> to save 50% on a second basket at checkout
							<br> when you order any basket containing apples.
							<br>
							<font size="2">*Discount applies to items of equal or lesser value.</font>
						</div>
					</div> -->
			<br />
			<div class="table-responsive">
				<table class="table">
					<tr>
						<th colspan="5">
							<h3>Order Details</h3>
						</th>
					</tr>
					<tr>
                        <th width="40%">Product Name</th>
                        <th width="10%">Quantity</th>
						<th width="20%">Price</th>
						<th width="15%">Total</th>
						<th width="5%">Action</th>
					</tr>
		<?php   
            if(!empty($_SESSION['shopping_cart'])):  
                
                $total = 0;  
                
                foreach($_SESSION['shopping_cart'] as $key => $product): 
                print_r(array_values($product));
                echo "<br>";
                //array_walk_recursive($product, "checkForDiscount");
                echo "<br>";
                array_push($discount_basket, $product);
        ?>
					<tr>
						<td>
							<?php echo $product['name']; ?>
						</td>
						<td>
							<?php echo $product['quantity']; ?>
						</td>
						<td>$
							<?php echo $product['price']; ?>
						</td>
						<td>$
							<?php echo number_format($product['quantity'] * $product['price'], 2); ?>
						</td>
						<td>
							<a href="cart.php?action=delete&id=<?php echo $product['id']; ?>">
								<div class="btn-danger">Remove</div>
							</a>
						</td>
					</tr>
		<?php  
                    $total = $total + ($product['quantity'] * $product['price']);  
                endforeach; 
			    print_r(array_values($discount_basket));
			    echo "<br><br>";
			    array_walk_recursive($discount_basket, "checkForDiscount");

        ?>

					<tr>
						<td colspan="3" align="right">Total</td>
						<td align="left">
							<strong>$
								<?php echo number_format($total, 2); ?>
							</strong>
						</td>
						<td></td>
					</tr>
<!-- 							<tr>
								<td colspan="4" align="right">
									<form method="POST">Enter Discount Code:
										<input type="text" id="discountcode" name="discountcode">
									</form>
								</td>
								<td>
									<a href="applydiscount.php" class="btn-success">Apply</a>
								</td>

								</td>

							</tr> */
							<tr>
-->
								<!-- Show checkout button only if the shopping cart is not empty -->

						<td colspan="5" align="right">
			<?php 
                if (isset($_SESSION['shopping_cart'])):
                if (count($_SESSION['shopping_cart']) > 0):
            ?>

							<a href="#"class="button"  name="checkout" >Checkout</a>
							<?php endif; endif; ?>
						</td>
					</tr>
					<?php  
        endif;

    

        ?>
						</table>
						
					</div>
		</div>
<!-- TEST PHP ARRAY CONTENTS -->
<?php

?>
	</body>

	</html>