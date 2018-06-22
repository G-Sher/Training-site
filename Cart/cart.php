<?php
session_start();
$product_ids = array();
//session_destroy();

//check if Add to Cart button has been submitted
if(filter_input(INPUT_POST, 'add_to_cart')){
    if(isset($_SESSION['shopping_cart'])){
        
        //keep track of how mnay products are in the shopping cart
        $count = count($_SESSION['shopping_cart']);
        
        //create sequantial array for matching array keys to products id's
        $product_ids = array_column($_SESSION['shopping_cart'], 'id');
        
        if (!in_array(filter_input(INPUT_GET, 'id'), $product_ids)){
        $_SESSION['shopping_cart'][$count] = array
            (
                'id' => filter_input(INPUT_GET, 'id'),
                'name' => filter_input(INPUT_POST, 'name'),
                'price' => filter_input(INPUT_POST, 'price'),
                'quantity' => filter_input(INPUT_POST, 'quantity')
            );   
        }
        else { //product already exists, increase quantity
            //match array key to id of the product being added to the cart
            for ($i = 0; $i < count($product_ids); $i++){
                if ($product_ids[$i] == filter_input(INPUT_GET, 'id')){
                    //add item quantity to the existing product in the array
                    $_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
                }
            }
        }
        
    }
    else { //if shopping cart doesn't exist, create first product with array key 0
        //create array using submitted form data, start from key 0 and fill it with values
        $_SESSION['shopping_cart'][0] = array
        (
            'id' => filter_input(INPUT_GET, 'id'),
            'name' => filter_input(INPUT_POST, 'name'),
            'price' => filter_input(INPUT_POST, 'price'),
            'quantity' => filter_input(INPUT_POST, 'quantity')
        );
    }
}

if(filter_input(INPUT_GET, 'action') == 'delete'){
    //loop through all products in the shopping cart until it matches with GET id variable
    foreach($_SESSION['shopping_cart'] as $key => $product){
        if ($product['id'] == filter_input(INPUT_GET, 'id')){
            //remove product from the shopping cart when it matches with the GET id
            unset($_SESSION['shopping_cart'][$key]);
        }
    }
    //reset session array keys so they match with $product_ids numeric array
    $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
}

//pre_r($_SESSION);

function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}
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
	<style>
	.banner {
		margin: 1%;
		text-align: center;
		font-size: 2em;
		border-style: solid;
		border-width: 2px;
		margin-left: auto;
		margin-right: auto;
		width: 90%;
		padding: 10px;
	}
	</style>
    <body>

        <div class="container-fluid">
        <?php


        $connect = mysqli_connect('localhost', 'root', '' ,'cart');
		$sql = "DROP TABLE products";
		$connect->query($sql);

		$sql = "CREATE TABLE IF NOT EXISTS products (id int(11) NOT NULL AUTO_INCREMENT, name varchar(100) NOT NULL, image varchar(100) NOT NULL, price float NOT NULL, PRIMARY KEY (id))";
		$connect->query($sql);

		$sql = "INSERT INTO products(id, name, price, image) VALUES
		('1', 'Small Basket with Apples', '19.99', 'basket1.jpg'),
		(2, 'Small Basket', 18.99, 'basket4.jpg'),
		(3, 'Medium Basket with Apples', 24.99, 'basket1.jpg'),
		(4, 'Medium Basket', 23.99, 'basket4.jpg'),
		(5, 'Large Basket with Apples', 29.99, 'basket1.jpg'),
		(6, 'Large Basket', 28.99, 'basket4.jpg')";
		$connect->query($sql);
		
        $query = 'SELECT * FROM products ORDER by id ASC';
        $result = mysqli_query($connect, $query);

        if ($result):
            if(mysqli_num_rows($result)>0):
                while($product = mysqli_fetch_assoc($result)):
                ?>
                <div class="col-sm-4 col-md-3" >
                    <form method="post" action="cart.php?action=add&id=<?php echo $product['id']; ?>">
                        <div class="products">
                            <img src="<?php echo $product['image']; ?>" class="img-responsive" />
                            <h4 class="text-info"><?php echo $product['name']; ?></h4>
                            <h4>$ <?php echo $product['price']; ?></h4>
                            <input type="text" name="quantity" class="form-control" value="1" />
                            <input type="hidden" name="name" value="<?php echo $product['name']; ?>" />
                            <input type="hidden" name="price" value="<?php echo $product['price']; ?>" />
                            <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-info"
                                   value="Add to Cart" />
                        </div>
                    </form>
                </div>
                <?php
                endwhile;
            endif;
        endif;   
        ?>
		
        <div style="clear:both"></div>  
			<div class="banner">
			<div>
				Enter the promo code
				<strong style="color:green">APPLE50</strong> to save 50% on a second basket at checkout<br> when you order any basket containing apples.
				<br>
				<font size="2">*Discount applies to items of equal or lesser value.</font>
			</div>
			</div>
        <br />  
        <div class="table-responsive">  
        <table class="table">  
            <tr><th colspan="5"><h3>Order Details</h3></th></tr>   
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
        ?>  
        <tr>  
           <td><?php echo $product['name']; ?></td>  
           <td><?php echo $product['quantity']; ?></td>  
           <td>$ <?php echo $product['price']; ?></td>  
           <td>$ <?php echo number_format($product['quantity'] * $product['price'], 2); ?></td>  
           <td>
               <a href="cart.php?action=delete&id=<?php echo $product['id']; ?>">
                    <div class="btn-danger">Remove</div>
               </a>
           </td>  
        </tr>  
        <?php  
                  $total = $total + ($product['quantity'] * $product['price']);  
             endforeach;  
        ?>  
					<?php $discountString = $_GET['discountcode'];?>

        <tr>  
             <td colspan="3" align="right">Total</td>  
             <td align="left"><strong>$ <?php echo number_format($total, 2); ?></strong></td>  
             <td></td>  
        </tr> 
		<tr>
			 <td colspan="4" align="right"><form method="GET">Enter Discount Code:<input type ="text" id="discountcode" name="discountcode"></form></td>
			<td><a href="#" class="btn-success">Apply</a></td>

</td>
 
</tr>		
        <tr>
            <!-- Show checkout button only if the shopping cart is not empty -->
            <td colspan="5" align="right">
             <?php 
                if (isset($_SESSION['shopping_cart'])):
                if (count($_SESSION['shopping_cart']) > 0):
             ?>

                <a href="applydiscount()" class="button">Checkout</a>
             <?php endif; endif; ?>
            </td>
        </tr>
        <?php  
        endif;
		
		function applydiscount($discountString){
			if ($discountString == 'APPLY50'){
			echo "Discount Applied";}
			else {
			echo "incorrect code";}
		}
        ?>  
        </table>  
         </div>
        </div>
    </body>
</html>