<?php
// Seperated out "business logic"
// Even though it's not a lot this is seperated so that
// It can get updated easily later


require "../Models/read_product.php";

// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    $param_id = trim($_GET["id"]);
    $row = read_product($conn, $param_id);
   $targetFilePath = $row['targetFilePath'];
   $imgCheck = $row['imgCheck'];
   

   // Close connection
   mysqli_close($conn);

} else{
   
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}



?>