<?php
session_start();
$product_ids = array();
$discount_basket = array();
$no_discount = array();

function checkForDiscount($value, $key){
		echo "Key is ".$key."<br>";
	echo "Value is ".$value."<br>";

	if($key == 'id'){
		if ($value == 2 || $value == 4 || $value == 6){
			echo "This basket will apply a discount to smaller baskets<br>";
			//array_merge($discount_basket);
		}
		
		else {
			echo "This basket will NOT apply a discount to smaller baskets<br>";
			//array_merge($value,$no_discount);
		}
}

}
function apply_discount($product){
	array_search($product);
	
}

function removeFromCart()
{

	//Runs when the user presses the remove from cart button
        if(isset($_GET['id']))
        {
        
            $productID = $_GET['id'];

            //Check if the product exists within the cart if so follow on
            if(array_key_exists($productID, $_SESSION['shopping_cart']))
            {
            
                //Remove one from the total quantity of products set in the cart
                $newQty = $_SESSION['shopping_cart'][$productID]['quantity'] - 1;
                
                //Update the cart quantity
                $_SESSION['shopping_cart'][$productID]['quantity'] = $newQty;
                
                //If there are less than 1 in the qty subkey then remove the product from the cart
                if($newQty < 1)
                {
                    
                    //Remove the product from the cart
                    unset($_SESSION['shopping_cart'][$productID]);
                
                }
                
                //No Product with that ID redirect and display message
                notify('Removed 1 item from the cart.', 1);
                header('Location: cart.php');
            
            }
            else
            {
            
                //No Product with that ID redirect and display message
                notify('Sorry but there is no product with that ID.', 0);
                header('Location: processorder.php');
            
            }
        
        }
    
    else
    {
            
        //No Product with that ID redirect and display message
        notify('Sorry but there is no product with that ID.', 0);
        header('Location: scFunctions.php');
        
    }

}

function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function getShoppingCart()
{
        //Function creates the display for the cart
    if(cartExists())
    {
		//Check if there are any products in the cart by counting the array keys
		if(count($_SESSION['shopping_cart']) > 0)
		{
			
			//The table header html
            $html = '
            <div class= "table-responsive">
                <table>
                    <tr>
                        <th width="10%">Product Name</th>
                        <th width="10%">Price</th>
                        <th width="10%">Qty</th>
                        <th width="10%"></th>
                    </tr>
			';
			
			$count = 1;
			
			//Loop through the items in the paypal cart
			foreach($_SESSION['shopping_cart'] as $product)
			{
			
				$html .= '
                    <tr>
                        <td>'.$product['name'].'</td>
                        <td>$'.number_format($product['price'], 2).'</td>
                        <td>'.$product['quantity'].'</td>
                        <td>
                            <form method="post" action="addToCart.php?id='.$product['id'].'">
                                <a href="addToCart.php?id='.$product['id'].'">Add</a>
                            </form>
                            <form method="post" action="removeFromCart.php?id='.$product['id'].'"> 
                                <input type="submit" class="btn btn-danger" value="Remove"><span class="glyphicon glyphicon-remove"></span></input></td>
                            </form>
                        <input type="hidden" name="amount_'.$count.'" value="'.$product['price'].'" />
                        <input type="hidden" name="quantity_'.$count.'" value="'.$product['quantity'].'" />
                        <input type="hidden" name="item_name_'.$count.'" value="'.stripslashes($product['name']).'" />
                        <input type="hidden" name="item_number_'.$count.'" value="'.$product['id'].'" />
                    </tr>
				';
				
				$count++;
			
			}
			
			//HTML for the subrows such as the subtotal, tax and total
			$html .= '
                    <tr class="empty">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="bold">Subtotal</td>
                        
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        
                        
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="bold">Total</td>
                        
                    </tr>
                
                </table>
            </div>	
		    <input type="submit" name="submit" id="submit" value="Checkout with PayPal" />
			
			';
			
			echo $html;
		
		}
    }
	else
	{
		//If there are no products then print out a message saying there are no products
		echo '<p>There are currently no products in your cart.</p>';
	}
}

function cartExists()
{

	//Function returns a bool depending wheather the paypal cart is set or not

	if(isset($_SESSION['shopping_cart']))
	{
	
		//Exists
		return true;
	
	}
	else
	{
		
		//Doesn't exist
		return false;
	
	}

}

function createCart()
{

	//Create a new cart as a session variable with the value being an array
	$_SESSION['shopping_cart'] = array();

}

function insertToCart($productID, $productName, $price, $qty = 1)
{

	//Function is run when a user presses an add to cart button

	//Check if the product ID exists in the paypal cart array
	if(array_key_exists($productID, $_SESSION['shopping_cart']))
	{
		//Calculate new total based on current quantity
		$newTotal = $_SESSION['shopping_cart'][$productID]['quantity'] + $qty;
		
		//Update the product quantity with the new total of products
		$_SESSION['shopping_cart'][$productID]['quantity'] = $newTotal;
	}
	else
	{
		//If the product doesn't exist in the cart array then add the product
		$_SESSION['shopping_cart'][$productID]['id'] = $productID;
		$_SESSION['shopping_cart'][$productID]['name'] = $productName;
		$_SESSION['shopping_cart'][$productID]['price'] = $price;
		$_SESSION['shopping_cart'][$productID]['quantity'] = $qty;
	
	}
}

function addToCart()
{
    include "scDB.php";
	//Function for adding a product to the cart based on that products ID.

	//Check if the ID variable is set
	if(isset($_GET['id']))
	{
	
		//Escape the string from the URL
		$ID = mysqli_real_escape_string($mysqli, $_GET['id']);
	
		//Check if the ID passed exists within the database
		$result = mysqli_query($mysqli, 'SELECT * FROM products WHERE ID = "'.$ID.'" LIMIT 1');
		
		//If the product ID exists in the database then insert it to the cart
		if($result->num_rows > 0)
		{
		
			while($row = $result->fetch_object())
			{
			
				//Check if the cart exists
				if(cartExists())
				{
					
					//The cart exists so just add it to the cart
					insertToCart($ID, $row->name, $row->price);
				
				}
				else
				{
				
					//The cart doesn't exist so create the cart
					createCart();
					
					//The cart is now created so add the product to the cart
					insertToCart($ID, $row->name, $row->price);
				
				}
			
			}
		
		}
		else
		{
			
			//No products were found in the database so notify the user, redirect him and stop the code from continuing
			notify('Sorry but there is no product with that ID.', 0);
			header('Location: cart.php');
			break;
		
		}
	
		//The product was successfully added so set the notification and redirect to the cart page
		notify('Product added to the cart.', 1);
		header('Location: cart.php');
	
	}
	else
	{
		
		//No Product with that ID redirect and display message
		notify('Sorry but there is no product with that ID.', 0);
		header('Location: cart.php');
	
	}

}
?>