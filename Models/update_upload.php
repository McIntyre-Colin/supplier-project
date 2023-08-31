<?php 
 
$statusMsg = '';
// File upload directory 
$targetDir = "../uploads/"; 

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Check input errors before inserting in database
    if(!empty($_FILES["file"]["name"])){
        $file_name = basename($_FILES["file"]["name"]); 
    
        $targetFilePath = $targetDir . $file_name; 
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION); 
    
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg'); 
        if(in_array($fileType, $allowTypes)){ 

        //Allows for new pictures to be uploaded
        $result = move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);
        // Prepare an update statement
        $sql = "UPDATE images SET file_name=? WHERE product_id=?";
         
        if($imgStmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($imgStmt, "si", $param_file_name, $param_product_id);
            
            // Set parameters
            $param_file_name = $file_name;
            $param_product_id = $id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($imgStmt)){
                // Records created successfully. Redirect to landing page
                header("location: ../index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($imgStmt);
    }
    
   
}
} else {

    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM images WHERE product_id=?";
        if($imgStmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($imgStmt, "i", $param_product_id);
            // Set parameters
            $param_product_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($imgStmt)){
                $imgResult = mysqli_stmt_get_result($imgStmt);
                
    
                if(mysqli_num_rows($imgResult) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $imgRow = mysqli_fetch_array($imgResult, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $imgName = $imgRow["file_name"];
                    $product_id = $imgRow["product_id"];
                    $targetFilePath = $targetDir . $imgName;
                    $imgCheck = 1;
                } 
                else{
                    // Prepare all info such that the update file still runs
                    $targetFilePath ="";
                    $imgName = "";
                    $imgCheck = 0;
                    mysqli_stmt_close($imgStmt);
                    return $targetFilePath;
                    return $imgCheck;
                    return $imgName;
                    exit();
                }
                
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }else{
            echo "weewoo no image weewoo";
        }
        // Close statement
        mysqli_stmt_close($imgStmt);
        
        return $targetFilePath;
        return $imgCheck;
        return $imgName;
        exit();
    }  else{
        echo "are we in the failed statement?";
        // URL doesn't contain id parameter. Redirect to error page
        header("location: ../Views/error.php");
        exit();
    }
}

?>
