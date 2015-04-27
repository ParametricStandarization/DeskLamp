<?php
if(!isset($_POST['product']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}


$product = $_POST['product'];

if($product === 'diy') {
  $shape = $_POST['shape'];
  $dimension = $_POST['dimension'];
  $system = $_POST['system'];
  $cap = $_POST['cap'];
} else {
  $material = $_POST['material'];
  $fixing = $_POST['fixing'];
  $cap = $_POST['capProduct'];
}
$visitor_email = $_POST['email'];

//Validate first
if(empty($visitor_email)) 
{
    echo "Name and email are mandatory!";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Bad email value!";
    exit;
}
if($product === 'diy') {
 $mailtosend = "an order has been placed for a DIY kit \n\n".
  "shape: $shape \n".
  "dimension: $dimension $system \n".
  "cap: $cap \n\n";
} else {
   $mailtosend = "an order has been placed for a complete lamp \n\n".
  "material: $material \n".
  "fixing: $fixing \n".
  "cap: $cap \n\n";
}



$email_from = $visitor_email ;//<== update the email address
$email_subject = "New Form submission";
$email_body = $mailtosend;
$to = "order@ps-desklamp.com";//<== update the email address
$headers = "From: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.


echo "<p>thank you for the order</p>";
echo "$to + $email_subject + $email_body + $headers + product = $product";


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
   
?> 