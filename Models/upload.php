<?php 
 
$statusMsg = ''; 
$img_err = '';
// File upload directory 
$targetDir = "../uploads/"; 


$product_id = mysqli_insert_id($conn);

    if(!empty($_FILES["file"]["name"])){ 
        $file_name = basename($_FILES["file"]["name"]); 
    
        $targetFilePath = $targetDir . $file_name;
      
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION); 
    
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg'); 
        if(in_array($fileType, $allowTypes)){ 
        
        $result = move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);
        
        // Upload file to server 
        if($result){ 
        $sql = "INSERT INTO images (file_name, product_id) VALUES (?, ?)";
        
        // handles image upload into the database
            if($stmt = mysqli_prepare($conn, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "si", $param_file_name, $param_product_id);
                
                // Set parameters
                $param_file_name = $file_name;
                $param_product_id = $product_id;      
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Records created successfully. Redirect to landing page
                    header("location: index.php");
                    exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }else{
            echo "eek it did not work";
        }
    } else {
        $img_err = "Please enter a valid file type .jpg .png .jpeg";
    }
}
 
// Display status message 
echo $statusMsg; 
return $img_err;


?>