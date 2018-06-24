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
echo "<br>";

}
function apply_discount($product){
	array_search($product);
	
}

function removeFromCart()
{

	//Runs when the user presses the remove from cart button

	if(isset($_POST['id']))
	{
	
		$productID = $_POST['id'];

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
			header('Location: cart.php');
		
		}
	
	}
	else
	{
		
		//No Product with that ID redirect and display message
		notify('Sorry but there is no product with that ID.', 0);
		header('Location: cart.php');
	
	}

}
//check if Add to Cart button has been submitted
if(filter_input(INPUT_POST, 'add_to_cart')){

    if(isset($_SESSION['shopping_cart'])){
        
        //keep track of how many products are in the shopping cart
        $count = count($_SESSION['shopping_cart']);

        //create sequantial array for matching array keys to products id's
        $product_ids = array_column($_SESSION['shopping_cart'], 'id');



}

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

            for ($i = 0; $i < count($product_ids); $i++){														//
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

function getShoppingCart()
{
	    //Function creates the display for the cart
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
                        <td><a href="addToCart.php?ID='.$product['id'].'">Add</a><a href="removeFromCart.php?ID='.$product['id'].'">Remove</a></td>
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

	else
	{
		//If there are no products then print out a message saying there are no products
		echo '<p>There are currently no products in your cart.</p>';
	}
}
?>