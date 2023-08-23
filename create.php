
<?php
// Include config file
include "config.php";
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
$image_err = "";
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
        $sql = "INSERT INTO products (name, description, number_of_units, price) VALUES (?, ?, ?, ?)";
        echo "this is the sql statement $sql";
        // handles image upload into the database

         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssis", $param_name, $param_description, $param_number_of_units, $param_price);
            
            // Set parameters
            $param_name = $name;
            $param_description = $description;
            $param_price = $price;
            $param_number_of_units = $number_of_units;

            echo "\n\n the param name is $param_name";
           
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                $gen = mysqli_insert_id($conn);
                printf("New record has ID %d.\n", mysqli_insert_id($conn));
                require "upload.php";
                header("location: index.php");
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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
        <div class="container-fluid">
            <div class="row">
            <h1>HELLO CREATE PAGE</h1>
                <div class="col-md-12">
                    <h2 class="mt-5">Create Product Record</h2>
                    <p>Please fill this form and submit to add your product to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"><?php echo $description; ?></textarea>
                            <span class="invalid-feedback"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Number of Units</label>
                            <input type="number" name="number_of_units" class="form-control <?php echo (!empty($number_of_units_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $number_of_units; ?>">
                            <span class="invalid-feedback"><?php echo $number_of_units_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Price per Unit</label>
                            <input type="text" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="file" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $image; ?>">
                            <span class="invalid-feedback"><?php echo $image_err;?></span>
                        </div>
                        
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>