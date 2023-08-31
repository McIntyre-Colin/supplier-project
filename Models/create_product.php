<?php
// Seperating out SQL logic from the view

function create_product($conn, $name, $description, $price, $number_of_units)
    {
        $sql = "INSERT INTO products (name, description, number_of_units, price) VALUES (?, ?, ?, ?)";
        //  this is the sql statement $sql;

        // Using prepare to protect against sql injections
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssis", $param_name, $param_description, $param_number_of_units, $param_price);
            
            // Set parameters
            $param_name = $name;
            $param_description = $description;
            $param_price = $price;
            $param_number_of_units = $number_of_units;       
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                $gen = mysqli_insert_id($conn);
                printf("New record has ID %d.\n", mysqli_insert_id($conn));
                require "../Models/upload.php";
                header("location: ../index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }


?>
