<?php
include "../config.php";
require_once "../Models/create_product.php";

// Define variables and initialize with empty values
$name = "";
$description = "";
$price = "";
$image = "";
$number_of_units = "";

//Define and initailize variable errors
$name_err = "";
$description_err = "";
$price_err = "";
$img_err = "";
$number_of_units_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter the product name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
   
    
    // Validate description
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Please enter a product description.";     
    } else{
        $description = $input_description;
    }
    
    // Validate price
    $input_price = trim($_POST["price"])+0;
    if(empty($input_price)){
        $price_err = "Please enter the unit price.";     
    } elseif (is_float($input_price)){
        $price = $input_price;
    } elseif(!ctype_digit($input_price)){
        $price_err = "Please enter a positive integer value.";
    } else{
        $price = $input_price;
    }
     
     // Validate number of units
     $input_number_of_units = trim($_POST["number_of_units"]);
     if(empty($input_number_of_units)){ 
         $number_of_units_err = "Please enter the number of units.";     
     } elseif(!ctype_digit($input_number_of_units)){
         $number_of_units_err = "Please enter a positive integer value.";
     } else{
         $number_of_units = $input_number_of_units;
     }

     // Setting the array of variables to be entered into the sql function
     $variables = [$name, $description, $price, $number_of_units];
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($description_err) && empty($price_err) && empty($number_of_units_err)){

        // Seperated out SQL logic
        create_product($conn, $name, $description, $price, $number_of_units);
    } else {
        echo "Something went wrong please refresh and try again";
        mysqli_close($conn);
    }
}

?>