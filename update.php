<?php
// Include config file
include "config.php";
 
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
     $input_price = trim($_POST["price"]);
     if(empty($input_price)){
         $price_err = "Please enter the unit price.";     
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
          $price_err = "Please enter a positive integer value.";
      } else{
          $number_of_units = $input_number_of_units;
      }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($description_err) && empty($price_err) && empty($number_of_units_err)){
        // Prepare an insert statement
        $sql = "UPDATE products SET name=?, description=?, number_of_units=?, price=? WHERE id=?";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssisi", $param_name, $param_description, $param_number_of_units, $param_price, $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_description = $description;
            $param_price = $price;
            $param_number_of_units = $number_of_units;
            $param_id = $id;

            
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                echo "records updated correctly";
                // Prepare the update for the image file if the user chooses to do so
                include "update_upload.php";
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM products WHERE id=?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["name"];
                    $description = $row["description"];
                    $number_of_units = $row["number_of_units"];
                    $price = $row["price"];
                    // Prepare to update the image
                    require "update_upload.php";
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
             
        // Close connection
        mysqli_close($conn);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
    <h1>HELLO UPDATE PAGE</h1>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the PRODUCT record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" value="<?php echo $name; ?>" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" value="<?php echo $description; ?>" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"><?php echo $description; ?></textarea>
                            <span class="invalid-feedback"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Number of Units</label>
                            <input type="number" name="number_of_units" value="<?php echo $number_of_units; ?>" class="form-control <?php echo (!empty($number_of_units_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $number_of_units; ?>">
                            <span class="invalid-feedback"><?php echo $number_of_units_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Price per Unit</label>
                            <input type="text" name="price" value="<?php echo $price; ?>" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <p><b><?php echo ($imgCheck == 1) ? "<img src=" . $targetFilePath . ">" . " " . $imgName ."" : "No image"?></b></p>
                            <input type="file" name="file" value="<?php echo "$imgName"; ?>">
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>