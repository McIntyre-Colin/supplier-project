<?php 
// Seperated out logic for the read page

function read_product($conn, $id)
    {
    // Establish target dir for image retrieval
    $targetDir = "../uploads/"; 
    $imgCheck = 0;

    // Prepare a select statement
    $sql = "SELECT * FROM products WHERE id = ?";
    $img = "SELECT * FROM images WHERE product_id = ?";

    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = $id;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            // Run same prompt for seleting the image
            $imgStmt = mysqli_prepare($conn, $img);
            mysqli_stmt_bind_param($imgStmt, "i", $param_id);
            mysqli_stmt_execute($imgStmt);
            $imgResult = mysqli_stmt_get_result($imgStmt);
            

            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $name = $row["name"];
                $description = $row["description"];
                $price = $row["price"];
                $number_of_units = $row["number_of_units"];

                // If tree for images
                if(mysqli_num_rows($imgResult) == 1){
                    $imgRow = mysqli_fetch_array($imgResult, MYSQLI_ASSOC);
                    $imgName = $imgRow["file_name"];

                    $targetFilePath = $targetDir . $imgName;
                    $imgCheck = 1;
                } else {
                    echo "$imgCheck does not pass the vibe check";
                }

            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);


    $row['targetFilePath'] = $targetFilePath;
    $row['imgCheck'] = $imgCheck;
    return $row;
    }
?>