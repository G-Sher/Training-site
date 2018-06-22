<?php
//processorder.php, create short variable names
$smlQtyWith = (int) $_POST['smlQtyWith'];
$smlQtyWO = (int) $_POST['smlQtyWO'];
$medQtyWith = (int) $_POST['medQtyWith'];
$medQtyWO = (int) $_POST['medQtyWO'];
$lrgQtyWith = (int) $_POST['lrgQtyWith'];
$lrgQtyWO = (int) $_POST['lrgQtyWO'];
$discountcode = (string) $_POST['find'];
$document_root = $_SERVER['DOCUMENT_ROOT'];
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title> Rob Anderson's Basket Test Results - Simple Version</title>
	</head>
	<style>
		table,
		th,
		td {
			border-style: solid;
			border-collapse: collapse;
		}
	</style>

	<body>
		<h2> Rob Anderson's Basket Test Results - Simple Version </h2>
		<?php
echo "<p> The following order placed at ".date('H:i, jS F Y')."</p>";
$smlQty = $smlQtyWO+$smlQtyWith;
$medQty = $medQtyWO+$medQtyWith;
$lrgQty = $lrgQtyWO+$lrgQtyWith;
$totalqty = $smlQty + $medQty + $lrgQty; 




//define prices
//Update: changed values from floats to integers
define('SMALLPRICE',1999); define('MEDPRICE',2499); define('LARGEPRICE',2999);

//variables for calculating discounts
$smlSubtotal = (($smlQtyWO+$smlQtyWith)*SMALLPRICE);
$medSubtotal = (($medQtyWO+$medQtyWith)*MEDPRICE); 
$lrgSubtotal = (($lrgQtyWO+$lrgQtyWith)*LARGEPRICE); 

//accumulators for discounts of different-sized baskets
$smlDiscount = 0 ;
$medDiscount = 0 ;
$lrgDiscount = 0 ;
$totalDiscount = 0 ;

$subtotal = $smlSubtotal + $medSubtotal + $lrgSubtotal ; 
 
echo "<p><strong>//Basket SubTotal Before Discount</strong> </p>";
echo "<table style='text-align:center'><tr><th>Basket type</th><th>Quantity</th><th>Price Each</th><th>Subtotal</th></tr>";
echo "<tr><td>Small w/o Apples: </td><td>".$smlQtyWO."</td><td>$".(SMALLPRICE/100)."</td><td>$".(($smlQtyWO*SMALLPRICE)/100)."</td></tr>";
echo "<tr><td>Small with Apples: </td><td>".$smlQtyWith."</td><td>$".(SMALLPRICE/100)."</td><td>$".(($smlQtyWith*SMALLPRICE)/100)."</td></tr>";
echo "<tr><td>Medium w/o Apples: </td><td>".$medQtyWO."</td><td>$".(MEDPRICE/100)."</td><td>$".(($medQtyWO*MEDPRICE)/100)."</td></tr>";
echo "<tr><td>Medium with Apples: </td><td>".$medQtyWith."</td><td>$".(MEDPRICE/100)."</td><td>$".(($medQtyWith*MEDPRICE)/100)."</td></tr>";
echo "<tr><td>Large w/o Apples: </td><td>".$lrgQtyWO."</td><td>$".(LARGEPRICE/100)."</td><td>$".(($lrgQtyWO*LARGEPRICE)/100)."</td></tr>";
echo "<tr><td>Large with Apples: </td><td>".$lrgQtyWith."</td><td>$".(LARGEPRICE/100)."</td><td>$".(($lrgQtyWith*LARGEPRICE)/100)."</td></tr>";
echo "<tr><td>Subtotal:</td><td></td><td></td><td>$".number_format((remove_trail_100($subtotal)),2)."</td</tr></table>";



if ($totalqty == 0){ echo "You did not order anything on the previous page!<br />";}
else{ 

$discount = 1; 
$applied = "NO";
if (($smlQtyWith || $medQtyWith || $lrgQtyWith) > 0 ){
switch ($discountcode) {
    case "0":
        $discount = 0.50 ; 
		$applied = "YES"; 
        break;
    case "1":
        $discount = 1 ;
		$applied = "NO"; 

        break;

	default:
        $discount = 1;
}
}
echo "<p><strong>//CHECK FOR DISCOUNT</strong></p>";
echo "//Discount triggered? : ".$applied."<br>";

echo "<p><strong>//Calculate Discount</strong></p>";
if ($applied != 'NO'){
while ($lrgQtyWith > 0 ){	
if ($lrgQtyWith >= 1){
	if ($lrgQty > 0){
		$lrgSubtotal = (($lrgQty * LARGEPRICE)+(LARGEPRICE*$discount));
		$formatter = (remove_trail(floor(LARGEPRICE*$discount)));		
		echo "//Large Basket Discount applied to 1 large basket for a savings of $".($formatter/100)."<br>";
		$subtotal = floor($subtotal - $formatter);
		echo " LOOP 1 PART 1 TEST: current subtotal: ".floor($subtotal)."<br><br>";	
		$lrgQtyWith -= 1;
		$lrgQty -= 1;
		$totalDiscount += ($formatter/100) ;
	}
	else if ($medQty > 0){
		$medSubtotal = (($medQty * MEDPRICE)+(MEDPRICE*$discount));
		$formatter = (remove_trail(floor(MEDPRICE*$discount)));		
		echo "//Large Basket Discount applied to 1 medium basket for a savings of $".($formatter/100)."<br>";
		$subtotal = floor($subtotal - $formatter);
		echo "LOOP 1 PART 2 TEST: current subtotal: ".floor($subtotal)."<br><br>";		
		$lrgQtyWith -= 1;
		$medQty -=1 ;
		$totalDiscount += ($formatter/100) ;

	}
	else if ($smlQty > 0){
		$smlSubtotal = (($medQty * SMALLPRICE)+(SMALLPRICE*$discount));
		$formatter = (remove_trail(floor(SMALLPRICE*$discount)));		
		echo "//Large Basket Discount applied to 1 medium basket for a savings of $".($formatter/100)."<br>";
		$subtotal = floor($subtotal - $formatter);
		echo "LOOP 1 PART 3 TEST: current subtotal: ".floor($subtotal)."<br><br>";		
		$lrgQtyWith -= 1;
		$smlQty -=1 ;
		$totalDiscount += ($formatter/100) ;
		
	}
	else
		echo "unable to apply a Large Basket discount<br>";
		$lrgQtyWith -= 1;

}
}//end while
while (($medQtyWith > 0) && ($medQty > 0) ){	
if ($medQtyWith >= 1){

	if (($medQtyWith > 1)&&($medQty >1)){
		$medSubtotal = (($medQty * MEDPRICE)+(MEDPRICE*$discount));
		$formatter = (remove_trail(floor(MEDPRICE*$discount)));		
		echo "//Medium Basket Discount applied to 1 medium basket for a savings of $".($formatter/100)."<br>";
		$subtotal = floor($subtotal - $formatter);
		echo "LOOP 2 PART 1 TEST: current subtotal: ".floor($subtotal)."<br><br>";		
		$medQtyWith -= 1;
		$medQty -=1 ;
		$totalDiscount += ($formatter/100) ;

	}
	else if (($medQty > 0)&&($smlQty >0)){
		$smlSubtotal = (($smlQty * SMALLPRICE)+(SMALLPRICE*$discount));
		$formatter = (remove_trail(floor(SMALLPRICE*$discount)));
		echo "//Medium Basket Discount applied to 1 small basket for a savings of $".($formatter/100)."<br>";
		$subtotal = floor($subtotal - $formatter);				
		$medQtyWith -= 1; 
		$smlQty -= 1 ;
		$totalDiscount += ($formatter/100) ;
		echo "LOOP 2 PART 2 TEST: current subtotal: ".floor($subtotal)."<br><br>";		

	}
	else{
		echo "unable to apply a Medium Basket discount<br><br>";
		$medQty -= 1;
}
}
}//end while 

while (($smlQty > 1)&&($smlQtyWith > 1)){
	$smlQty -= 1;
	if ($smlQty > 0){
		$smlSubtotal = (($smlQty * SMALLPRICE)+(SMALLPRICE*$discount));
		$formatter = (remove_trail(floor(SMALLPRICE*$discount)));
		echo "//Small Basket Discount applied to 1 small basket for a savings of $".($formatter/100)."<br>";
		$subtotal = floor($subtotal - $formatter);				
		$smlQtyWith -= 1; 
		$smlQty -= 1 ;
		$totalDiscount += ($formatter/100) ;
		echo "LOOP 3 PART 1 TEST: current subtotal: ".floor($subtotal)."<br><br>";		

	}//end if 
	else{
		echo "unable to apply a Small Basket discount<br><br>";
		}
	}//end while $sml
}//end big if statement
else{	echo "//Please select an additional basket with apples to receive a 50% discount on one basket of equal or lesser value .";}

}

echo "Total Discount Applied: $".remove_trail($totalDiscount)."<br><br>";
echo "<p><strong>//CALCULATE NEW TOTAL</strong></p>";
$tax = (($subtotal*8)/100);
$tax = remove_trail_100($tax);
$subtotal = remove_trail_100($subtotal);
//number_format used here, but all floating decimals after the hundredths place have been dropped with remove_trail_100() function
echo "<p>Your new subtotal is: $".$subtotal."<br>";
echo "+ 8% sales tax: $".remove_trail($tax)."<br>";
echo "<p>Your new total is: $".remove_trail($subtotal + $tax)."<br>";








//TEST CART WITH 1 of every item
//CHECK FOR DISCOUNT
//Discount triggered? : YES
//Calculate Discount
//Discount applied to 1 large basket for a savings of $15.00
//FUNCTIONS AS DIRECTED


//TEST REMOVE 1 LARGE WITH 
//CONTENTS: 1 LARGE WITH, 1 MED WITH, 1 MED WITHOUT, 1 SMALL WITH, 1 SMALL WITHOUT
//CHECK FOR DISCOUNT
//Discount triggered? : YES
//Calculate Discount
//Discount applied to 1 medium basket for a savings of $12.50
//FUNCTIONS AS DIRECTED

//TEST REMOVE 1 LARGE WITHOUT  
//CONTENTS: 1 MED WITH, 1 MED WITHOUT, 1 SMALL WITH, 1 SMALL WITHOUT
//CHECK FOR DISCOUNT
//Discount triggered? : YES
//Calculate Discount
//Discount applied to 1 medium basket for a savings of $12.50
//FUNCTIONS AS DIRECTED

//TEST REMOVE 1 MEDIUM WITH 
//CONTENTS:  1 MED WITHOUT, 1 SMALL WITH, 1 SMALL WITHOUT
//CHECK FOR DISCOUNT
//Discount triggered? : YES
//Calculate Discount
//Discount applied to 1 small basket for a savings of $10.00
//FUNCTIONS AS DIRECTED

//TEST REMOVE 1 MEDIUM WITHOUT
//CONTENTS:  1 SMALL WITH, 1 SMALL WITHOUT
//CHECK FOR DISCOUNT
//Discount triggered? : YES
//Calculate Discount
//Discount applied to 1 small basket for a savings of $10.00
//FUNCTIONS AS DIRECTED

//TEST REMOVE 1 SMALL WITH
//CONTENTS: 1 SMALL WITHOUT
//CHECK FOR DISCOUNT
//Discount triggered? : NO
//Calculate Discount
//Please select an additional basket with apples to receive a 50% discount on one basket of equal or lesser value .
//FUNCTIONS AS DIRECTED


//TEST ALL ITEMS INDIVIDUALLY



//TEST EMPTY CART
//You did not order anything on the previous page!
//FUNCTIONS AS DIRECTED
?>

<?php
//method to remove any floating decimals after the hundredths place 
//function also returns actual value (integer price / 100 ) (e.g. (int) 1000 == actual value of 10.00)
function remove_trail_100($number){

	$number = floor($number*100);
	$number = $number/100;	
	return $number/100;

		
}

function remove_trail($number){

	$number = floor($number*100);
	$number = $number/100;	
	return $number;

		
}
?>