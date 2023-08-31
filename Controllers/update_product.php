<?php
// Required Files
require "../config.php";
require "../Models/update_product.php";

// Define variables and initialize with empty values
$name = "";
$description = "";
$price = "";
$file_name = "";
$number_of_units = "";


//Define and initailize variable errors
$name_err = "";
$description_err = "";
$price_err = "";
$image_err = "";
$number_of_units_err = "";
 
// Processing form data when form is submitted
// Error handleing on the backend as to protect against JS shenanigans
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
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
         $price_err = "Please enter a positive value.";
     } else{
         $price = $input_price;
     }
 
      
      // Validate number of units
      $input_number_of_units = trim($_POST["number_of_units"]);
      if(empty($input_number_of_units)){
          $number_of_units_err = "Please enter the number of units.";     
      } elseif(!ctype_digit($input_number_of_units)){
          $number_of_units_err = "Please enter a positive value.";
      } else{
          $number_of_units = $input_number_of_units;
      }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($description_err) && empty($price_err) && empty($number_of_units_err)){
        //Runs updates with entered parameters so long as there are no errors
        update_product($conn, $id, $name, $description, $price, $number_of_units);
        mysqli_close($conn);
    }
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        $row = get_product_info($conn, $id);
        $name = $row["name"];
        $description = $row['description'];
        $price = $row['price'];
        $number_of_units = $row['number_of_units'];
        $targetFilePath = $row['targetFilePath'];
        $imgCheck = $row['imgCheck'];
        $imgName = $row['imgName'];
       
        
        
        // Close connection
        mysqli_close($conn);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}


?>