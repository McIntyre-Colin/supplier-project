<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    include "config.php";

    // Establish target dir for image retrieval
    $targetDir = "uploads/"; 
    $imgCheck = 0;
    
    // Prepare a select statement
    $sql = "SELECT * FROM products WHERE id = ?";
    $img = "SELECT * FROM images WHERE product_id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
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
    
    // Close connection
    mysqli_close($conn);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
    <h1>HELLO READ PAGE</h1>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Name</label>
                        <p><b><?php echo $row["name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <p><b><?php echo $row["description"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <p><b><?php echo $row["price"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Number of Units</label>
                        <p><b><?php echo $row["number_of_units"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Images</label>
                        <p><b><?php echo ($imgCheck == 1) ? "<img src=" . $targetFilePath . ">" : "No image"?></b></p>
                        
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                    <p><?php echo '<a href="update.php?id='. $param_id .'" class="btn btn-primary"> Update </a>';?></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>