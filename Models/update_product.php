<?php
// Handles the actual update process
function update_product($conn, $id, $name, $description, $price, $number_of_units)
    {
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
                 require "../Models/update_upload.php";
                 header("location: ../index.php");
                 exit();
             } else{
                 echo "Oops! Something went wrong. Please try again later.";
             }
         }
         // Close statement
         mysqli_stmt_close($stmt);
     
     
 
    }

// Effectively funcitons as a different read so all relevant and currrent data can be automatically entered into the fields
function get_product_info($conn, $id)
    {
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
                    // Seperate model to update the image
                    require "../Models/update_upload.php";
                
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
     
    
    // Preparing all the data in the row array to ensure all relevant information gets passed to the controller
    $row['targetFilePath'] = $targetFilePath;
    $row['imgCheck'] = $imgCheck;
    $row['imgName'] = $imgName;
    return $row;
    }

?>